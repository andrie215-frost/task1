@extends('layouts.app')

@section(
    'title',
    $skilledPerson->name . ' - SkillMatch'
)

@section('content')

@php
    $company =
        auth()->user();

    $companyName =
        $company->companyProfile?->company_name
        ?? $company->name;

    $defaultSubject =
        'Job Opportunity from ' . $companyName;

    $defaultMessage =
        "Hello {$skilledPerson->name},\n\n"
        . "I found your profile on SkillMatch and would like "
        . "to discuss a potential job opportunity with you.\n\n"
        . "Company: {$companyName}\n\n"
        . "Please reply to this email if you are interested "
        . "in discussing the opportunity.\n\n"
        . "Thank you.";
@endphp


{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-lg-row
               justify-content-between align-items-lg-center gap-3"
    >

        <div class="d-flex align-items-center gap-3">

            {{-- PROFILE IMAGE --}}
            <div class="flex-shrink-0">

                @if ($skilledPerson->profile_image)

                    <img
                        src="{{ asset(
                            'storage/' . $skilledPerson->profile_image
                        ) }}"
                        alt="{{ $skilledPerson->name }}"
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
                                $skilledPerson->name,
                                0,
                                1
                            )
                        ) }}
                    </div>

                @endif

            </div>


            <div>

                <div
                    class="d-flex flex-wrap align-items-center
                           gap-2 mb-2"
                >

                    <h1 class="h3 mb-0">
                        {{ $skilledPerson->name }}
                    </h1>


                    @if ($profile->is_available)

                        <span class="badge text-bg-success">
                            Available for Work
                        </span>

                    @else

                        <span class="badge text-bg-secondary">
                            Not Available
                        </span>

                    @endif

                </div>


                <div class="fw-semibold text-primary mb-1">
                    {{ $profile->professional_title }}
                </div>


                <div class="small text-secondary">
                    Skilled Person Profile
                </div>

            </div>

        </div>


        <a
            href="{{ route('matches.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Find People
        </a>

    </div>

</div>


<div class="row g-4">


    {{-- MAIN PROFILE --}}
    <div class="col-12 col-lg-8">


        {{-- ABOUT --}}
        <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

            <h2 class="h5 mb-3">
                About
            </h2>


            @if ($profile->bio)

                <p
                    class="text-secondary mb-0"
                    style="white-space: pre-line;"
                >{{ $profile->bio }}</p>

            @else

                <p class="text-secondary mb-0">
                    No professional summary was provided.
                </p>

            @endif

        </div>


        {{-- SKILLS --}}
        <div class="bg-white border rounded-4 shadow-sm p-4">

            <div
                class="d-flex justify-content-between
                       align-items-center gap-3 mb-3"
            >

                <div>

                    <h2 class="h5 mb-1">
                        Skills
                    </h2>

                    <p class="text-secondary small mb-0">
                        Skills listed by this Skilled Person.
                    </p>

                </div>


                <span class="badge text-bg-light border text-secondary">
                    {{ $skilledPerson->skills->count() }}

                    {{ Str::plural(
                        'skill',
                        $skilledPerson->skills->count()
                    ) }}
                </span>

            </div>


            @forelse ($skilledPerson->skills as $skill)

                <span
                    class="badge text-bg-primary
                           me-1 mb-2 px-3 py-2"
                >
                    {{ $skill->name }}
                </span>

            @empty

                <div class="alert alert-light border mb-0">

                    <div class="fw-semibold">
                        No skills listed.
                    </div>

                    <div class="small text-secondary mt-1">
                        This Skilled Person has not selected
                        any skills yet.
                    </div>

                </div>

            @endforelse

        </div>

    </div>


    {{-- PROFILE SIDEBAR --}}
    <div class="col-12 col-lg-4">


        {{-- PROFESSIONAL DETAILS --}}
        <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

            <h2 class="h5 mb-4">
                Professional Details
            </h2>


            {{-- PROFESSIONAL TITLE --}}
            <div class="border-bottom pb-3 mb-3">

                <div class="small text-secondary mb-1">
                    Professional Title
                </div>

                <div class="fw-semibold">
                    {{ $profile->professional_title }}
                </div>

            </div>


            {{-- LOCATION --}}
            <div class="border-bottom pb-3 mb-3">

                <div class="small text-secondary mb-1">
                    Location
                </div>

                <div class="fw-semibold">
                    {{ $profile->location }}
                </div>

            </div>


            {{-- EXPERIENCE --}}
            <div class="border-bottom pb-3 mb-3">

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


            {{-- PREFERRED JOB TYPE --}}
            <div class="border-bottom pb-3 mb-3">

                <div class="small text-secondary mb-1">
                    Preferred Job Type
                </div>

                <div class="fw-semibold">
                    {{ $profile->preferred_job_type }}
                </div>

            </div>


            {{-- AVAILABILITY --}}
            <div>

                <div class="small text-secondary mb-1">
                    Availability
                </div>

                <div class="fw-semibold">

                    @if ($profile->is_available)

                        <span class="text-success">
                            Available for work
                        </span>

                    @else

                        <span class="text-secondary">
                            Currently unavailable
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- CONTACT --}}
        <div class="bg-white border rounded-4 shadow-sm p-4">

            <h2 class="h5 mb-2">
                Contact Skilled Person
            </h2>

            <p class="text-secondary small mb-4">
                Send a message directly through SkillMatch.
            </p>


            <div class="mb-4">

                <div class="small text-secondary mb-1">
                    Email
                </div>

                <div class="fw-semibold text-break">
                    {{ $skilledPerson->email }}
                </div>

            </div>


            <form
                method="POST"
                action="{{ route(
                    'people.contact',
                    $skilledPerson
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