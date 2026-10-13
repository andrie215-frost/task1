@extends('layouts.app')

@section('title', 'My Profile - SkillMatch')

@section('content')


{{-- =========================================================
     HEADER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between
               align-items-md-center gap-3"
    >

        <div class="d-flex align-items-center gap-3">

            {{-- PROFILE IMAGE --}}
            <div class="flex-shrink-0">

                @if ($user->profile_image)

                    <img
                        src="{{ asset(
                            'storage/' . $user->profile_image
                        ) }}"
                        alt="{{ $user->name }}"
                        class="rounded-circle border"
                        style="
                            width: 82px;
                            height: 82px;
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
                            width: 82px;
                            height: 82px;
                            font-size: 1.5rem;
                        "
                    >
                        {{ strtoupper(
                            substr($user->name, 0, 1)
                        ) }}
                    </div>

                @endif

            </div>


            <div>

                <h1 class="h3 mb-2">
                    {{ $user->name }}
                </h1>

                <p class="text-secondary mb-0">
                    {{ $user->role === 'company'
                        ? 'Company Account'
                        : 'Skilled Person Account' }}
                </p>

            </div>

        </div>


        <a
            href="{{ route('profile.edit') }}"
            class="btn btn-primary"
        >
            {{ $profile
                ? 'Edit Profile'
                : 'Create Profile' }}
        </a>

    </div>

</div>



{{-- =========================================================
     PROFILE NOT CREATED
     ========================================================= --}}
@if (! $profile)

    <div
        class="bg-white border rounded-4
               shadow-sm p-4 text-center"
    >

        <h2 class="h5 mb-2">
            Your profile is incomplete
        </h2>


        <p class="text-secondary mb-3">

            @if ($user->role === 'company')

                Add your company information so job seekers
                can learn about your organization.

            @else

                Add your professional information so companies
                can find and match with you.

            @endif

        </p>


        <a
            href="{{ route('profile.edit') }}"
            class="btn btn-primary btn-sm"
        >
            Complete Profile
        </a>

    </div>



{{-- =========================================================
     SKILLED PERSON
     ========================================================= --}}
@elseif ($user->role === 'skilled_person')


    <div class="bg-white border rounded-4 shadow-sm p-4">


        <div class="mb-4">

            <h2 class="h4 mb-1">
                Skilled Person Profile
            </h2>

            <p class="text-secondary mb-0">
                Your professional information and skills.
            </p>

        </div>


        {{-- PROFILE INFORMATION --}}
        <div class="row g-4 mb-4">


            {{-- NAME --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Full Name
                    </div>

                    <div class="fw-semibold">
                        {{ $user->name }}
                    </div>

                </div>

            </div>


            {{-- EMAIL --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Email
                    </div>

                    <div class="fw-semibold text-break">
                        {{ $user->email }}
                    </div>

                </div>

            </div>


            {{-- TITLE --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Professional Title
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->professional_title }}
                    </div>

                </div>

            </div>


            {{-- LOCATION --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Location
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->location }}
                    </div>

                </div>

            </div>


            {{-- EXPERIENCE --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Experience
                    </div>

                    <div class="fw-semibold">

                        @if ($profile->experience_years === 0)

                            No previous experience

                        @else

                            {{ $profile->experience_years }}

                            {{ Str::plural(
                                'year',
                                $profile->experience_years
                            ) }}

                        @endif

                    </div>

                </div>

            </div>


            {{-- JOB TYPE --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Preferred Job Type
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->preferred_job_type }}
                    </div>

                </div>

            </div>


            {{-- AVAILABILITY --}}
            <div class="col-12">

                <div class="border-bottom pb-3">

                    <div class="small text-secondary mb-2">
                        Availability
                    </div>

                    @if ($profile->is_available)

                        <span class="badge text-bg-success">
                            Available for Work
                        </span>

                    @else

                        <span class="badge text-bg-secondary">
                            Not Currently Available
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- BIO --}}
        @if ($profile->bio)

            <div class="mb-4">

                <h3 class="h6 mb-2">
                    About Me
                </h3>

                <p
                    class="text-secondary mb-0"
                    style="white-space: pre-line;"
                >{{ $profile->bio }}</p>

            </div>

        @endif


        {{-- SKILLS --}}
        <div>

            <h3 class="h6 mb-3">
                Skills
            </h3>

            @forelse ($user->skills as $skill)

                <span
                    class="badge text-bg-primary
                           me-1 mb-1"
                >
                    {{ $skill->name }}
                </span>

            @empty

                <p class="text-secondary mb-0">
                    No skills added yet.
                </p>

            @endforelse

        </div>

    </div>



{{-- =========================================================
     COMPANY
     ========================================================= --}}
@else


    <div class="bg-white border rounded-4 shadow-sm p-4">


        <div
            class="d-flex flex-column flex-md-row
                   justify-content-between
                   align-items-md-start gap-3 mb-4"
        >

            <div>

                <h2 class="h4 mb-1">
                    Company Profile
                </h2>

                <p class="text-secondary mb-0">
                    General information about your company.
                </p>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <a
                    href="{{ route('job-posts.index') }}"
                    class="btn btn-outline-primary btn-sm"
                >
                    View Job Posts
                </a>

                <a
                    href="{{ route('job-posts.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    + Post a Job
                </a>

            </div>

        </div>


        {{-- COMPANY INFORMATION --}}
        <div class="row g-4 mb-4">


            {{-- COMPANY NAME --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Company Name
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->company_name }}
                    </div>

                </div>

            </div>


            {{-- CONTACT PERSON --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Contact Person
                    </div>

                    <div class="fw-semibold">
                        {{ $user->name }}
                    </div>

                </div>

            </div>


            {{-- EMAIL --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Contact Email
                    </div>

                    <div class="fw-semibold text-break">
                        {{ $user->email }}
                    </div>

                </div>

            </div>


            {{-- INDUSTRY --}}
            <div class="col-12 col-md-6">

                <div class="border-bottom pb-3 h-100">

                    <div class="small text-secondary mb-1">
                        Industry
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->industry
                            ?: 'Not specified' }}
                    </div>

                </div>

            </div>


            {{-- LOCATION --}}
            <div class="col-12">

                <div class="border-bottom pb-3">

                    <div class="small text-secondary mb-1">
                        Location
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->location }}
                    </div>

                </div>

            </div>

        </div>


        {{-- DESCRIPTION --}}
        @if ($profile->description)

            <div class="mb-4">

                <h3 class="h6 mb-2">
                    About the Company
                </h3>

                <p
                    class="text-secondary mb-0"
                    style="white-space: pre-line;"
                >{{ $profile->description }}</p>

            </div>

        @endif


        {{-- WEBSITE --}}
        @if ($profile->website)

            <div>

                <h3 class="h6 mb-2">
                    Website
                </h3>

                <a
                    href="{{ $profile->website }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Visit Company Website
                </a>

            </div>

        @endif

    </div>


@endif

@endsection