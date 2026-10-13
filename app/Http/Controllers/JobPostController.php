<?php

namespace App\Http\Controllers;

use App\Models\FindingOption;
use App\Models\JobPost;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobPostController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'company',
            403
        );

        $jobPosts = $user->jobPosts()
            ->with('skills')
            ->latest()
            ->get();

        return view('job-posts.index', [
            'jobPosts' => $jobPosts,
        ]);
    }


    public function create(Request $request): View
    {
        abort_unless(
            $request->user()->role === 'company',
            403
        );

        $skills = Skill::query()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $jobTypeOptions =
            $this->activeJobTypeOptions();

        return view('job-posts.create', [
            'skills' => $skills,
            'jobTypeOptions' => $jobTypeOptions,
        ]);
    }


    public function store(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

        abort_unless(
            $user->role === 'company',
            403
        );

        $jobTypeOptions =
            $this->activeJobTypeOptions();

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'job_type' => [
                'required',
                'string',
                Rule::in(
                    $jobTypeOptions->all()
                ),
            ],

            'minimum_experience' => [
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

        $jobPost = $user->jobPosts()->create([
            'title' => $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'location' =>
                $validated['location'],

            'job_type' =>
                $validated['job_type'],

            'minimum_experience' =>
                $validated['minimum_experience'],

            'status' => 'open',
        ]);

        $jobPost->skills()->sync(
            $validated['skill_ids'] ?? []
        );

        return redirect()
            ->route('job-posts.index')
            ->with(
                'success',
                'Job post created successfully.'
            );
    }


    public function edit(
        Request $request,
        JobPost $jobPost
    ): View {
        $this->ensureCompanyOwnsJobPost(
            $request,
            $jobPost
        );

        $jobPost->load('skills');

        $skills = Skill::query()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $jobTypeOptions =
            $this->activeJobTypeOptions();

        return view('job-posts.edit', [
            'jobPost' => $jobPost,
            'skills' => $skills,
            'jobTypeOptions' => $jobTypeOptions,
        ]);
    }


    public function update(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        $this->ensureCompanyOwnsJobPost(
            $request,
            $jobPost
        );

        $jobTypeOptions =
            $this->activeJobTypeOptions();

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'job_type' => [
                'required',
                'string',
                Rule::in(
                    $jobTypeOptions->all()
                ),
            ],

            'minimum_experience' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],

            'status' => [
                'required',
                Rule::in([
                    'open',
                    'closed',
                ]),
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

        $jobPost->update([
            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'location' =>
                $validated['location'],

            'job_type' =>
                $validated['job_type'],

            'minimum_experience' =>
                $validated['minimum_experience'],

            'status' =>
                $validated['status'],
        ]);

        $jobPost->skills()->sync(
            $validated['skill_ids'] ?? []
        );

        return redirect()
            ->route('job-posts.index')
            ->with(
                'success',
                'Job post updated successfully.'
            );
    }


    public function destroy(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        $this->ensureCompanyOwnsJobPost(
            $request,
            $jobPost
        );

        $jobPost->delete();

        return redirect()
            ->route('job-posts.index')
            ->with(
                'success',
                'Job post deleted successfully.'
            );
    }


    /**
     * Get active Admin-managed Job Type options.
     */
    private function activeJobTypeOptions(): Collection
    {
        return FindingOption::query()
            ->where('type', 'job_type')
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->values();
    }


    private function ensureCompanyOwnsJobPost(
        Request $request,
        JobPost $jobPost
    ): void {
        $user = $request->user();

        abort_unless(
            $user->role === 'company',
            403
        );

        abort_unless(
            $jobPost->user_id === $user->id,
            403
        );
    }
}