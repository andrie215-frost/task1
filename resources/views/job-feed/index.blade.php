@extends('layouts.app')

@section('title', 'Job Feed - SkillMatch')

@section('content')

<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <h1 class="h3 mb-2">
                Job Feed
            </h1>

            <p class="text-secondary mb-0">
                Browse available job opportunities
                posted by companies.
            </p>

        </div>

    </div>

</div>


{{-- SEARCH / FILTERS --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <form
        method="GET"
        action="{{ route('jobs.index') }}"
    >

        <div class="row g-3 align-items-end">


            {{-- SEARCH --}}
            <div class="col-12 col-lg-5">

                <label
                    for="search"
                    class="form-label fw-semibold"
                >
                    Search
                </label>

                <input
                    id="search"
                    name="search"
                    type="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Job title, company, or keyword"
                >

            </div>


            {{-- LOCATION --}}
            <div class="col-12 col-md-6 col-lg-3">

                <label
                    for="location"
                    class="form-label fw-semibold"
                >
                    Location
                </label>

                <input
                    id="location"
                    name="location"
                    type="text"
                    class="form-control"
                    value="{{ $location }}"
                    placeholder="Example: Hilongos, Leyte"
                >

            </div>


            {{-- JOB TYPE --}}
            <div class="col-12 col-md-6 col-lg-2">

                <label
                    for="job_type"
                    class="form-label fw-semibold"
                >
                    Job Type
                </label>

                <select
                    id="job_type"
                    name="job_type"
                    class="form-select"
                >

                    <option value="">
                        All
                    </option>

                    @foreach ($jobTypeOptions as $type)

                        <option
                            value="{{ $type }}"
                            @selected($jobType === $type)
                        >
                            {{ $type }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- SEARCH BUTTON --}}
            <div class="col-12 col-lg-2">

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Search Jobs
                    </button>

                </div>

            </div>

        </div>


        @if ($jobTypeOptions->isEmpty())

            <div class="form-text text-secondary mt-2">
                No active job type filters are currently available.
            </div>

        @endif


        @if ($search || $location || $jobType)

            <div class="mt-3">

                <a
                    href="{{ route('jobs.index') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Clear Filters
                </a>

            </div>

        @endif

    </form>

</div>


{{-- RESULT COUNT --}}
<div
    class="d-flex flex-column flex-sm-row
           justify-content-between align-items-sm-center
           gap-2 mb-3"
>

    <div>

        <h2 class="h5 mb-1">
            Available Jobs
        </h2>

        <p class="text-secondary mb-0">

            {{ $jobPosts->total() }}

            {{ Str::plural(
                'job',
                $jobPosts->total()
            ) }}

            found.

        </p>

    </div>

</div>


@if ($jobPosts->isEmpty())

    {{-- EMPTY STATE --}}
    <div
        class="bg-white border rounded-4
               shadow-sm p-4 text-center"
    >

        <div
            class="d-inline-flex align-items-center
                   justify-content-center
                   bg-light border rounded-3
                   text-secondary mb-3"
            style="width: 48px; height: 48px;"
        >

            <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <circle
                    cx="11"
                    cy="11"
                    r="7"
                />

                <path d="m20 20-4-4"/>
            </svg>

        </div>

        <h2 class="h5 mb-2">
            No jobs found
        </h2>

        <p class="text-secondary mb-3">
            Try changing your search terms
            or clearing the filters.
        </p>

        <a
            href="{{ route('jobs.index') }}"
            class="btn btn-outline-primary btn-sm"
        >
            View All Jobs
        </a>

    </div>


@else

    <div class="row g-4">

        @foreach ($jobPosts as $jobPost)

            @php
                $companyProfile =
                    $jobPost->company->companyProfile;
            @endphp


            <div class="col-12 col-xl-6">

                <div
                    class="bg-white border rounded-4
                           shadow-sm p-4 h-100
                           d-flex flex-column"
                >

                    {{-- HEADER --}}
                    <div
                        class="d-flex justify-content-between
                               align-items-start gap-3 mb-3"
                    >

                        <div>

                            <div class="mb-1">

                                <span class="badge text-bg-success">
                                    Open
                                </span>

                            </div>


                            <h2 class="h5 mb-1">
                                {{ $jobPost->title }}
                            </h2>


                            <div class="text-secondary">

                                {{ $companyProfile?->company_name
                                    ?? $jobPost->company->name }}

                            </div>

                        </div>


                        <div class="text-secondary small text-end">

                            {{ $jobPost->created_at->diffForHumans() }}

                        </div>

                    </div>


                    {{-- JOB INFO --}}
                    <div class="row g-2 mb-3">

                        <div class="col-12 col-sm-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div class="small text-secondary mb-1">
                                    Location
                                </div>

                                <div class="fw-semibold small">
                                    {{ $jobPost->location }}
                                </div>

                            </div>

                        </div>


                        <div class="col-12 col-sm-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div class="small text-secondary mb-1">
                                    Job Type
                                </div>

                                <div class="fw-semibold small">
                                    {{ $jobPost->job_type }}
                                </div>

                            </div>

                        </div>


                        <div class="col-12 col-sm-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div class="small text-secondary mb-1">
                                    Experience
                                </div>

                                <div class="fw-semibold small">

                                    @if (
                                        $jobPost->minimum_experience === 0
                                    )

                                        None required

                                    @else

                                        {{ $jobPost->minimum_experience }}

                                        {{ Str::plural(
                                            'year',
                                            $jobPost->minimum_experience
                                        ) }}

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- DESCRIPTION --}}
                    @if ($jobPost->description)

                        <div class="mb-3">

                            <p class="text-secondary mb-0">

                                {{ Str::limit(
                                    $jobPost->description,
                                    180
                                ) }}

                            </p>

                        </div>

                    @endif


                    {{-- SKILLS --}}
                    <div class="mb-4">

                        <div class="small fw-semibold mb-2">
                            Required Skills
                        </div>


                        @forelse ($jobPost->skills as $skill)

                            <span
                                class="badge text-bg-primary
                                       me-1 mb-1"
                            >
                                {{ $skill->name }}
                            </span>

                        @empty

                            <span
                                class="badge text-bg-light
                                       border text-secondary"
                            >
                                No specific skills required
                            </span>

                        @endforelse

                    </div>


                    {{-- ACTION --}}
                    <div class="mt-auto">

                        <a
                            href="{{ route(
                                'jobs.show',
                                $jobPost
                            ) }}"
                            class="btn btn-outline-primary w-100"
                        >
                            View Job Details
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    {{-- PAGINATION --}}
    @if ($jobPosts->hasPages())

        <div
            class="d-flex flex-column flex-sm-row
                   justify-content-between align-items-sm-center
                   gap-3 mt-4"
        >

            <div class="text-secondary small">

                Showing

                {{ $jobPosts->firstItem() ?? 0 }}

                to

                {{ $jobPosts->lastItem() ?? 0 }}

                of

                {{ $jobPosts->total() }}

                jobs

            </div>


            <div class="d-flex gap-2">

                @if ($jobPosts->onFirstPage())

                    <button
                        class="btn btn-outline-secondary btn-sm"
                        disabled
                    >
                        Previous
                    </button>

                @else

                    <a
                        href="{{ $jobPosts->previousPageUrl() }}"
                        class="btn btn-outline-secondary btn-sm"
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

@endsection