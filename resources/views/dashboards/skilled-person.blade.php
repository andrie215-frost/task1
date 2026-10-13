@extends('layouts.app')

@section('title', 'Dashboard - SkillMatch')

@section('content')

@php
    $profile = $user->skilledProfile;
    $skillCount = $user->skills->count();
@endphp


{{-- =========================================================
     WELCOME
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <div class="text-primary fw-semibold small mb-1">
                SKILLED PERSON DASHBOARD
            </div>

            <h1 class="h3 mb-2">
                Welcome, {{ $user->name }}
            </h1>

            <p class="text-secondary mb-0">
                Browse job opportunities and find jobs
                that match your preferences.
            </p>

        </div>


        <a
            href="{{ route('jobs.index') }}"
            class="btn btn-primary"
        >
            Browse Jobs
        </a>

    </div>

</div>



{{-- =========================================================
     QUICK OVERVIEW
     ========================================================= --}}
<div class="row g-3 mb-4">


    {{-- AVAILABILITY --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="bg-success-subtle text-success
                           rounded-3 p-3"
                >

                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 3 3 5-6"/>
                    </svg>

                </div>


                <div>

                    <div class="small text-secondary">
                        Availability
                    </div>


                    @if ($profile?->is_available)

                        <div class="fw-semibold text-success">
                            Available for Work
                        </div>

                    @else

                        <div class="fw-semibold text-secondary">
                            Not Available
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- EXPERIENCE --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="bg-primary-subtle text-primary
                           rounded-3 p-3"
                >

                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <rect
                            x="3"
                            y="7"
                            width="18"
                            height="13"
                            rx="2"
                        />
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>

                </div>


                <div>

                    <div class="small text-secondary">
                        Experience
                    </div>

                    <div class="fw-semibold">

                        {{ $profile?->experience_years ?? 0 }}

                        {{ Str::plural(
                            'year',
                            $profile?->experience_years ?? 0
                        ) }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- SKILLS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="bg-warning-subtle
                           text-warning-emphasis
                           rounded-3 p-3"
                >

                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 3v18"/>
                        <path d="M3 12h18"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>

                </div>


                <div>

                    <div class="small text-secondary">
                        Skills Listed
                    </div>

                    <div class="h4 mb-0">
                        {{ $skillCount }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     QUICK ACTIONS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div class="mb-4">

        <h2 class="h5 mb-1">
            Quick Actions
        </h2>

        <p class="text-secondary mb-0">
            Start your job search from here.
        </p>

    </div>


    <div class="row g-3">


        {{-- FIND JOBS --}}
        <div class="col-12 col-md-4">

            <a
                href="{{ route('matches.index') }}"
                class="text-decoration-none"
            >

                <div class="border rounded-4 p-4 h-100 bg-light">

                    <div
                        class="d-inline-flex align-items-center
                               justify-content-center
                               bg-success text-white rounded-3
                               mb-3"
                        style="width: 42px; height: 42px;"
                    >

                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m20 20-4-4"/>
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        Find Matching Jobs
                    </div>

                    <div class="small text-secondary">
                        Get ranked jobs based on your criteria.
                    </div>

                </div>

            </a>

        </div>


        {{-- EDIT PROFILE --}}
        <div class="col-12 col-md-4">

            <a
                href="{{ route('profile.edit') }}"
                class="text-decoration-none"
            >

                <div class="border rounded-4 p-4 h-100 bg-light">

                    <div
                        class="d-inline-flex align-items-center
                               justify-content-center
                               bg-info text-white rounded-3
                               mb-3"
                        style="width: 42px; height: 42px;"
                    >

                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/>
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        Edit Profile
                    </div>

                    <div class="small text-secondary">
                        Update your experience and skills.
                    </div>

                </div>

            </a>

        </div>


        {{-- ACCOUNT --}}
        <div class="col-12 col-md-4">

            <a
                href="{{ route('account.edit') }}"
                class="text-decoration-none"
            >

                <div class="border rounded-4 p-4 h-100 bg-light">

                    <div
                        class="d-inline-flex align-items-center
                               justify-content-center
                               bg-secondary text-white rounded-3
                               mb-3"
                        style="width: 42px; height: 42px;"
                    >

                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="3"/>
                            <path
                                d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-2.8 2.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6v.2h-4V21a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1L4.2 17l.1-.1a1.7 1.7 0 0 0 .3-1.9A1.7 1.7 0 0 0 3 14H2.8v-4H3a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9L4.2 7 7 4.2l.1.1A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.6v-.2h4V3a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1L19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.2v4H21a1.7 1.7 0 0 0-1.6 1z"
                            />
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        Account Settings
                    </div>

                    <div class="small text-secondary">
                        Change your email or password.
                    </div>

                </div>

            </a>

        </div>

    </div>

</div>



{{-- =========================================================
     WORK PROFILE
     ========================================================= --}}
<div class="row g-4">


    <div class="col-12 col-lg-8">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div
                class="d-flex justify-content-between
                       align-items-center gap-3 mb-4"
            >

                <div>

                    <h2 class="h5 mb-1">
                        Work Profile
                    </h2>

                    <p class="text-secondary mb-0">
                        Information companies can use when matching.
                    </p>

                </div>


                <a
                    href="{{ route('profile.show') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    View Profile
                </a>

            </div>


            @if ($profile)

                <div class="row g-3">

                    <div class="col-12 col-md-6">

                        <div class="bg-light rounded-3 p-3 h-100">

                            <div class="small text-secondary mb-1">
                                Professional Title
                            </div>

                            <div class="fw-semibold">
                                {{ $profile->professional_title }}
                            </div>

                        </div>

                    </div>


                    <div class="col-12 col-md-6">

                        <div class="bg-light rounded-3 p-3 h-100">

                            <div class="small text-secondary mb-1">
                                Location
                            </div>

                            <div class="fw-semibold">
                                {{ $profile->location }}
                            </div>

                        </div>

                    </div>


                    <div class="col-12 col-md-6">

                        <div class="bg-light rounded-3 p-3 h-100">

                            <div class="small text-secondary mb-1">
                                Preferred Job Type
                            </div>

                            <div class="fw-semibold">
                                {{ $profile->preferred_job_type }}
                            </div>

                        </div>

                    </div>


                    <div class="col-12 col-md-6">

                        <div class="bg-light rounded-3 p-3 h-100">

                            <div class="small text-secondary mb-1">
                                Experience
                            </div>

                            <div class="fw-semibold">

                                {{ $profile->experience_years }}

                                {{ Str::plural(
                                    'year',
                                    $profile->experience_years
                                ) }}

                            </div>

                        </div>

                    </div>

                </div>

            @else

                <div class="alert alert-warning mb-0">

                    Your work profile is incomplete.

                    <a
                        href="{{ route('profile.edit') }}"
                        class="alert-link"
                    >
                        Complete your profile
                    </a>

                </div>

            @endif

        </div>

    </div>



    {{-- SKILLS --}}
    <div class="col-12 col-lg-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="mb-3">

                <h2 class="h5 mb-1">
                    Your Skills
                </h2>

                <p class="text-secondary mb-0 small">
                    Skills listed on your profile.
                </p>

            </div>


            @forelse ($user->skills as $skill)

                <span
                    class="badge text-bg-light
                           border text-dark me-1 mb-2"
                >
                    {{ $skill->name }}
                </span>

            @empty

                <p class="text-secondary mb-3">
                    You have not listed any skills.
                </p>

            @endforelse


            <div class="mt-3">

                <a
                    href="{{ route('profile.edit') }}"
                    class="btn btn-outline-primary btn-sm"
                >
                    Manage Skills
                </a>

            </div>

        </div>

    </div>

</div>

@endsection