@extends('layouts.app')

@section('title', 'Skills Management - SkillMatch')

@section('content')


{{-- =========================================================
     HEADER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h1 class="h3 mb-2">
        Skills Management
    </h1>

    <p class="text-secondary mb-0">
        Create, update, and remove skills used by
        Skilled Person profiles and job posts.
    </p>

</div>



{{-- =========================================================
     CREATE SKILL
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div class="mb-3">

        <h2 class="h5 mb-1">
            Add Skill
        </h2>

        <p class="text-secondary mb-0">
            Add a new skill to the SkillMatch skill list.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.skills.store') }}"
    >
        @csrf


        <div class="row g-3 align-items-end">


            {{-- NAME --}}
            <div class="col-12 col-lg-5">

                <label
                    for="name"
                    class="form-label fw-semibold"
                >
                    Skill Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    class="form-control
                           @error('name')
                               is-invalid
                           @enderror"
                    value="{{ old('name') }}"
                    placeholder="Example: PHP"
                    maxlength="255"
                    required
                >

                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- CATEGORY --}}
            <div class="col-12 col-lg-5">

                <label
                    for="category"
                    class="form-label fw-semibold"
                >
                    Category
                </label>

                <input
                    id="category"
                    name="category"
                    type="text"
                    class="form-control
                           @error('category')
                               is-invalid
                           @enderror"
                    value="{{ old('category') }}"
                    placeholder="Example: Programming"
                    maxlength="255"
                    list="skill-category-options"
                >

                @error('category')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror


                <datalist id="skill-category-options">

                    @foreach ($categories as $categoryOption)

                        <option value="{{ $categoryOption }}">

                    @endforeach

                </datalist>

            </div>



            {{-- ADD BUTTON --}}
            <div class="col-12 col-lg-2">

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Add Skill
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>



{{-- =========================================================
     FILTERS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <form
        method="GET"
        action="{{ route('admin.skills.index') }}"
    >

        <div class="row g-3 align-items-end">


            {{-- SEARCH --}}
            <div class="col-12 col-lg-6">

                <label
                    for="search"
                    class="form-label fw-semibold"
                >
                    Search Skills
                </label>

                <input
                    id="search"
                    name="search"
                    type="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Search by skill or category"
                >

            </div>



            {{-- CATEGORY FILTER --}}
            <div class="col-12 col-md-6 col-lg-4">

                <label
                    for="filter_category"
                    class="form-label fw-semibold"
                >
                    Category
                </label>

                <select
                    id="filter_category"
                    name="category"
                    class="form-select"
                >

                    <option value="">
                        All categories
                    </option>

                    @foreach ($categories as $categoryOption)

                        <option
                            value="{{ $categoryOption }}"
                            @selected(
                                $selectedCategory === $categoryOption
                            )
                        >
                            {{ $categoryOption }}
                        </option>

                    @endforeach

                </select>

            </div>



            {{-- SEARCH BUTTON --}}
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


        @if ($search || $selectedCategory)

            <div class="mt-3">

                <a
                    href="{{ route('admin.skills.index') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Clear Filters
                </a>

            </div>

        @endif

    </form>

</div>



{{-- =========================================================
     SKILLS LIST
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <div
        class="d-flex flex-column flex-md-row
               justify-content-between
               align-items-md-center gap-2 mb-4"
    >

        <div>

            <h2 class="h4 mb-1">
                Skills
            </h2>

            <p class="text-secondary mb-0">

                Showing
                {{ $skills->firstItem() ?? 0 }}

                to
                {{ $skills->lastItem() ?? 0 }}

                of
                {{ $skills->total() }}

                skills.

            </p>

        </div>

    </div>



    @if ($skills->isEmpty())

        <div class="text-center py-4">

            <h3 class="h5 mb-2">
                No skills found
            </h3>

            <p class="text-secondary mb-0">
                Add a skill or change your filters.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>Skill</th>
                        <th>Category</th>
                        <th>Skilled People</th>
                        <th>Job Posts</th>
                        <th class="text-end">
                            Actions
                        </th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($skills as $skill)

                        <tr>

                            {{-- SKILL NAME --}}
                            <td>

                                <form
                                    id="update-skill-{{ $skill->id }}"
                                    method="POST"
                                    action="{{ route(
                                        'admin.skills.update',
                                        $skill
                                    ) }}"
                                >
                                    @csrf
                                    @method('PATCH')
                                </form>


                                <input
                                    form="update-skill-{{ $skill->id }}"
                                    name="name"
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ $skill->name }}"
                                    maxlength="255"
                                    required
                                >

                            </td>



                            {{-- CATEGORY --}}
                            <td>

                                <input
                                    form="update-skill-{{ $skill->id }}"
                                    name="category"
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ $skill->category }}"
                                    maxlength="255"
                                    placeholder="No category"
                                    list="skill-category-options"
                                >

                            </td>



                            {{-- USERS COUNT --}}
                            <td>

                                <span
                                    class="badge text-bg-light
                                           border text-dark"
                                >
                                    {{ $skill->users_count }}

                                    {{ Str::plural(
                                        'person',
                                        $skill->users_count
                                    ) }}
                                </span>

                            </td>



                            {{-- JOB POSTS COUNT --}}
                            <td>

                                <span
                                    class="badge text-bg-light
                                           border text-dark"
                                >
                                    {{ $skill->job_posts_count }}

                                    {{ Str::plural(
                                        'job',
                                        $skill->job_posts_count
                                    ) }}
                                </span>

                            </td>



                            {{-- ACTIONS --}}
                            <td class="text-end">

                                <div
                                    class="d-flex justify-content-end
                                           align-items-center gap-2"
                                >

                                    <button
                                        form="update-skill-{{ $skill->id }}"
                                        type="submit"
                                        class="btn
                                               btn-outline-primary
                                               btn-sm"
                                    >
                                        Save
                                    </button>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.skills.destroy',
                                            $skill
                                        ) }}"
                                        class="m-0"
                                        onsubmit="return confirm(
                                            'Delete this skill? It will also be removed from user profiles and job posts.'
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



        {{-- =====================================================
             PAGINATION
             ===================================================== --}}
        @if ($skills->hasPages())

            <div
                class="d-flex flex-column flex-md-row
                       justify-content-between
                       align-items-md-center gap-3 mt-4"
            >

                <div class="small text-secondary">
                    Page {{ $skills->currentPage() }}
                    of {{ $skills->lastPage() }}
                </div>


                <div class="d-flex gap-2">

                    @if ($skills->onFirstPage())

                        <button
                            type="button"
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                            disabled
                        >
                            Previous
                        </button>

                    @else

                        <a
                            href="{{ $skills->previousPageUrl() }}"
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                        >
                            Previous
                        </a>

                    @endif


                    @if ($skills->hasMorePages())

                        <a
                            href="{{ $skills->nextPageUrl() }}"
                            class="btn btn-primary btn-sm"
                        >
                            Next
                        </a>

                    @else

                        <button
                            type="button"
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