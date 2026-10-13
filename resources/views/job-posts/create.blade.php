@extends('layouts.app')

@section('title', 'Post a Job - SkillMatch')

@section('content')

<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <h1 class="h3 mb-2">
                Post a Job
            </h1>

            <p class="text-secondary mb-0">
                Create a new job opportunity for skilled
                or non-skilled workers.
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
        action="{{ route('job-posts.store') }}"
    >
        @csrf


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
                value="{{ old('title') }}"
                placeholder="Example: Web Developer, Cashier, Helper"
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
                class="form-control
                       @error('description') is-invalid @enderror"
                rows="5"
                placeholder="Describe the responsibilities and job details."
            >{{ old('description') }}</textarea>

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
                        auth()->user()->companyProfile?->location
                    ) }}"
                    placeholder="Example: Hilongos, Leyte"
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
                                old('job_type') === $jobType
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
                            0
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
                    Enter 0 if no previous work experience
                    is required.
                </div>

            </div>

        </div>


        <hr class="my-4">


        {{-- REQUIRED SKILLS --}}
        @include('partials.skill-picker', [

            'pickerId' => 'createJobSkills',

            'pickerSkills' => $skills,

            'selectedIds' => old(
                'skill_ids',
                []
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
                Publish Job Post
            </button>

        </div>

    </form>

</div>

@endsection