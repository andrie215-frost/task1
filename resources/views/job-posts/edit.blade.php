@extends('layouts.app')

@section('title', 'Edit Job Post - SkillMatch')

@section('content')

@php
    $selectedJobType = old(
        'job_type',
        $jobPost->job_type
    );

    $currentJobTypeIsActive =
        $jobTypeOptions->contains(
            $jobPost->job_type
        );
@endphp


<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <h1 class="h3 mb-2">
                Edit Job Post
            </h1>

            <p class="text-secondary mb-0">
                Update the details, skills, or status
                of this job opportunity.
            </p>

        </div>

        <a
            href="{{ route('job-posts.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Job Posts
        </a>

    </div>

</div>


<div class="bg-white border rounded-4 shadow-sm p-4">

    <form
        method="POST"
        action="{{ route('job-posts.update', $jobPost) }}"
    >
        @csrf
        @method('PATCH')


        {{-- JOB TITLE --}}
        <div class="mb-4">

            <label
                for="title"
                class="form-label fw-semibold"
            >
                Job Title
            </label>

            <input
                id="title"
                name="title"
                type="text"
                class="form-control
                       @error('title') is-invalid @enderror"
                value="{{ old(
                    'title',
                    $jobPost->title
                ) }}"
                required
            >

            @error('title')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- DESCRIPTION --}}
        <div class="mb-4">

            <label
                for="description"
                class="form-label fw-semibold"
            >
                Job Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                class="form-control
                       @error('description') is-invalid @enderror"
            >{{ old(
                'description',
                $jobPost->description
            ) }}</textarea>

            @error('description')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="row g-4">


            {{-- LOCATION --}}
            <div class="col-12 col-md-6">

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
                    class="form-control
                           @error('location') is-invalid @enderror"
                    value="{{ old(
                        'location',
                        $jobPost->location
                    ) }}"
                    required
                >

                @error('location')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- JOB TYPE --}}
            <div class="col-12 col-md-6">

                <label
                    for="job_type"
                    class="form-label fw-semibold"
                >
                    Job Type
                </label>

                <select
                    id="job_type"
                    name="job_type"
                    class="form-select
                           @error('job_type') is-invalid @enderror"
                    required
                    @disabled($jobTypeOptions->isEmpty())
                >

                    <option value="">
                        Select job type
                    </option>

                    @foreach ($jobTypeOptions as $jobType)

                        <option
                            value="{{ $jobType }}"
                            @selected(
                                $selectedJobType === $jobType
                            )
                        >
                            {{ $jobType }}
                        </option>

                    @endforeach

                </select>

                @error('job_type')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror


                @if ($jobTypeOptions->isEmpty())

                    <div class="form-text text-danger">
                        No active job types are currently available.
                        Please contact the administrator.
                    </div>

                @elseif (! $currentJobTypeIsActive)

                    <div class="form-text text-warning-emphasis">
                        The current job type
                        "{{ $jobPost->job_type }}"
                        is no longer active. Please select
                        an active job type before saving.
                    </div>

                @endif

            </div>


            {{-- EXPERIENCE --}}
            <div class="col-12 col-md-6">

                <label
                    for="minimum_experience"
                    class="form-label fw-semibold"
                >
                    Minimum Experience
                </label>

                <div class="input-group">

                    <input
                        id="minimum_experience"
                        name="minimum_experience"
                        type="number"
                        min="0"
                        max="60"
                        class="form-control
                               @error('minimum_experience')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'minimum_experience',
                            $jobPost->minimum_experience
                        ) }}"
                        required
                    >

                    <span class="input-group-text">
                        Years
                    </span>

                    @error('minimum_experience')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="form-text">
                    Use 0 if no previous work experience
                    is required.
                </div>

            </div>


            {{-- STATUS --}}
            <div class="col-12 col-md-6">

                <label
                    for="status"
                    class="form-label fw-semibold"
                >
                    Job Post Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-select
                           @error('status') is-invalid @enderror"
                    required
                >

                    <option
                        value="open"
                        @selected(
                            old(
                                'status',
                                $jobPost->status
                            ) === 'open'
                        )
                    >
                        Open
                    </option>

                    <option
                        value="closed"
                        @selected(
                            old(
                                'status',
                                $jobPost->status
                            ) === 'closed'
                        )
                    >
                        Closed
                    </option>

                </select>

                @error('status')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

                <div class="form-text">
                    Closed jobs remain in your records
                    but are hidden from the worker job feed.
                </div>

            </div>

        </div>


        <hr class="my-4">


        {{-- REQUIRED SKILLS --}}
        @include('partials.skill-picker', [

            'pickerId' => 'editJobSkills',

            'pickerSkills' => $skills,

            'selectedIds' => old(
                'skill_ids',
                $jobPost->skills->pluck('id')->all()
            ),

            'pickerTitle' => 'Required Skills',

            'pickerHelp' =>
                'Optional. Leave all skills unchecked if no specific skill is required.',

        ])


        {{-- ACTIONS --}}
        <div
            class="border-top pt-4 mt-4
                   d-flex flex-column flex-sm-row
                   justify-content-end gap-2"
        >

            <a
                href="{{ route('job-posts.index') }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
                @disabled($jobTypeOptions->isEmpty())
            >
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection