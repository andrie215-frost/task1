@extends('layouts.app')

@section('title', 'Company Dashboard - SkillMatch')

@section('content')

@php
    $profile = $user->companyProfile;

    $openJobs = $user->jobPosts()
        ->where('status', 'open')
        ->count();

    $totalJobs = $user->jobPosts()->count();
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
                COMPANY DASHBOARD
            </div>

            <h1 class="h3 mb-2">
                Welcome, {{ $profile?->company_name ?? $user->name }}
            </h1>

            <p class="text-secondary mb-0">
                Manage your job posts and find suitable workers.
            </p>

        </div>


        <a
            href="{{ route('job-posts.create') }}"
            class="btn btn-primary"
        >
            + Post a Job
        </a>

    </div>

</div>



{{-- =========================================================
     QUICK OVERVIEW
     ========================================================= --}}
<div class="row g-3 mb-4">


    {{-- OPEN JOBS --}}
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
                        Open Jobs
                    </div>

                    <div class="h3 mb-0">
                        {{ $openJobs }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL POSTS --}}
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
                        <path d="M4 4h16v16H4z"/>
                        <path d="M8 9h8"/>
                        <path d="M8 13h8"/>
                        <path d="M8 17h5"/>
                    </svg>

                </div>


                <div>

                    <div class="small text-secondary">
                        Total Job Posts
                    </div>

                    <div class="h3 mb-0">
                        {{ $totalJobs }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PROFILE STATUS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="bg-warning-subtle text-warning-emphasis
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
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>

                </div>


                <div>

                    <div class="small text-secondary">
                        Company Profile
                    </div>

                    @if ($profile)

                        <div class="fw-semibold text-success">
                            Complete
                        </div>

                    @else

                        <div class="fw-semibold text-warning">
                            Incomplete
                        </div>

                    @endif

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
            Common things you can do in SkillMatch.
        </p>

    </div>


    <div class="row g-3">


        {{-- JOB POSTS --}}
        <div class="col-12 col-md-4">

            <a
                href="{{ route('job-posts.index') }}"
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
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="16"
                                rx="2"
                            />
                            <path d="M8 3v4"/>
                            <path d="M16 3v4"/>
                            <path d="M7 11h10"/>
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        My Job Posts
                    </div>

                    <div class="small text-secondary">
                        Edit, close or remove job posts.
                    </div>

                </div>

            </a>

        </div>


        {{-- FIND PEOPLE --}}
        <div class="col-12 col-md-4">

            <a
                href="{{ route('matches.index') }}"
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
                            <circle cx="10" cy="8" r="4"/>
                            <path d="M2 21a8 8 0 0 1 16 0"/>
                            <circle cx="19" cy="11" r="3"/>
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        Find Skilled People
                    </div>

                    <div class="small text-secondary">
                        Search for suitable workers.
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
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/>
                        </svg>

                    </div>

                    <div class="fw-semibold text-dark mb-1">
                        Edit Company Profile
                    </div>

                    <div class="small text-secondary">
                        Update your company information.
                    </div>

                </div>

            </a>

        </div>

    </div>

</div>



{{-- =========================================================
     COMPANY INFORMATION
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <div
        class="d-flex justify-content-between
               align-items-center gap-3 mb-4"
    >

        <div>

            <h2 class="h5 mb-1">
                Company Information
            </h2>

            <p class="text-secondary mb-0">
                Basic information shown to job seekers.
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

            <div class="col-12 col-md-4">

                <div class="bg-light rounded-3 p-3 h-100">

                    <div class="small text-secondary mb-1">
                        Company
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->company_name }}
                    </div>

                </div>

            </div>


            <div class="col-12 col-md-4">

                <div class="bg-light rounded-3 p-3 h-100">

                    <div class="small text-secondary mb-1">
                        Industry
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->industry ?: 'Not specified' }}
                    </div>

                </div>

            </div>


            <div class="col-12 col-md-4">

                <div class="bg-light rounded-3 p-3 h-100">

                    <div class="small text-secondary mb-1">
                        Location
                    </div>

                    <div class="fw-semibold">
                        {{ $profile->location }}
                    </div>

                </div>

            </div>

        </div>

    @else

        <div class="alert alert-warning mb-0">

            Your company profile is incomplete.

            <a
                href="{{ route('profile.edit') }}"
                class="alert-link"
            >
                Complete your profile
            </a>

        </div>

    @endif

</div>

@endsection