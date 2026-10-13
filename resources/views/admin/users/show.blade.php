@extends('layouts.app')

@section('title', 'User Details - SkillMatch')

@section('content')

@php
    $profile = $managedUser->role === 'company'
        ? $managedUser->companyProfile
        : $managedUser->skilledProfile;
@endphp


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

                @if ($managedUser->profile_image)

                    <img
                        src="{{ asset(
                            'storage/' . $managedUser->profile_image
                        ) }}"
                        alt="{{ $managedUser->name }}"
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
                            substr(
                                $managedUser->name,
                                0,
                                1
                            )
                        ) }}
                    </div>

                @endif

            </div>


            <div>

                <div class="small fw-semibold text-primary mb-1">
                    USER PROFILE
                </div>

                <h1 class="h3 mb-1">
                    {{ $managedUser->name }}
                </h1>

                <div>

                    @if ($managedUser->role === 'company')

                        <span class="badge text-bg-primary">
                            Company Account
                        </span>

                    @else

                        <span class="badge text-bg-success">
                            Skilled Person Account
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <a
            href="{{ route('admin.users.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Users
        </a>

    </div>

</div>



{{-- =========================================================
     ACCOUNT INFORMATION
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h2 class="h5 mb-4">
        Account Information
    </h2>


    <div class="row g-3">


        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Name
                </div>

                <div class="fw-semibold">
                    {{ $managedUser->name }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Email
                </div>

                <div class="fw-semibold text-break">
                    {{ $managedUser->email }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Account Type
                </div>

                @if ($managedUser->role === 'company')

                    <span class="badge text-bg-primary">
                        Company
                    </span>

                @else

                    <span class="badge text-bg-success">
                        Skilled Person
                    </span>

                @endif

            </div>

        </div>


        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Registered
                </div>

                <div class="fw-semibold">
                    {{ $managedUser->created_at
                        ->format('M d, Y g:i A') }}
                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     COMPANY ACCOUNT
     ========================================================= --}}
@if ($managedUser->role === 'company')


    {{-- COMPANY PROFILE --}}
    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

        <div class="mb-4">

            <h2 class="h5 mb-1">
                Company Profile
            </h2>

            <p class="text-secondary mb-0">
                General information about this company.
            </p>

        </div>


        @if (! $profile)

            <div class="alert alert-warning mb-0">
                This company has not completed its profile.
            </div>

        @else

            <div class="row g-3">


                <div class="col-12 col-md-6">

                    <div class="bg-light rounded-3 p-3 h-100">

                        <div class="small text-secondary mb-1">
                            Company Name
                        </div>

                        <div class="fw-semibold">
                            {{ $profile->company_name }}
                        </div>

                    </div>

                </div>


                <div class="col-12 col-md-6">

                    <div class="bg-light rounded-3 p-3 h-100">

                        <div class="small text-secondary mb-1">
                            Industry
                        </div>

                        <div class="fw-semibold">
                            {{ $profile->industry
                                ?: 'Not specified' }}
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
                            Website
                        </div>

                        @if ($profile->website)

                            <a
                                href="{{ $profile->website }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ $profile->website }}
                            </a>

                        @else

                            <span class="text-secondary">
                                Not provided
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            @if ($profile->description)

                <div class="mt-4">

                    <h3 class="h6 mb-2">
                        About the Company
                    </h3>

                    <p
                        class="text-secondary mb-0"
                        style="white-space: pre-line;"
                    >{{ $profile->description }}</p>

                </div>

            @endif

        @endif

    </div>



    {{-- JOB STATISTICS --}}
    @php
        $totalJobs =
            $managedUser->jobPosts->count();

        $openJobs =
            $managedUser->jobPosts
                ->where('status', 'open')
                ->count();

        $closedJobs =
            $managedUser->jobPosts
                ->where('status', 'closed')
                ->count();
    @endphp


    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">

            <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

                <div class="small text-secondary mb-1">
                    Total Job Posts
                </div>

                <div class="h2 mb-0">
                    {{ $totalJobs }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-4">

            <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

                <div class="small text-secondary mb-1">
                    Open Jobs
                </div>

                <div class="h2 text-success mb-0">
                    {{ $openJobs }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-4">

            <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

                <div class="small text-secondary mb-1">
                    Closed Jobs
                </div>

                <div class="h2 text-secondary mb-0">
                    {{ $closedJobs }}
                </div>

            </div>

        </div>

    </div>



    {{-- COMPANY JOB POSTS --}}
    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

        <div
            class="d-flex flex-column flex-md-row
                   justify-content-between
                   align-items-md-center gap-3 mb-4"
        >

            <div>

                <h2 class="h5 mb-1">
                    Job Posts
                </h2>

                <p class="text-secondary mb-0">
                    Jobs created by this company.
                </p>

            </div>


            <a
                href="{{ route(
                    'admin.job-posts.index',
                    [
                        'search' =>
                            $profile?->company_name
                            ?? $managedUser->name
                    ]
                ) }}"
                class="btn btn-outline-primary btn-sm"
            >
                View in Job Management
            </a>

        </div>


        @if ($managedUser->jobPosts->isEmpty())

            <div class="text-center py-4">

                <p class="text-secondary mb-0">
                    This company has not posted any jobs.
                </p>

            </div>

        @else

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>Job</th>
                            <th>Location</th>
                            <th>Job Type</th>
                            <th>Status</th>
                            <th>Posted</th>
                            <th class="text-end">
                                Action
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach (
                            $managedUser->jobPosts->take(5)
                            as $jobPost
                        )

                            <tr>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $jobPost->title }}
                                    </div>

                                    <div class="small text-secondary">

                                        @if ($jobPost->minimum_experience === 0)

                                            No experience required

                                        @else

                                            {{ $jobPost->minimum_experience }}

                                            {{ Str::plural(
                                                'year',
                                                $jobPost->minimum_experience
                                            ) }}

                                            experience

                                        @endif

                                    </div>

                                </td>


                                <td>
                                    {{ $jobPost->location }}
                                </td>


                                <td>
                                    {{ $jobPost->job_type }}
                                </td>


                                <td>

                                    @if ($jobPost->status === 'open')

                                        <span class="badge text-bg-success">
                                            Open
                                        </span>

                                    @else

                                        <span class="badge text-bg-secondary">
                                            Closed
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    {{ $jobPost->created_at
                                        ->format('M d, Y') }}
                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'admin.job-posts.show',
                                            $jobPost
                                        ) }}"
                                        class="btn
                                               btn-outline-secondary
                                               btn-sm"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>



