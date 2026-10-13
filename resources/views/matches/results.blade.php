@extends('layouts.app')

@section('title', 'Match Results - SkillMatch')

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

            <h1 class="h3 mb-2">
                Match Results
            </h1>

            <p class="text-secondary mb-0">
                Found {{ $results->count() }} {{ $targetType }}.
            </p>

        </div>


        <a
            href="{{ route('matches.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Matching
        </a>

    </div>


    <hr class="my-4">


    {{-- SEARCH CRITERIA --}}
    <h2 class="h6 mb-3">
        Search Criteria
    </h2>


    <div class="row g-3">

        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Position / Role
                </div>

                <div class="fw-semibold">
                    {{ $searchCriteria['position'] }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Location
                </div>

                <div class="fw-semibold">
                    {{ $searchCriteria['location'] }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">
                    Job Type
                </div>

                <div class="fw-semibold">
                    {{ $searchCriteria['job_type'] }}
                </div>

            </div>

        </div>


        <div class="col-12 col-md-6 col-lg-3">

            <div class="bg-light rounded-3 p-3 h-100">

                <div class="small text-secondary mb-1">

                    @if ($resultType === 'workers')

                        Minimum Experience

                    @else

                        Your Experience

                    @endif

                </div>


                <div class="fw-semibold">

                    {{ $searchCriteria['experience'] }}

                    {{ Str::plural(
                        'year',
                        $searchCriteria['experience']
                    ) }}

                </div>

            </div>

        </div>

    </div>


    {{-- SELECTED SKILLS --}}
    <div class="mt-3">

        <div class="small text-secondary mb-2">

            @if ($resultType === 'workers')

                Required Skills

            @else

                Skills You Want to Use

            @endif

            <span class="fw-normal">
                (Optional)
            </span>

        </div>


        @forelse ($selectedSkills as $skillName)

            <span class="badge text-bg-primary me-1 mb-1">
                {{ $skillName }}
            </span>

        @empty

            <span class="badge text-bg-light border text-secondary">
                No skills selected
            </span>

        @endforelse

    </div>

</div>



{{-- =========================================================
     NO RESULTS
     ========================================================= --}}
@if ($results->isEmpty())

    <div class="bg-white border rounded-4 shadow-sm p-5 text-center">

        <div class="fs-1 mb-3">
            🔎
        </div>


        @if ($resultType === 'workers')

            <h2 class="h4 mb-2">
                No available workers found
            </h2>

            <p class="text-secondary mb-4">
                Try changing your matching criteria.
            </p>

        @else

            <h2 class="h4 mb-2">
                No open jobs found
            </h2>

            <p class="text-secondary mb-4">
                Try changing your matching criteria.
            </p>

        @endif


        <a
            href="{{ route('matches.index') }}"
            class="btn btn-primary"
        >
            Try Another Search
        </a>

    </div>


@else


    <div class="row g-4">


        @foreach ($results as $result)

            @php

                /*
                 * =====================================================
                 * WORKER RESULT
                 * =====================================================
                 */
                if ($resultType === 'workers') {

                    $worker = $result;

                    $workerProfile =
                        $worker->skilledProfile;

                    $resultTitle =
                        $worker->name;

                    $resultSubtitle =
                        $workerProfile?->professional_title
                        ?? 'Skilled Person';

                    $matchPercentage =
                        $worker->match_percentage;

                    $matchBreakdown =
                        $worker->match_breakdown ?? [];


                    /*
                     * Company contacting Skilled Person.
                     */
                    $currentCompany =
                        auth()->user();

                    $currentCompanyName =
                        $currentCompany->companyProfile?->company_name
                        ?? $currentCompany->name;

                    $workerMailSubject =
                        'Opportunity Inquiry - '
                        . $currentCompanyName;

                    $workerMailBody =
                        "Hello {$worker->name},\n\n"
                        . "I found your profile on SkillMatch "
                        . "and would like to discuss a potential "
                        . "job opportunity with you.\n\n"
                        . "Company: {$currentCompanyName}\n\n"
                        . "Please reply to this email if you are "
                        . "interested in discussing the opportunity.\n\n"
                        . "Thank you.";

                }


                /*
                 * =====================================================
                 * JOB RESULT
                 * =====================================================
                 */
                else {

                    $jobPost = $result;

                    $company =
                        $jobPost->company;

                    $companyProfile =
                        $company?->companyProfile;

                    $resultTitle =
                        $jobPost->title;

                    $resultSubtitle =
                        $companyProfile?->company_name
                        ?? $company?->name
                        ?? 'Company';

                    $matchPercentage =
                        $jobPost->match_percentage;

                    $matchBreakdown =
                        $jobPost->match_breakdown ?? [];


                    /*
                     * Skilled Person contacting Company.
                     */
                    $currentWorker =
                        auth()->user();

                    $currentWorkerName =
                        $currentWorker->name;

                    $companyName =
                        $companyProfile?->company_name
                        ?? $company?->name
                        ?? 'Company';

                    $jobMailSubject =
                        'Job Inquiry - '
                        . $jobPost->title;

                    $jobMailBody =
                        "Hello {$companyName},\n\n"
                        . "I am interested in the "
                        . "{$jobPost->title} position "
                        . "posted on SkillMatch.\n\n"
                        . "My name is {$currentWorkerName}, "
                        . "and I would like to ask for more "
                        . "information about this opportunity.\n\n"
                        . "Thank you.";
                }


                /*
                 * =====================================================
                 * MATCH BADGE
                 * =====================================================
                 */
                if ($matchPercentage >= 80) {

                    $matchBadgeClass =
                        'text-bg-success';

                } elseif ($matchPercentage >= 50) {

                    $matchBadgeClass =
                        'text-bg-warning';

                } else {

                    $matchBadgeClass =
                        'text-bg-secondary';
                }

            @endphp


            <div class="col-12">

                <div class="bg-white border rounded-4 shadow-sm p-4">


                    {{-- RESULT HEADER --}}
                    <div
                        class="d-flex flex-column flex-md-row
                               justify-content-between
                               align-items-md-start gap-3 mb-4"
                    >

                        <div>

                            <h2 class="h4 mb-1">
                                {{ $resultTitle }}
                            </h2>

                            <p class="text-secondary mb-0">
                                {{ $resultSubtitle }}
                            </p>

                        </div>


                        <div class="text-md-end">

                            <span
                                class="badge {{ $matchBadgeClass }}
                                       fs-6 px-3 py-2"
                            >
                                {{ $matchPercentage }}% Match
                            </span>

                        </div>

                    </div>



                    {{-- MATCH PROGRESS --}}
                    <div class="mb-4">

                        <div
                            class="d-flex justify-content-between
                                   small mb-2"
                        >

                            <span class="text-secondary">
                                Overall match
                            </span>

                            <span class="fw-semibold">
                                {{ $matchPercentage }}%
                            </span>

                        </div>


                        <div
                            class="progress"
                            role="progressbar"
                            aria-valuenow="{{ $matchPercentage }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="height: 8px;"
                        >

                            <div
                                class="progress-bar"
                                style="width: {{ $matchPercentage }}%"
                            ></div>

                        </div>

                    </div>



                    {{-- WHY THIS MATCH --}}
                    <div class="mb-4">

                        <h3 class="h6 mb-3">
                            Why this match?
                        </h3>


                        <div class="row g-2">


                            @foreach ($matchBreakdown as $item)

                                <div class="col-12 col-md-6 col-xl-4">

                                    <div
                                        class="border rounded-3
                                               p-3 h-100
                                               d-flex align-items-start gap-3"
                                    >

                                        <div class="flex-shrink-0">

                                            @if ($item['status'] === 'match')

                                                <span
                                                    class="badge rounded-pill
                                                           text-bg-success"
                                                >
                                                    ✓
                                                </span>

                                            @elseif ($item['status'] === 'partial')

                                                <span
                                                    class="badge rounded-pill
                                                           text-bg-warning"
                                                >
                                                    ~
                                                </span>

                                            @else

                                                <span
                                                    class="badge rounded-pill
                                                           text-bg-secondary"
                                                >
                                                    ✕
                                                </span>

                                            @endif

                                        </div>


                                        <div class="flex-grow-1">

                                            <div class="fw-semibold mb-1">
                                                {{ $item['name'] }}
                                            </div>


                                            @if ($item['status'] === 'match')

                                                <div class="small text-success mb-2">
                                                    Matched
                                                </div>

                                            @elseif ($item['status'] === 'partial')

                                                <div class="small text-warning mb-2">
                                                    Partial match
                                                </div>

                                            @else

                                                <div class="small text-secondary mb-2">
                                                    Did not match
                                                </div>

                                            @endif


                                            <div class="small">

                                                <div class="text-secondary">

                                                    @if ($resultType === 'workers')

                                                        Looking for

                                                    @else

                                                        Your criteria

                                                    @endif

                                                </div>


                                                <div class="mb-2">
                                                    {{ $item['wanted'] }}
                                                </div>


                                                <div class="text-secondary">

                                                    @if ($resultType === 'workers')

                                                        Worker

                                                    @else

                                                        Job

                                                    @endif

                                                </div>


                                                <div>
                                                    {{ $item['candidate'] }}
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        @if ($selectedSkills->isEmpty())

                            <div class="alert alert-light border mt-3 mb-0">

                                <small class="text-secondary">
                                    Skills were not included in this search,
                                    so they did not affect the match percentage.
                                </small>

                            </div>

                        @endif

                    </div>



                    {{-- =====================================================
                         WORKER RESULT
                         ===================================================== --}}
                    @if ($resultType === 'workers')

                        <div class="row g-3 mb-4">


                            {{-- LOCATION --}}
                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="bg-light rounded-3 p-3 h-100">

                                    <div class="small text-secondary mb-1">
                                        Location
                                    </div>

                                    <div class="fw-semibold">
                                        {{ $workerProfile?->location }}
                                    </div>

                                </div>

                            </div>


                            {{-- EXPERIENCE --}}
                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="bg-light rounded-3 p-3 h-100">

                                    <div class="small text-secondary mb-1">
                                        Experience
                                    </div>

                                    <div class="fw-semibold">

                                        {{ $workerProfile?->experience_years ?? 0 }}

                                        {{ Str::plural(
                                            'year',
                                            $workerProfile?->experience_years ?? 0
                                        ) }}

                                    </div>

                                </div>

                            </div>


                            {{-- JOB TYPE --}}
                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="bg-light rounded-3 p-3 h-100">

                                    <div class="small text-secondary mb-1">
                                        Preferred Job Type
                                    </div>

                                    <div class="fw-semibold">
                                        {{ $workerProfile?->preferred_job_type }}
                                    </div>

                                </div>

                            </div>


                            {{-- AVAILABILITY --}}
                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="bg-light rounded-3 p-3 h-100">

                                    <div class="small text-secondary mb-1">
                                        Availability
                                    </div>


                                    @if ($workerProfile?->is_available)

                                        <span class="badge text-bg-success">
                                            Available
                                        </span>

                                    @else

                                        <span class="badge text-bg-secondary">
                                            Unavailable
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- BIO --}}
                        @if ($workerProfile?->bio)

                            <div class="mb-4">

                                <h3 class="h6 mb-2">
                                    About
                                </h3>

                                <p class="text-secondary mb-0">
                                    {{ $workerProfile->bio }}
                                </p>

                            </div>

                        @endif


                        {{-- WORKER SKILLS --}}
                        <div class="mb-4">

                            <h3 class="h6 mb-3">
                                Skills
                            </h3>


                            @forelse ($worker->skills as $skill)

                                @if ($currentSkillIds->contains($skill->id))

                                    <span
                                        class="badge text-bg-success
                                               me-1 mb-1"
                                    >
                                        {{ $skill->name }} ✓
                                    </span>

                                @else

                                    <span
                                        class="badge text-bg-secondary
                                               me-1 mb-1"
                                    >
                                        {{ $skill->name }}
                                    </span>

                                @endif

                            @empty

                                <span
                                    class="badge text-bg-light
                                           border text-secondary"
                                >
                                    No skills listed
                                </span>

                            @endforelse

                        </div>


                        {{-- WORKER ACTIONS --}}
                        <div
                            class="border-top pt-3
                                   d-flex flex-column flex-md-row
                                   justify-content-between
                                   align-items-md-center gap-3"
                        >

                            <div>

                                <div class="small text-secondary">
                                    Contact Email
                                </div>

                                <div class="fw-semibold">
                                    {{ $worker->email }}
                                </div>

                            </div>


                            <div class="d-flex flex-wrap gap-2">

                                <a
                                    href="{{ route(
                                        'people.show',
                                        $worker
                                    ) }}"
                                    class="btn btn-outline-primary"
                                >
                                    View Profile
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'people.contact',
                                        $worker
                                    ) }}"
                                    class="m-0"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="subject"
                                        value="{{ $workerMailSubject }}"
                                    >

                                    <textarea
                                        name="message"
                                        class="d-none"
                                    >{{ $workerMailBody }}</textarea>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Send Message
                                    </button>

                                </form>

                            </div>

                        </div>



                    {{-- =====================================================
                         JOB POST RESULT
                         ===================================================== --}}
                    @else


                        <div class="row g-3 mb-4">


                            {{-- COMPANY --}}
                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="bg-light rounded-3 p-3 h-100">

                                    <div class="small text-secondary mb-1">
                                        Company
                                    </div>

                                    <div class="fw-semibold">

                                        {{ $companyProfile?->company_name
                                            ?? $company?->name
                                            ?? 'Company' }}

                                    </div>

                                </div>

                            </div>


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

                        </div>


                        {{-- JOB DESCRIPTION --}}
                        @if ($jobPost->description)

                            <div class="mb-4">

                                <h3 class="h6 mb-2">
                                    Job Description
                                </h3>

                                <p class="text-secondary mb-0">
                                    {{ $jobPost->description }}
                                </p>

                            </div>

                        @endif


                        {{-- REQUIRED SKILLS --}}
                        <div class="mb-4">

                            <h3 class="h6 mb-3">
                                Required Skills
                            </h3>


                            @forelse ($jobPost->skills as $skill)

                                @if ($currentSkillIds->contains($skill->id))

                                    <span
                                        class="badge text-bg-success
                                               me-1 mb-1"
                                    >
                                        {{ $skill->name }} ✓
                                    </span>

                                @else

                                    <span
                                        class="badge text-bg-primary
                                               me-1 mb-1"
                                    >
                                        {{ $skill->name }}
                                    </span>

                                @endif

                            @empty

                                <span
                                    class="badge text-bg-light
                                           border text-secondary"
                                >
                                    No specific skills required
                                </span>

                            @endforelse

                        </div>


                        {{-- JOB ACTIONS --}}
                        <div
                            class="border-top pt-3
                                   d-flex flex-column flex-md-row
                                   justify-content-between
                                   align-items-md-center gap-3"
                        >

                            <div>

                                <div class="small text-secondary">
                                    Company Email
                                </div>


                                @if ($company?->email)

                                    <div class="fw-semibold">
                                        {{ $company->email }}
                                    </div>

                                @else

                                    <span class="text-secondary">
                                        Email unavailable
                                    </span>

                                @endif

                            </div>


                            <div class="d-flex flex-wrap gap-2">

                                <a
                                    href="{{ route(
                                        'jobs.show',
                                        $jobPost
                                    ) }}"
                                    class="btn btn-outline-primary"
                                >
                                    View Job Details
                                </a>


                                @if ($company?->email)

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'jobs.contact',
                                            $jobPost
                                        ) }}"
                                        class="m-0"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="subject"
                                            value="{{ $jobMailSubject }}"
                                        >

                                        <textarea
                                            name="message"
                                            class="d-none"
                                        >{{ $jobMailBody }}</textarea>

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Send Message
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection