@extends('layouts.app')

@section('title', 'My Job Posts - SkillMatch')

@section('content')

<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between align-items-md-center gap-3"
    >

        <div>

            <h1 class="h3 mb-2">
                My Job Posts
            </h1>

            <p class="text-secondary mb-0">
                Create and manage the job opportunities
                posted by your company.
            </p>

        </div>


        <a
            href="{{ route('job-posts.create') }}"
            class="btn btn-primary"
        >
            + Post a Job
        </a>

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
                <rect
                    x="5"
                    y="4"
                    width="14"
                    height="17"
                    rx="2"
                />
                <path d="M9 8h6"/>
                <path d="M9 12h6"/>
                <path d="M9 16h4"/>
            </svg>
        </div>

        <h2 class="h5 mb-2">
            No job posts yet
        </h2>

        <p class="text-secondary mb-3">
            Your company has not posted any jobs yet.
            Create your first job opportunity to get started.
        </p>

        <a
            href="{{ route('job-posts.create') }}"
            class="btn btn-primary btn-sm"
        >
            Post Your First Job
        </a>

    </div>


@else

    <div class="row g-4">

        @foreach ($jobPosts as $jobPost)

            <div class="col-12">

                <div
                    class="bg-white border rounded-4
                           shadow-sm p-4"
                >

                    {{-- HEADER --}}
                    <div
                        class="d-flex flex-column flex-lg-row
                               justify-content-between
                               align-items-lg-start gap-3 mb-4"
                    >

                        <div>

                            <div
                                class="d-flex flex-wrap
                                       align-items-center gap-2 mb-2"
                            >

                                <h2 class="h4 mb-0">
                                    {{ $jobPost->title }}
                                </h2>


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


                            <div class="text-secondary small">

                                Posted
                                {{ $jobPost->created_at->diffForHumans() }}

                            </div>

                        </div>


                        {{-- ACTIONS --}}
                        <div
                            class="d-flex flex-wrap
                                   align-items-center gap-2"
                        >

                            <a
                                href="{{ route(
                                    'job-posts.edit',
                                    $jobPost
                                ) }}"
                                class="btn btn-outline-primary btn-sm"
                            >
                                Edit
                            </a>


                            <form
                                method="POST"
                                action="{{ route(
                                    'job-posts.destroy',
                                    $jobPost
                                ) }}"
                                class="m-0"
                                onsubmit="return confirm(
                                    'Are you sure you want to delete this job post?'
                                )"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>


                    {{-- JOB INFORMATION --}}
                    <div class="row g-3 mb-4">

                        <div class="col-12 col-md-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div
                                    class="small text-secondary mb-1"
                                >
                                    Location
                                </div>

                                <div class="fw-semibold">
                                    {{ $jobPost->location }}
                                </div>

                            </div>

                        </div>


                        <div class="col-12 col-md-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div
                                    class="small text-secondary mb-1"
                                >
                                    Job Type
                                </div>

                                <div class="fw-semibold">
                                    {{ $jobPost->job_type }}
                                </div>

                            </div>

                        </div>


                        <div class="col-12 col-md-4">

                            <div
                                class="bg-light rounded-3
                                       p-3 h-100"
                            >

                                <div
                                    class="small text-secondary mb-1"
                                >
                                    Minimum Experience
                                </div>

                                <div class="fw-semibold">

                                    {{ $jobPost->minimum_experience }}

                                    {{ Str::plural(
                                        'year',
                                        $jobPost->minimum_experience
                                    ) }}

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- DESCRIPTION --}}
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


                    {{-- SKILLS --}}
                    <div>

                        <h3 class="h6 mb-2">
                            Required Skills
                            <span
                                class="text-secondary fw-normal"
                            >
                                (Optional)
                            </span>
                        </h3>


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

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection