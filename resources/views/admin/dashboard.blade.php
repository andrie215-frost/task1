@extends('layouts.app')

@section('title', 'Admin Dashboard - SkillMatch')

@section('content')


{{-- =========================================================
     HEADER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <div class="small fw-semibold text-primary mb-1">
                ADMINISTRATION
            </div>

            <h1 class="h3 mb-2">
                Administrator Dashboard
            </h1>

            <p class="text-secondary mb-0">
                Monitor SkillMatch users and job activity.
            </p>

        </div>


        <a
            href="{{ route('admin.users.index') }}"
            class="btn btn-primary"
        >
            Manage Users
        </a>

    </div>

</div>



{{-- =========================================================
     MEMBER STATISTICS
     ========================================================= --}}
<div class="row g-3 mb-3">


    {{-- TOTAL MEMBERS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-primary-subtle
                           text-primary"
                    style="width: 46px; height: 46px;"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>


                <div>

                    <div class="small text-secondary">
                        Total Members
                    </div>

                    <div class="h2 mb-0">
                        {{ $totalMembers }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- SKILLED PEOPLE --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-success-subtle
                           text-success"
                    style="width: 46px; height: 46px;"
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
                        Skilled People
                    </div>

                    <div class="h2 mb-0">
                        {{ $totalSkilledPeople }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- COMPANIES --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-info-subtle
                           text-info-emphasis"
                    style="width: 46px; height: 46px;"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M3 21h18"/>
                        <path d="M6 21V5h12v16"/>
                        <path d="M9 9h2"/>
                        <path d="M13 9h2"/>
                        <path d="M9 13h2"/>
                        <path d="M13 13h2"/>
                    </svg>
                </div>


                <div>

                    <div class="small text-secondary">
                        Companies
                    </div>

                    <div class="h2 mb-0">
                        {{ $totalCompanies }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     JOB STATISTICS
     ========================================================= --}}
<div class="row g-3 mb-4">


    {{-- TOTAL JOB POSTS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-primary-subtle
                           text-primary"
                    style="width: 46px; height: 46px;"
                >
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <rect x="3" y="7" width="18" height="13" rx="2"/>
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                </div>


                <div>

                    <div class="small text-secondary">
                        Total Job Posts
                    </div>

                    <div class="h2 mb-0">
                        {{ $totalJobPosts }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- OPEN JOBS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-success-subtle
                           text-success"
                    style="width: 46px; height: 46px;"
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
                        Open Jobs
                    </div>

                    <div class="h2 mb-0">
                        {{ $openJobPosts }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- CLOSED JOBS --}}
    <div class="col-12 col-md-4">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="d-flex align-items-center
                           justify-content-center
                           rounded-3 bg-secondary-subtle
                           text-secondary"
                    style="width: 46px; height: 46px;"
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
                        <path d="M9 9l6 6"/>
                        <path d="M15 9l-6 6"/>
                    </svg>
                </div>


                <div>

                    <div class="small text-secondary">
                        Closed Jobs
                    </div>

                    <div class="h2 mb-0">
                        {{ $closedJobPosts }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     RECENTLY REGISTERED USERS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center
               gap-3 mb-4"
    >

        <div>

            <h2 class="h4 mb-1">
                Recently Registered Users
            </h2>

            <p class="text-secondary mb-0">
                Latest worker and company accounts.
            </p>

        </div>


        <a
            href="{{ route('admin.users.index') }}"
            class="btn btn-outline-primary btn-sm"
        >
            View All Users
        </a>

    </div>



    @if ($latestUsers->isEmpty())

        <div class="text-center py-4">

            <p class="text-secondary mb-0">
                No registered members yet.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>

                        <th class="text-end">
                            Actions
                        </th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($latestUsers as $registeredUser)

                        <tr>

                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    @if ($registeredUser->profile_image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $registeredUser->profile_image
                                            ) }}"
                                            alt="{{ $registeredUser->name }}"
                                            class="rounded-circle border flex-shrink-0"
                                            style="
                                                width: 36px;
                                                height: 36px;
                                                object-fit: cover;
                                            "
                                        >

                                    @else

                                        <div
                                            class="d-flex align-items-center
                                                   justify-content-center
                                                   rounded-circle bg-primary
                                                   text-white fw-semibold
                                                   flex-shrink-0"
                                            style="
                                                width: 36px;
                                                height: 36px;
                                            "
                                        >
                                            {{ strtoupper(
                                                substr(
                                                    $registeredUser->name,
                                                    0,
                                                    1
                                                )
                                            ) }}
                                        </div>

                                    @endif


                                    <span class="fw-semibold">
                                        {{ $registeredUser->name }}
                                    </span>

                                </div>

                            </td>


                            <td>
                                {{ $registeredUser->email }}
                            </td>


                            <td>

                                @if ($registeredUser->role === 'company')

                                    <span class="badge text-bg-primary">
                                        Company
                                    </span>

                                @else

                                    <span class="badge text-bg-success">
                                        Skilled Person
                                    </span>

                                @endif

                            </td>


                            <td>

                                {{ $registeredUser->created_at
                                    ->format('M d, Y') }}

                            </td>


                            <td class="text-end">

                                <div
                                    class="d-flex justify-content-end
                                           gap-2"
                                >

                                    <a
                                        href="{{ route(
                                            'admin.users.show',
                                            $registeredUser
                                        ) }}"
                                        class="btn
                                               btn-outline-secondary
                                               btn-sm"
                                    >
                                        View
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.users.destroy',
                                            $registeredUser
                                        ) }}"
                                        class="m-0"
                                        onsubmit="return confirm(
                                            'Permanently delete this user?'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn
                                                   btn-outline-danger
                                                   btn-sm"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>



