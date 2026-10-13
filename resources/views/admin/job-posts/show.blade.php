@extends('layouts.app')

@section('title', 'Job Post Details - SkillMatch')

@section('content')

@php
    $company = $jobPost->company;
    $companyProfile = $company?->companyProfile;

    $companyName =
        $companyProfile?->company_name
        ?? $company?->name
        ?? 'Unknown Company';
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

            {{-- COMPANY PROFILE IMAGE --}}
            <div class="flex-shrink-0">

                @if ($company?->profile_image)

                    <img
                        src="{{ asset(
                            'storage/' . $company->profile_image
                        ) }}"
                        alt="{{ $companyName }}"
                        class="rounded-circle border"
                        style="
                            width: 72px;
                            height: 72px;
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
                               fw-semibold"
                        style="
                            width: 72px;
                            height: 72px;
                            font-size: 1.4rem;
                        "
                    >
                        {{ strtoupper(
                            substr(
                                $companyName,
                                0,
                                1
                            )
                        ) }}
                    </div>

                @endif

            </div>


            <div>

                <div
                    class="d-flex flex-wrap
                           align-items-center gap-2 mb-1"
                >

                    <h1 class="h3 mb-0">
                        {{ $jobPost->title }}
                    </h1>


                    @if ($jobPost->status === 'open')

                        <span class="badge text-bg-success">
                            Open
                        </span>

                    @else

                        <span class="badge text-bg-secondary">
                            Closed
                        </span>

                    @endif

                </div>


                <div class="text-secondary">
                    {{ $companyName }}
                </div>

            </div>

        </div>


        <a
            href="{{ route(
                'admin.job-posts.index'
            ) }}"
            class="btn btn-outline-secondary"
        >
            Back to Job Posts
        </a>

    </div>

</div>



{{-- =========================================================
     JOB INFORMATION
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h2 class="h5 mb-4">
        Job Information
    </h2>


    <div class="row g-3">


        {{-- LOCATION --}}
        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Location
                </div>

                <div class="fw-semibold">
                    {{ $jobPost->location }}
                </div>

            </div>

        </div>



        {{-- JOB TYPE --}}
        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Job Type
                </div>

                <div class="fw-semibold">
                    {{ $jobPost->job_type }}
                </div>

            </div>

        </div>



        {{-- EXPERIENCE --}}
        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Minimum Experience
                </div>


                <div class="fw-semibold">

                    @if ($jobPost->minimum_experience === 0)

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



        {{-- POSTED --}}
        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Posted
                </div>

                <div class="fw-semibold">

                    {{ $jobPost->created_at
                        ->format('M d, Y') }}

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     DESCRIPTION
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h2 class="h5 mb-3">
        Job Description
    </h2>


    @if ($jobPost->description)

        <p
            class="text-secondary mb-0"
            style="white-space: pre-line;"
        >{{ $jobPost->description }}</p>

    @else

        <p class="text-secondary mb-0">
            No description provided.
        </p>

    @endif

</div>



{{-- =========================================================
     SKILLS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h2 class="h5 mb-3">
        Required Skills
    </h2>


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



{{-- =========================================================
     COMPANY
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div class="d-flex align-items-center gap-3 mb-4">

        {{-- COMPANY IMAGE --}}
        <div class="flex-shrink-0">

            @if ($company?->profile_image)

                <img
                    src="{{ asset(
                        'storage/' . $company->profile_image
                    ) }}"
                    alt="{{ $companyName }}"
                    class="rounded-circle border"
                    style="
                        width: 58px;
                        height: 58px;
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
                           fw-semibold"
                    style="
                        width: 58px;
                        height: 58px;
                    "
                >
                    {{ strtoupper(
                        substr(
                            $companyName,
                            0,
                            1
                        )
                    ) }}
                </div>

            @endif

        </div>


        <div>

            <h2 class="h5 mb-1">
                Company
            </h2>

            <div class="fw-semibold">
                {{ $companyName }}
            </div>

        </div>

    </div>


    <div class="row g-3">


        {{-- COMPANY NAME --}}
        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Company Name
                </div>

                <div class="fw-semibold">
                    {{ $companyName }}
                </div>

            </div>

        </div>



        {{-- EMAIL --}}
        <div class="col-12 col-md-6">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Contact Email
                </div>

                <div class="fw-semibold text-break">
                    {{ $company?->email ?? 'Unavailable' }}
                </div>

            </div>

        </div>



        {{-- INDUSTRY --}}
        @if ($companyProfile?->industry)

            <div class="col-12 col-md-6">

                <div class="bg-light rounded-3 p-3 h-100">

                    <div class="small text-secondary mb-1">
                        Industry
                    </div>

                    <div class="fw-semibold">
                        {{ $companyProfile->industry }}
                    </div>

                </div>

            </div>

        @endif



        {{-- LOCATION --}}
        @if ($companyProfile?->location)

            <div class="col-12 col-md-6">

                <div class="bg-light rounded-3 p-3 h-100">

                    <div class="small text-secondary mb-1">
                        Company Location
                    </div>

                    <div class="fw-semibold">
                        {{ $companyProfile->location }}
                    </div>

                </div>

            </div>

        @endif



        {{-- WEBSITE --}}
        @if ($companyProfile?->website)

            <div class="col-12">

                <div class="bg-light rounded-3 p-3">

                    <div class="small text-secondary mb-1">
                        Website
                    </div>

                    <a
                        href="{{ $companyProfile->website }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ $companyProfile->website }}
                    </a>

                </div>

            </div>

        @endif

    </div>


    {{-- DESCRIPTION --}}
    @if ($companyProfile?->description)

        <div class="mt-4">

            <h3 class="h6 mb-2">
                About the Company
            </h3>

            <p
                class="text-secondary mb-0"
                style="white-space: pre-line;"
            >{{ $companyProfile->description }}</p>

        </div>

    @endif

</div>



{{-- =========================================================
     DANGER ZONE
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
                Delete Job Post
            </h2>

            <p class="mb-0">
                Permanently remove this job post
                from SkillMatch.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route(
                'admin.job-posts.destroy',
                $jobPost
            ) }}"
            onsubmit="return confirm(
                'Permanently delete this job post?'
            )"
        >
            @csrf
            @method('DELETE')


            <button
                type="submit"
                class="btn btn-danger"
            >
                Delete Job Post
            </button>

        </form>

    </div>

</div>

@endsection