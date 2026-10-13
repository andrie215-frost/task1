<?php

namespace App\Http\Controllers;

use App\Models\FindingOption;
use App\Models\JobPost;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MatchController extends Controller
{
    /**
     * Show the matching form.
     */
    public function index(Request $request): View
    {
        $user = $request->user()->load([
            'skilledProfile',
            'companyProfile',
            'skills',
        ]);

        abort_unless(
            in_array(
                $user->role,
                [
                    'skilled_person',
                    'company',
                ],
                true
            ),
            403
        );

        /*
         * Admin-managed positions.
         */
        $positionSuggestions = FindingOption::query()
            ->where('type', 'position')
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->values();

        /*
         * Admin-managed locations.
         */
        $locationSuggestions = FindingOption::query()
            ->where('type', 'location')
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->values();

        /*
         * Admin-managed job types.
         */
        $jobTypeOptions = FindingOption::query()
            ->where('type', 'job_type')
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->values();

        return view('matches.index', [
            'user' => $user,

            'skills' => Skill::query()
                ->orderBy('category')
                ->orderBy('name')
                ->get(),

            'positionSuggestions' => $positionSuggestions,

            'locationSuggestions' => $locationSuggestions,

            'jobTypeOptions' => $jobTypeOptions,
        ]);
    }

    /**
     * Find matching workers or job posts.
     */
    public function find(Request $request): View
    {
        $currentUser = $request->user();

        abort_unless(
            in_array(
                $currentUser->role,
                [
                    'skilled_person',
                    'company',
                ],
                true
            ),
            403
        );

        /*
         * Retrieve currently active Admin-managed options.
         *
         * These are also used for validation so users cannot
         * submit values that are not currently approved.
         */
        $activePositions = FindingOption::query()
            ->where('type', 'position')
            ->where('is_active', true)
            ->pluck('name')
            ->all();

        $activeLocations = FindingOption::query()
            ->where('type', 'location')
            ->where('is_active', true)
            ->pluck('name')
            ->all();

        $activeJobTypes = FindingOption::query()
            ->where('type', 'job_type')
            ->where('is_active', true)
            ->pluck('name')
            ->all();

        /*
         * Validate matching search criteria.
         */
        $criteria = $request->validate([
            'position' => [
                'required',
                'string',
                'max:255',
                Rule::in($activePositions),
            ],

            'location' => [
                'required',
                'string',
                'max:255',
                Rule::in($activeLocations),
            ],

            'job_type' => [
                'required',
                'string',
                Rule::in($activeJobTypes),
            ],

            'experience' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],

            'skill_ids' => [
                'nullable',
                'array',
            ],

            'skill_ids.*' => [
                'integer',
                'exists:skills,id',
            ],
        ]);

        /*
         * Skills are OPTIONAL.
         */
        $selectedSkillIds = collect(
            $criteria['skill_ids'] ?? []
        )
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        /*
         * =====================================================
         * COMPANY SEARCHING FOR WORKERS
         * =====================================================
         */
        if ($currentUser->role === 'company') {

            $results = User::query()
                ->where('role', 'skilled_person')
                ->whereHas(
                    'skilledProfile',
                    function ($query) {
                        $query->where(
                            'is_available',
                            true
                        );
                    }
                )
                ->with([
                    'skilledProfile',
                    'skills',
                ])
                ->get();

            $results = $results
                ->map(
                    function (User $worker) use (
                        $criteria,
                        $selectedSkillIds
                    ) {
                        $match = $this->calculateWorkerMatch(
                            $worker,
                            $criteria,
                            $selectedSkillIds
                        );

                        $worker->match_percentage =
                            $match['percentage'];

                        $worker->match_breakdown =
                            $match['breakdown'];

                        return $worker;
                    }
                )
                ->sortByDesc('match_percentage')
                ->values();

            $targetType = 'workers';

            $resultType = 'workers';
        }

        /*
         * =====================================================
         * WORKER SEARCHING FOR JOB POSTS
         * =====================================================
         */
        else {

            $results = JobPost::query()
                /*
                 * Only active/open jobs should be matched.
                 */
                ->where('status', 'open')
                ->with([
                    'company.companyProfile',
                    'skills',
                ])
                ->get();

            $results = $results
                ->map(
                    function (JobPost $jobPost) use (
                        $criteria,
                        $selectedSkillIds
                    ) {
                        $match = $this->calculateJobMatch(
                            $jobPost,
                            $criteria,
                            $selectedSkillIds
                        );

                        $jobPost->match_percentage =
                            $match['percentage'];

                        $jobPost->match_breakdown =
                            $match['breakdown'];

                        return $jobPost;
                    }
                )
                ->sortByDesc('match_percentage')
                ->values();

            $targetType = 'jobs';

            $resultType = 'jobs';
        }

        /*
         * Retrieve selected skill names.
         */
        $selectedSkills = Skill::query()
            ->whereIn(
                'id',
                $selectedSkillIds
            )
            ->orderBy('name')
            ->pluck('name');

        return view('matches.results', [
            'results' => $results,

            'targetType' => $targetType,

            /*
             * Lets the Blade know whether each result
             * is a worker or a job post.
             */
            'resultType' => $resultType,

            'selectedSkills' => $selectedSkills,

            'currentSkillIds' => $selectedSkillIds,

            'searchCriteria' => $criteria,
        ]);
    }

    /**
     * =========================================================
     * COMPANY -> WORKER MATCH
     * =========================================================
     *
     * Position    20
     * Location    20
     * Experience  15
     * Job Type    15
     * Skills      30 optional
     *
     * Without skills:
     * remaining criteria are normalized to 100%.
     */
    private function calculateWorkerMatch(
        User $worker,
        array $criteria,
        Collection $selectedSkillIds
    ): array {
        $profile = $worker->skilledProfile;

        if (! $profile) {
            return [
                'percentage' => 0,
                'breakdown' => [],
            ];
        }

        $earnedScore = 0;

        $possibleScore = 0;

        $breakdown = [];

        /*
         * -----------------------------------------------------
         * POSITION
         * -----------------------------------------------------
         */
        $positionScore = $this->calculateTextScore(
            $criteria['position'],
            $profile->professional_title,
            20
        );

        $earnedScore += $positionScore;

        $possibleScore += 20;

        $breakdown[] = [
            'name' => 'Position',

            'wanted' => $criteria['position'],

            'candidate' => $profile->professional_title,

            'earned' => $positionScore,

            'maximum' => 20,

            'status' => $this->matchStatus(
                $positionScore,
                20
            ),
        ];

        /*
         * -----------------------------------------------------
         * LOCATION
         * -----------------------------------------------------
         */
        $locationScore = $this->calculateTextScore(
            $criteria['location'],
            $profile->location,
            20
        );

        $earnedScore += $locationScore;

        $possibleScore += 20;

        $breakdown[] = [
            'name' => 'Location',

            'wanted' => $criteria['location'],

            'candidate' => $profile->location,

            'earned' => $locationScore,

            'maximum' => 20,

            'status' => $this->matchStatus(
                $locationScore,
                20
            ),
        ];

        /*
         * -----------------------------------------------------
         * EXPERIENCE
         * -----------------------------------------------------
         */
        $requiredExperience =
            (int) $criteria['experience'];

        $workerExperience =
            (int) $profile->experience_years;

        if ($requiredExperience === 0) {

            $experienceScore = 15;

        } elseif (
            $workerExperience >= $requiredExperience
        ) {

            $experienceScore = 15;

        } else {

            $experienceScore = (
                $workerExperience
                / $requiredExperience
            ) * 15;
        }

        $earnedScore += $experienceScore;

        $possibleScore += 15;

        $breakdown[] = [
            'name' => 'Experience',

            'wanted' =>
                $requiredExperience
                . ' year(s) minimum',

            'candidate' =>
                $workerExperience
                . ' year(s)',

            'earned' => $experienceScore,

            'maximum' => 15,

            'status' => $this->matchStatus(
                $experienceScore,
                15
            ),
        ];

        /*
         * -----------------------------------------------------
         * JOB TYPE
         * -----------------------------------------------------
         */
        $jobTypeScore =
            $profile->preferred_job_type
            === $criteria['job_type']
                ? 15
                : 0;

        $earnedScore += $jobTypeScore;

        $possibleScore += 15;

        $breakdown[] = [
            'name' => 'Job Type',

            'wanted' => $criteria['job_type'],

            'candidate' => $profile->preferred_job_type,

            'earned' => $jobTypeScore,

            'maximum' => 15,

            'status' => $this->matchStatus(
                $jobTypeScore,
                15
            ),
        ];

        /*
         * -----------------------------------------------------
         * SKILLS
         *
         * Only included when the company selected
         * required skills.
         * -----------------------------------------------------
         */
        if ($selectedSkillIds->isNotEmpty()) {

            $workerSkillIds =
                $worker->skills->pluck('id');

            $matchingSkills =
                $selectedSkillIds
                    ->intersect($workerSkillIds)
                    ->count();

            $skillsScore = (
                $matchingSkills
                / $selectedSkillIds->count()
            ) * 30;

            $earnedScore += $skillsScore;

            $possibleScore += 30;

            $breakdown[] = [
                'name' => 'Skills',

                'wanted' =>
                    $selectedSkillIds->count()
                    . ' required',

                'candidate' =>
                    $matchingSkills
                    . ' matched',

                'earned' => $skillsScore,

                'maximum' => 30,

                'status' => $this->matchStatus(
                    $skillsScore,
                    30
                ),
            ];
        }

        return $this->finishMatch(
            $earnedScore,
            $possibleScore,
            $breakdown
        );
    }

    /**
     * =========================================================
     * WORKER -> JOB POST MATCH
     * =========================================================
     *
     * The worker is matched against the real JobPost,
     * not vacancy fields in CompanyProfile.
     */
    private function calculateJobMatch(
        JobPost $jobPost,
        array $criteria,
        Collection $selectedSkillIds
    ): array {
        $earnedScore = 0;

        $possibleScore = 0;

        $breakdown = [];

        /*
         * -----------------------------------------------------
         * POSITION
         * -----------------------------------------------------
         */
        $positionScore = $this->calculateTextScore(
            $criteria['position'],
            $jobPost->title,
            20
        );

        $earnedScore += $positionScore;

        $possibleScore += 20;

        $breakdown[] = [
            'name' => 'Position',

            'wanted' => $criteria['position'],

            'candidate' => $jobPost->title,

            'earned' => $positionScore,

            'maximum' => 20,

            'status' => $this->matchStatus(
                $positionScore,
                20
            ),
        ];

        /*
         * -----------------------------------------------------
         * LOCATION
         * -----------------------------------------------------
         */
        $locationScore = $this->calculateTextScore(
            $criteria['location'],
            $jobPost->location,
            20
        );

        $earnedScore += $locationScore;

        $possibleScore += 20;

        $breakdown[] = [
            'name' => 'Location',

            'wanted' => $criteria['location'],

            'candidate' => $jobPost->location,

            'earned' => $locationScore,

            'maximum' => 20,

            'status' => $this->matchStatus(
                $locationScore,
                20
            ),
        ];

        /*
         * -----------------------------------------------------
         * EXPERIENCE
         * -----------------------------------------------------
         */
        $workerExperience =
            (int) $criteria['experience'];

        $requiredExperience =
            (int) $jobPost->minimum_experience;

        if ($requiredExperience === 0) {

            $experienceScore = 15;

        } elseif (
            $workerExperience >= $requiredExperience
        ) {

            $experienceScore = 15;

        } else {

            $experienceScore = (
                $workerExperience
                / $requiredExperience
            ) * 15;
        }

        $earnedScore += $experienceScore;

        $possibleScore += 15;

        $breakdown[] = [
            'name' => 'Experience',

            'wanted' =>
                $workerExperience
                . ' year(s) available',

            'candidate' =>
                $requiredExperience === 0
                    ? 'No experience required'
                    : $requiredExperience
                        . ' year(s) required',

            'earned' => $experienceScore,

            'maximum' => 15,

            'status' => $this->matchStatus(
                $experienceScore,
                15
            ),
        ];

        /*
         * -----------------------------------------------------
         * JOB TYPE
         * -----------------------------------------------------
         */
        $jobTypeScore =
            $jobPost->job_type
            === $criteria['job_type']
                ? 15
                : 0;

        $earnedScore += $jobTypeScore;

        $possibleScore += 15;

        $breakdown[] = [
            'name' => 'Job Type',

            'wanted' => $criteria['job_type'],

            'candidate' => $jobPost->job_type,

            'earned' => $jobTypeScore,

            'maximum' => 15,

            'status' => $this->matchStatus(
                $jobTypeScore,
                15
            ),
        ];

        /*
         * -----------------------------------------------------
         * SKILLS
         *
         * Skills remain OPTIONAL.
         *
         * If the worker did not select skills:
         * skills are completely removed from the score.
         *
         * If the job has no required skills:
         * it receives full skill compatibility because
         * there is no skill requirement blocking the worker.
         * -----------------------------------------------------
         */
        if ($selectedSkillIds->isNotEmpty()) {

            $requiredSkillIds =
                $jobPost->skills->pluck('id');

            /*
             * Job requires no specific skills.
             */
            if ($requiredSkillIds->isEmpty()) {

                $skillsScore = 30;

                $matchingSkills = 0;

                $breakdownCandidate =
                    'No specific skills required';
            }

            /*
             * Job has required skills.
             */
            else {

                $matchingSkills =
                    $selectedSkillIds
                        ->intersect($requiredSkillIds)
                        ->count();

                $skillsScore = (
                    $matchingSkills
                    / $requiredSkillIds->count()
                ) * 30;

                $breakdownCandidate =
                    $matchingSkills
                    . ' of '
                    . $requiredSkillIds->count()
                    . ' job skills matched';
            }

            $earnedScore += $skillsScore;

            $possibleScore += 30;

            $breakdown[] = [
                'name' => 'Skills',

                'wanted' =>
                    $selectedSkillIds->count()
                    . ' selected by you',

                'candidate' =>
                    $breakdownCandidate,

                'earned' => $skillsScore,

                'maximum' => 30,

                'status' => $this->matchStatus(
                    $skillsScore,
                    30
                ),
            ];
        }

        return $this->finishMatch(
            $earnedScore,
            $possibleScore,
            $breakdown
        );
    }

    /**
     * Finish and normalize the percentage.
     *
     * If no skills were selected:
     *
     * possible score = 70
     *
     * 70 / 70 becomes 100%.
     *
     * Skills therefore do NOT reduce the percentage
     * when they were not selected.
     */
    private function finishMatch(
        float $earnedScore,
        float $possibleScore,
        array $breakdown
    ): array {
        if ($possibleScore <= 0) {
            return [
                'percentage' => 0,
                'breakdown' => $breakdown,
            ];
        }

        $percentage = (
            $earnedScore
            / $possibleScore
        ) * 100;

        return [
            'percentage' => (int) round(
                min(
                    100,
                    max(
                        0,
                        $percentage
                    )
                )
            ),

            'breakdown' => $breakdown,
        ];
    }

    /**
     * Determine the visual status used by
     * "Why this match?".
     */
    private function matchStatus(
        float $earned,
        float $maximum
    ): string {
        if ($maximum <= 0) {
            return 'none';
        }

        if ($earned >= $maximum) {
            return 'match';
        }

        if ($earned > 0) {
            return 'partial';
        }

        return 'no_match';
    }

    /**
     * Basic text similarity scoring.
     */
    private function calculateTextScore(
        ?string $wanted,
        ?string $candidateValue,
        float $maximumScore
    ): float {
        $wanted = strtolower(
            trim(
                (string) $wanted
            )
        );

        $candidateValue = strtolower(
            trim(
                (string) $candidateValue
            )
        );

        if (
            $wanted === ''
            || $candidateValue === ''
        ) {
            return 0;
        }

        /*
         * Exact match.
         */
        if ($wanted === $candidateValue) {
            return $maximumScore;
        }

        /*
         * Partial containment.
         *
         * Examples:
         *
         * Hilongos
         * Hilongos Leyte
         *
         * Manager
         * Sales Manager
         */
        if (
            str_contains(
                $candidateValue,
                $wanted
            )
            ||
            str_contains(
                $wanted,
                $candidateValue
            )
        ) {
            return $maximumScore * 0.8;
        }

        /*
         * Compare individual words.
         */
        $wantedWords = collect(
            preg_split(
                '/\s+/',
                $wanted
            )
        )
            ->filter()
            ->unique();

        $candidateWords = collect(
            preg_split(
                '/\s+/',
                $candidateValue
            )
        )
            ->filter()
            ->unique();

        if ($wantedWords->isEmpty()) {
            return 0;
        }

        $matchingWords =
            $wantedWords
                ->intersect($candidateWords)
                ->count();

        return (
            $matchingWords
            / $wantedWords->count()
        ) * $maximumScore;
    }
}