{{-- =========================================================
     RECENT JOB POSTS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center
               gap-3 mb-4"
    >

        <div>

            <h2 class="h4 mb-1">
                Recently Posted Jobs
            </h2>

            <p class="text-secondary mb-0">
                Latest opportunities posted by companies.
            </p>

        </div>


        <a
            href="{{ route('admin.job-posts.index') }}"
            class="btn btn-outline-primary btn-sm"
        >
            View All Job Posts
        </a>

    </div>



    @if ($latestJobPosts->isEmpty())

        <div class="text-center py-4">

            <p class="text-secondary mb-0">
                No job posts have been created yet.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>Job</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Posted</th>

                        <th class="text-end">
                            Action
                        </th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($latestJobPosts as $jobPost)

                        @php
                            $company = $jobPost->company;

                            $companyProfile =
                                $company?->companyProfile;
                        @endphp


                        <tr>

                            <td>

                                <div class="fw-semibold">
                                    {{ $jobPost->title }}
                                </div>

                                <div class="small text-secondary">
                                    {{ $jobPost->job_type }}
                                </div>

                            </td>


                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    @if ($company?->profile_image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $company->profile_image
                                            ) }}"
                                            alt="{{ $company->name }}"
                                            class="rounded-circle border flex-shrink-0"
                                            style="
                                                width: 36px;
                                                height: 36px;
                                                object-fit: cover;
                                            "
                                        >

                                    @else

                                        <div
                                            class="d-flex align-items-center
                                                   justify-content-center
                                                   rounded-circle bg-primary
                                                   text-white fw-semibold
                                                   flex-shrink-0"
                                            style="
                                                width: 36px;
                                                height: 36px;
                                            "
                                        >
                                            {{ strtoupper(
                                                substr(
                                                    $company?->name
                                                        ?? 'C',
                                                    0,
                                                    1
                                                )
                                            ) }}
                                        </div>

                                    @endif


                                    <div>

                                        <div class="fw-semibold">

                                            {{ $companyProfile?->company_name
                                                ?? $company?->name
                                                ?? 'Unknown Company' }}

                                        </div>

                                        @if ($company?->email)

                                            <div class="small text-secondary">
                                                {{ $company->email }}
                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <td>
                                {{ $jobPost->location }}
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

@endsection