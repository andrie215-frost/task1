@extends('layouts.app')

@section('title', 'Edit Profile - SkillMatch')

@section('content')

{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between
               align-items-md-center gap-3"
    >

        <div>

            <h1 class="h3 mb-2">
                {{ $profile ? 'Edit Profile' : 'Create Profile' }}
            </h1>

            <p class="text-secondary mb-0">

                @if ($user->role === 'company')

                    Manage your company information.

                @else

                    Manage your professional information,
                    experience, and skills.

                @endif

            </p>

        </div>


        @if ($user->role === 'company')

            <a
                href="{{ route('job-posts.index') }}"
                class="btn btn-outline-primary"
            >
                Manage Job Posts
            </a>

        @endif

    </div>

</div>


<div class="bg-white border rounded-4 shadow-sm p-4">

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PATCH')


        {{-- =====================================================
             PROFILE IMAGE
             ===================================================== --}}
        <div class="mb-4">

            <label
                for="profile_image"
                class="form-label fw-semibold"
            >
                Profile Picture
            </label>


            <div
                class="d-flex flex-column flex-sm-row
                       align-items-sm-center gap-3"
            >

                <div class="flex-shrink-0">

                    @if ($user->profile_image)

                        <img
                            src="{{ asset(
                                'storage/' . $user->profile_image
                            ) }}"
                            alt="{{ $user->name }}"
                            class="rounded-circle border"
                            style="
                                width: 88px;
                                height: 88px;
                                object-fit: cover;
                            "
                        >

                    @else

                        <div
                            class="rounded-circle border bg-light
                                   d-flex align-items-center
                                   justify-content-center
                                   fw-bold text-secondary"
                            style="
                                width: 88px;
                                height: 88px;
                                font-size: 1.5rem;
                            "
                        >
                            {{ strtoupper(
                                substr($user->name, 0, 1)
                            ) }}
                        </div>

                    @endif

                </div>


                <div class="flex-grow-1">

                    <input
                        id="profile_image"
                        name="profile_image"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="form-control
                               @error('profile_image')
                                   is-invalid
                               @enderror"
                    >

                    @error('profile_image')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        JPG, JPEG, PNG, or WEBP.
                        Maximum file size: 2 MB.
                    </div>

                </div>

            </div>

        </div>


        <hr class="mb-4">


        {{-- =====================================================
             SKILLED PERSON
             ===================================================== --}}
        @if ($user->role === 'skilled_person')

            @php
                $selectedPreferredJobType = old(
                    'preferred_job_type',
                    $profile?->preferred_job_type
                );

                $currentPreferredJobTypeIsActive =
                    ! $profile?->preferred_job_type
                    || $jobTypeOptions->contains(
                        $profile->preferred_job_type
                    );
            @endphp


            {{-- PROFESSIONAL TITLE --}}
            <div class="mb-4">

                <label
                    for="professional_title"
                    class="form-label fw-semibold"
                >
                    Professional Title
                </label>

                <input
                    id="professional_title"
                    name="professional_title"
                    type="text"
                    class="form-control
                           @error('professional_title')
                               is-invalid
                           @enderror"
                    value="{{ old(
                        'professional_title',
                        $profile?->professional_title
                    ) }}"
                    placeholder="Example: Laravel Developer"
                    required
                >

                @error('professional_title')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BIO --}}
            <div class="mb-4">

                <label
                    for="bio"
                    class="form-label fw-semibold"
                >
                    About You
                </label>

                <textarea
                    id="bio"
                    name="bio"
                    class="form-control
                           @error('bio')
                               is-invalid
                           @enderror"
                    rows="5"
                    placeholder="Describe your abilities and experience."
                >{{ old('bio', $profile?->bio) }}</textarea>

                @error('bio')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="row g-3 mb-4">


                {{-- EXPERIENCE --}}
                <div class="col-12 col-md-6">

                    <label
                        for="experience_years"
                        class="form-label fw-semibold"
                    >
                        Years of Experience
                    </label>

                    <input
                        id="experience_years"
                        name="experience_years"
                        type="number"
                        min="0"
                        max="60"
                        class="form-control
                               @error('experience_years')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'experience_years',
                            $profile?->experience_years ?? 0
                        ) }}"
                        required
                    >

                    @error('experience_years')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- JOB TYPE --}}
                <div class="col-12 col-md-6">

                    <label
                        for="preferred_job_type"
                        class="form-label fw-semibold"
                    >
                        Preferred Job Type
                    </label>

                    <select
                        id="preferred_job_type"
                        name="preferred_job_type"
                        class="form-select
                               @error('preferred_job_type')
                                   is-invalid
                               @enderror"
                        required
                        @disabled($jobTypeOptions->isEmpty())
                    >

                        <option value="">
                            Select preferred job type
                        </option>

                        @foreach ($jobTypeOptions as $jobType)

                            <option
                                value="{{ $jobType }}"
                                @selected(
                                    $selectedPreferredJobType === $jobType
                                )
                            >
                                {{ $jobType }}
                            </option>

                        @endforeach

                    </select>

                    @error('preferred_job_type')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    @if ($jobTypeOptions->isEmpty())

                        <div class="form-text text-danger">
                            No active job types are currently available.
                            Please contact the administrator.
                        </div>

                    @elseif (! $currentPreferredJobTypeIsActive)

                        <div class="form-text text-warning-emphasis">
                            Your current preferred job type
                            "{{ $profile->preferred_job_type }}"
                            is no longer active. Please select
                            an active job type before saving.
                        </div>

                    @endif

                </div>

            </div>


            {{-- AVAILABILITY --}}
            <div class="mb-4">

                <input
                    type="hidden"
                    name="is_available"
                    value="0"
                >

                <div class="form-check">

                    <input
                        id="is_available"
                        name="is_available"
                        type="checkbox"
                        class="form-check-input"
                        value="1"
                        @checked(
                            old(
                                'is_available',
                                $profile?->is_available ?? true
                            )
                        )
                    >

                    <label
                        class="form-check-label"
                        for="is_available"
                    >
                        I am currently available for work
                    </label>

                </div>

            </div>


        {{-- =====================================================
             COMPANY
             ===================================================== --}}
        @else


            <div class="alert alert-primary mb-4">

                <div class="fw-semibold mb-1">
                    Job vacancies are managed separately.
                </div>

                <div class="small">

                    Position, job type, experience requirements,
                    and required skills are now added to individual
                    Job Posts.

                    <a
                        href="{{ route('job-posts.index') }}"
                        class="alert-link"
                    >
                        Manage Job Posts
                    </a>

                </div>

            </div>


            {{-- COMPANY NAME + INDUSTRY --}}
            <div class="row g-3 mb-4">


                <div class="col-12 col-md-6">

                    <label
                        for="company_name"
                        class="form-label fw-semibold"
                    >
                        Company Name
                    </label>

                    <input
                        id="company_name"
                        name="company_name"
                        type="text"
                        class="form-control
                               @error('company_name')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'company_name',
                            $profile?->company_name
                        ) }}"
                        required
                    >

                    @error('company_name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="col-12 col-md-6">

                    <label
                        for="industry"
                        class="form-label fw-semibold"
                    >
                        Industry
                    </label>

                    <input
                        id="industry"
                        name="industry"
                        type="text"
                        class="form-control
                               @error('industry')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'industry',
                            $profile?->industry
                        ) }}"
                        placeholder="Example: Information Technology"
                    >

                    @error('industry')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- DESCRIPTION --}}
            <div class="mb-4">

                <label
                    for="description"
                    class="form-label fw-semibold"
                >
                    Company Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="form-control
                           @error('description')
                               is-invalid
                           @enderror"
                    rows="5"
                    placeholder="Describe your company."
                >{{ old(
                    'description',
                    $profile?->description
                ) }}</textarea>

                @error('description')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- WEBSITE --}}
            <div class="mb-4">

                <label
                    for="website"
                    class="form-label fw-semibold"
                >
                    Company Website
                </label>

                <input
                    id="website"
                    name="website"
                    type="url"
                    class="form-control
                           @error('website')
                               is-invalid
                           @enderror"
                    value="{{ old(
                        'website',
                        $profile?->website
                    ) }}"
                    placeholder="https://example.com"
                >

                @error('website')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        @endif


        {{-- =====================================================
             LOCATION
             ===================================================== --}}
        <div class="mb-4">

            <label
                for="location"
                class="form-label fw-semibold"
            >
                {{ $user->role === 'company'
                    ? 'Company Location'
                    : 'Location' }}
            </label>

            <input
                id="location"
                name="location"
                type="text"
                class="form-control
                       @error('location')
                           is-invalid
                       @enderror"
                value="{{ old(
                    'location',
                    $profile?->location
                ) }}"
                placeholder="Example: Cebu City"
                required
            >

            @error('location')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- =====================================================
             SKILLS - SKILLED PERSON ONLY
             ===================================================== --}}
        @if ($user->role === 'skilled_person')

            @include('partials.skill-picker', [

                'pickerId' => 'profileSkills',

                'pickerSkills' => $skills,

                'selectedIds' => old(
                    'skill_ids',
                    $user->skills->pluck('id')->all()
                ),

                'pickerTitle' => 'Your Skills',

                'pickerHelp' =>
                    'Choose the skills that describe your abilities.',

            ])

        @endif


        {{-- ACTIONS --}}
        <div class="d-flex flex-wrap gap-2">

            <button
                type="submit"
                class="btn btn-primary"
                @disabled(
                    $user->role === 'skilled_person'
                    && $jobTypeOptions->isEmpty()
                )
            >
                Save Profile
            </button>


            <a
                href="{{ route('profile.show') }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection