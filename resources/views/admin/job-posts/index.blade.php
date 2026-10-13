@extends('layouts.app')

@section('title', 'Job Post Management - SkillMatch')

@section('content')


{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div>

        <h1 class="h3 mb-2">
            Job Post Management
        </h1>

        <p class="text-secondary mb-0">
            Review and manage job posts
            created by companies.
        </p>

    </div>

</div>



{{-- FILTERS --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <form
        method="GET"
        action="{{ route('admin.job-posts.index') }}"
    >

        <div class="row g-3 align-items-end">


            {{-- SEARCH --}}
            <div class="col-12 col-lg-7">

                <label
                    for="search"
                    class="form-label fw-semibold"
                >
                    Search Job Posts
                </label>


                <input
                    id="search"
                    name="search"
                    type="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Job title, company, or location"
                >

            </div>



            {{-- STATUS --}}
            <div class="col-12 col-md-6 col-lg-3">

                <label
                    for="status"
                    class="form-label fw-semibold"
                >
                    Status
                </label>


                <select
                    id="status"
                    name="status"
                    class="form-select"
                >

                    <option value="">
                        All statuses
                    </option>


                    <option
                        value="open"
                        @selected(
                            $selectedStatus === 'open'
                        )
                    >
                        Open
                    </option>


                    <option
                        value="closed"
                        @selected(
                            $selectedStatus === 'closed'
                        )
                    >
                        Closed
                    </option>

                </select>

            </div>



            {{-- BUTTON --}}
            <div class="col-12 col-md-6 col-lg-2">

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Search
                    </button>

                </div>

            </div>

        </div>


        @if ($search || $selectedStatus)

            <div class="mt-3">

                <a
                    href="{{ route(
                        'admin.job-posts.index'
                    ) }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Clear Filters
                </a>

            </div>

        @endif

    </form>

</div>



{{-- JOB POSTS --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <div class="mb-4">

        <h2 class="h4 mb-1">
            Job Posts
        </h2>

        <p class="text-secondary mb-0">

            Showing

            {{ $jobPosts->firstItem() ?? 0 }}

            to

            {{ $jobPosts->lastItem() ?? 0 }}

            of

            {{ $jobPosts->total() }}

            job posts.

        </p>

    </div>



    @if ($jobPosts->isEmpty())

        <div class="text-center py-5">

            <h3 class="h5 mb-2">
                No job posts found
            </h3>

            <p class="text-secondary mb-3">
                Try changing your search or filters.
            </p>

            <a
                href="{{ route(
                    'admin.job-posts.index'
                ) }}"
                class="btn btn-outline-secondary"
            >
                Clear Filters
            </a>

        </div>


    @else


        <div class="table-responsive">

            <table
                class="table table-hover
                       align-middle mb-0"
            >

                <thead class="table-light">

                    <tr>

                        <th>
                            Job
                        </th>

                        <th>
                            Company
                        </th>

                        <th>
                            Location
                        </th>

                        <th>
                            Job Type
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Posted
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($jobPosts as $jobPost)

                        @php

                            $company =
                                $jobPost->company;

                            $companyProfile =
                                $company?->companyProfile;

                        @endphp


                        <tr>


                            {{-- JOB --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $jobPost->title }}
                                </div>

                                <div class="small text-secondary">

                                    @if (
                                        $jobPost->minimum_experience === 0
                                    )

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



                            {{-- COMPANY --}}
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    @if ($company?->profile_image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $company->profile_image
                                            ) }}"
                                            alt="{{ $company->name }}"
                                            class="rounded-circle
                                                   border
                                                   flex-shrink-0"
                                            style="
                                                width: 40px;
                                                height: 40px;
                                                object-fit: cover;
                                            "
                                        >

                                    @else

                                        <div
                                            class="rounded-circle
                                                   bg-primary
                                                   text-white
                                                   d-flex
                                                   align-items-center
                                                   justify-content-center
                                                   fw-semibold
                                                   flex-shrink-0"
                                            style="
                                                width: 40px;
                                                height: 40px;
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



                            {{-- LOCATION --}}
                            <td>
                                {{ $jobPost->location }}
                            </td>



                            {{-- TYPE --}}
                            <td>

                                <span
                                    class="badge text-bg-light
                                           border text-dark"
                                >
                                    {{ $jobPost->job_type }}
                                </span>

                            </td>



                            {{-- STATUS --}}
                            <td>

                                @if ($jobPost->status === 'open')

                                    <span
                                        class="badge text-bg-success"
                                    >
                                        Open
                                    </span>

                                @else

                                    <span
                                        class="badge text-bg-secondary"
                                    >
                                        Closed
                                    </span>

                                @endif

                            </td>



                            {{-- POSTED --}}
                            <td>

                                {{ $jobPost->created_at
                                    ->format('M d, Y') }}

                            </td>



                            {{-- ACTIONS --}}
                            <td class="text-end">

                                <div
                                    class="d-flex
                                           justify-content-end
                                           align-items-center gap-2"
                                >


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


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.job-posts.destroy',
                                            $jobPost
                                        ) }}"
                                        class="m-0"
                                        onsubmit="return confirm(
                                            'Permanently delete this job post?'
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



        {{-- PAGINATION --}}
        @if ($jobPosts->hasPages())

            <div
                class="d-flex flex-column flex-md-row
                       justify-content-between
                       align-items-md-center gap-3 mt-4"
            >

                <div class="small text-secondary">

                    Page
                    {{ $jobPosts->currentPage() }}

                    of
                    {{ $jobPosts->lastPage() }}

                </div>


                <div class="d-flex gap-2">


                    @if ($jobPosts->onFirstPage())

                        <button
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                            disabled
                        >
                            Previous
                        </button>

                    @else

                        <a
                            href="{{ $jobPosts->previousPageUrl() }}"
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                        >
                            Previous
                        </a>

                    @endif



                    @if ($jobPosts->hasMorePages())

                        <a
                            href="{{ $jobPosts->nextPageUrl() }}"
                            class="btn btn-primary btn-sm"
                        >
                            Next
                        </a>

                    @else

                        <button
                            class="btn btn-primary btn-sm"
                            disabled
                        >
                            Next
                        </button>

                    @endif

                </div>

            </div>

        @endif


    @endif

</div>

@endsection