{{-- =========================================================
     SKILLED PERSON
     ========================================================= --}}
@else


    {{-- SKILLED PERSON PROFILE --}}
    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">


        <div class="mb-4">

            <h2 class="h5 mb-1">
                Skilled Person Profile
            </h2>

            <p class="text-secondary mb-0">
                Professional information used for matching.
            </p>

        </div>


        @if (! $profile)

            <div class="alert alert-warning mb-0">
                This Skilled Person has not completed their profile.
            </div>

        @else

            <div class="row g-3">


                {{-- PROFESSIONAL TITLE --}}
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


                {{-- LOCATION --}}
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


                {{-- EXPERIENCE --}}
                <div class="col-12 col-md-6">

                    <div class="bg-light rounded-3 p-3 h-100">

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

                    <div class="bg-light rounded-3 p-3 h-100">

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

                    <div class="bg-light rounded-3 p-3">

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


            @if ($profile->bio)

                <div class="mt-4">

                    <h3 class="h6 mb-2">
                        About
                    </h3>

                    <p
                        class="text-secondary mb-0"
                        style="white-space: pre-line;"
                    >{{ $profile->bio }}</p>

                </div>

            @endif

        @endif

    </div>



    {{-- SKILLS --}}
    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

        <div
            class="d-flex justify-content-between
                   align-items-center gap-3 mb-3"
        >

            <div>

                <h2 class="h5 mb-1">
                    Skills
                </h2>

                <p class="text-secondary small mb-0">
                    Skills selected by this Skilled Person.
                </p>

            </div>


            <span class="badge text-bg-light border text-secondary">

                {{ $managedUser->skills->count() }}

                {{ Str::plural(
                    'skill',
                    $managedUser->skills->count()
                ) }}

            </span>

        </div>


        @forelse ($managedUser->skills as $skill)

            <span
                class="badge text-bg-primary
                       me-1 mb-2 px-3 py-2"
            >
                {{ $skill->name }}
            </span>

        @empty

            <p class="text-secondary mb-0">
                No skills listed.
            </p>

        @endforelse

    </div>


@endif



{{-- =========================================================
     DELETE ACCOUNT
     ========================================================= --}}
<div
    class="border border-danger-subtle
           bg-danger-subtle rounded-4 p-4"
>

    <div
        class="d-flex flex-column flex-lg-row
               justify-content-between
               align-items-lg-center gap-3"
    >

        <div>

            <h2 class="h5 text-danger mb-2">
                Delete Account
            </h2>


            <p class="mb-0">

                @if ($managedUser->role === 'company')

                    Deleting this company account will also
                    remove its company profile and job posts.

                @else

                    Deleting this account will also remove
                    its worker profile and skill relationships.

                @endif

            </p>

        </div>


        <form
            method="POST"
            action="{{ route(
                'admin.users.destroy',
                $managedUser
            ) }}"
            class="m-0"
            onsubmit="return confirm(
                'Permanently delete this user account?'
            )"
        >
            @csrf
            @method('DELETE')


            <button
                type="submit"
                class="btn btn-danger"
            >
                Delete User Permanently
            </button>

        </form>

    </div>

</div>

@endsection