@extends('layouts.app')

@section('title', $jobPost->title . ' - SkillMatch')

@section('content')

@php
    $company = $jobPost->company;

    $companyProfile =
        $company->companyProfile;

    $companyName =
        $companyProfile?->company_name
        ?? $company->name;

    $worker =
        auth()->user();

    $workerName =
        $worker->name;

    $defaultSubject =
        'Job Inquiry - ' . $jobPost->title;

    $defaultMessage =
        "Hello {$companyName},\n\n"
        . "I am interested in the {$jobPost->title} position "
        . "posted on SkillMatch.\n\n"
        . "My name is {$workerName}, and I would like to ask "
        . "for more information about this opportunity.\n\n"
        . "Thank you.";
@endphp


{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-lg-row
               justify-content-between align-items-lg-start gap-3"
    >

        <div>

            <div
                class="d-flex flex-wrap align-items-center
                       gap-2 mb-2"
            >

                <h1 class="h3 mb-0">
                    {{ $jobPost->title }}
                </h1>

                <span class="badge text-bg-success">
                    Open
                </span>

            </div>


            <div class="text-secondary mb-2">
                {{ $companyName }}
            </div>


            <div class="small text-secondary">

                Posted
                {{ $jobPost->created_at->diffForHumans() }}

            </div>

        </div>


        <a
            href="{{ route('jobs.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Job Feed
        </a>

    </div>

</div>


<div class="row g-4">


    {{-- MAIN JOB INFORMATION --}}
    <div class="col-12 col-lg-8">


        <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

            <h2 class="h5 mb-4">
                Job Information
            </h2>


            <div class="row g-3">

                {{-- LOCATION --}}
                <div class="col-12 col-md-4">

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
                <div class="col-12 col-md-4">

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
                <div class="col-12 col-md-4">

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

            </div>

        </div>


        {{-- DESCRIPTION --}}
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
                    No job description was provided.
                </p>

            @endif

        </div>


        {{-- REQUIRED SKILLS --}}
        <div class="bg-white border rounded-4 shadow-sm p-4">

            <h2 class="h5 mb-2">
                Required Skills
            </h2>

            <p class="text-secondary mb-3">
                Skills requested by the company for this position.
            </p>


            @forelse ($jobPost->skills as $skill)

                <span
                    class="badge text-bg-primary
                           me-1 mb-1 px-3 py-2"
                >
                    {{ $skill->name }}
                </span>

            @empty

                <div class="alert alert-light border mb-0">

                    <strong>
                        No specific skills required.
                    </strong>

                    <div class="small text-secondary mt-1">
                        Workers without listed skills can still
                        qualify for this opportunity.
                    </div>

                </div>

            @endforelse

        </div>

    </div>


    {{-- COMPANY SIDEBAR --}}
    <div class="col-12 col-lg-4">


        {{-- ABOUT COMPANY --}}
        <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

            <h2 class="h5 mb-3">
                About the Company
            </h2>


            <div class="mb-3">

                <div class="small text-secondary mb-1">
                    Company
                </div>

                <div class="fw-semibold">
                    {{ $companyName }}
                </div>

            </div>


            @if ($companyProfile?->industry)

                <div class="mb-3">

                    <div class="small text-secondary mb-1">
                        Industry
                    </div>

                    <div class="fw-semibold">
                        {{ $companyProfile->industry }}
                    </div>

                </div>

            @endif


            @if ($companyProfile?->location)

                <div class="mb-3">

                    <div class="small text-secondary mb-1">
                        Company Location
                    </div>

                    <div class="fw-semibold">
                        {{ $companyProfile->location }}
                    </div>

                </div>

            @endif


            @if ($companyProfile?->description)

                <div class="mb-3">

                    <div class="small text-secondary mb-1">
                        About
                    </div>

                    <p class="mb-0">
                        {{ $companyProfile->description }}
                    </p>

                </div>

            @endif


            @if ($companyProfile?->website)

                <div class="mb-3">

                    <a
                        href="{{ $companyProfile->website }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-outline-primary btn-sm"
                    >
                        Visit Company Website
                    </a>

                </div>

            @endif

        </div>


        {{-- CONTACT COMPANY --}}
        <div class="bg-white border rounded-4 shadow-sm p-4">

            <h2 class="h5 mb-2">
                Interested in this job?
            </h2>

            <p class="text-secondary small mb-4">
                Send a message directly through SkillMatch.
            </p>


            <div class="mb-4">

                <div class="small text-secondary mb-1">
                    Company Email
                </div>

                <div class="fw-semibold text-break">
                    {{ $company->email }}
                </div>

            </div>


            <form
                method="POST"
                action="{{ route(
                    'jobs.contact',
                    $jobPost
                ) }}"
            >
                @csrf


                {{-- SUBJECT --}}
                <div class="mb-3">

                    <label
                        for="subject"
                        class="form-label fw-semibold"
                    >
                        Subject
                    </label>

                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        class="form-control
                               @error('subject')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'subject',
                            $defaultSubject
                        ) }}"
                        required
                    >

                    @error('subject')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- MESSAGE --}}
                <div class="mb-3">

                    <label
                        for="message"
                        class="form-label fw-semibold"
                    >
                        Message
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="8"
                        class="form-control
                               @error('message')
                                   is-invalid
                               @enderror"
                        required
                    >{{ old(
                        'message',
                        $defaultMessage
                    ) }}</textarea>

                    @error('message')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Send Message
                    </button>

                </div>

            </form>


            <div class="small text-secondary mt-3">
                Your message is sent through SkillMatch
                using the configured email service.
            </div>

        </div>

    </div>

</div>

@endsection