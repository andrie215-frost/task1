<?php

namespace App\Http\Controllers;

use App\Models\FindingOption;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
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

        $profile = $user->role === 'company'
            ? $user->companyProfile
            : $user->skilledProfile;

        return view('profiles.show', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }


    /**
     * Show a Skilled Person profile to a company.
     */
    public function showSkilledPerson(
        Request $request,
        User $user
    ): View {
        $viewer = $request->user();

        /*
         * Only companies may view another
         * Skilled Person's profile.
         */
        abort_unless(
            $viewer->role === 'company',
            403
        );


        /*
         * The requested user must actually be
         * a Skilled Person account.
         */
        abort_unless(
            $user->role === 'skilled_person',
            404
        );


        $user->load([
            'skilledProfile',
            'skills',
        ]);


        /*
         * Do not show a profile page if the
         * Skilled Person has not created one yet.
         */
        abort_unless(
            $user->skilledProfile !== null,
            404
        );


        return view(
            'profiles.skilled-person-show',
            [
                'skilledPerson' => $user,
                'profile' => $user->skilledProfile,
            ]
        );
    }


    public function edit(Request $request): View
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

        $profile = $user->role === 'company'
            ? $user->companyProfile
            : $user->skilledProfile;


        $skills = $user->role === 'skilled_person'
            ? Skill::query()
                ->orderBy('category')
                ->orderBy('name')
                ->get()
            : collect();


        $jobTypeOptions =
            $user->role === 'skilled_person'
                ? $this->activeJobTypeOptions()
                : collect();


        return view('profiles.edit', [
            'user' => $user,
            'profile' => $profile,
            'skills' => $skills,
            'jobTypeOptions' => $jobTypeOptions,
        ]);
    }


    public function update(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

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
         * =====================================================
         * SKILLED PERSON
         * =====================================================
         */
        if ($user->role === 'skilled_person') {

            $jobTypeOptions =
                $this->activeJobTypeOptions();

            $data = $request->validate([
                'profile_image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

                'professional_title' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'bio' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],

                'location' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'experience_years' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:60',
                ],

                'preferred_job_type' => [
                    'required',
                    'string',
                    Rule::in(
                        $jobTypeOptions->all()
                    ),
                ],

                'is_available' => [
                    'required',
                    'boolean',
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


            $user->skilledProfile()->updateOrCreate(
                [],
                [
                    'professional_title' =>
                        $data['professional_title'],

                    'bio' =>
                        $data['bio'] ?? null,

                    'location' =>
                        $data['location'],

                    'experience_years' =>
                        $data['experience_years'],

                    'preferred_job_type' =>
                        $data['preferred_job_type'],

                    'is_available' =>
                        $data['is_available'],
                ]
            );


            $user->skills()->sync(
                $data['skill_ids'] ?? []
            );
        }


        /*
         * =====================================================
         * COMPANY
         * =====================================================
         */
        else {

            $data = $request->validate([
                'profile_image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

                'company_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'industry' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],

                'location' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'website' => [
                    'nullable',
                    'url',
                    'max:255',
                ],
            ]);


            $user->companyProfile()->updateOrCreate(
                [],
                [
                    'company_name' =>
                        $data['company_name'],

                    'industry' =>
                        $data['industry'] ?? null,

                    'description' =>
                        $data['description'] ?? null,

                    'location' =>
                        $data['location'],

                    'website' =>
                        $data['website'] ?? null,
                ]
            );


            /*
             * Companies no longer store skills
             * on their profile.
             *
             * Required skills belong to Job Posts.
             */
            $user->skills()->detach();
        }


        /*
         * =====================================================
         * PROFILE IMAGE
         * =====================================================
         */
        if ($request->hasFile('profile_image')) {

            /*
             * Remove the previous image when the user
             * uploads a replacement.
             */
            if ($user->profile_image) {

                Storage::disk('public')->delete(
                    $user->profile_image
                );
            }


            /*
             * Save the new image inside:
             *
             * storage/app/public/profile-images
             */
            $profileImagePath =
                $request
                    ->file('profile_image')
                    ->store(
                        'profile-images',
                        'public'
                    );


            /*
             * Store only the relative path
             * in the users table.
             */
            $user->update([
                'profile_image' =>
                    $profileImagePath,
            ]);
        }


        return redirect()
            ->route('profile.show')
            ->with(
                'success',
                'Your profile was updated.'
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
}