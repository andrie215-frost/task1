@extends('layouts.app')

@section('title', 'Finding Form Options - SkillMatch')

@section('content')


{{-- =========================================================
     HEADER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div>

       

        <h1 class="h3 mb-2">
            Finding Form Options
        </h1>

        <p class="text-secondary mb-0">
            Manage the choices used in the
            Find Jobs and Find People forms.
        </p>

    </div>

</div>







{{-- =========================================================
     ADD OPTION
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div class="mb-4">

        <h2 class="h5 mb-1">
            Add New Option
        </h2>

        <p class="text-secondary mb-0">
            Add a new position, location, or job type.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.finding-options.store') }}"
    >
        @csrf


        <div class="row g-3 align-items-end">


            {{-- TYPE --}}
            <div class="col-12 col-md-4">

                <label
                    for="type"
                    class="form-label fw-semibold"
                >
                    Option Type
                </label>

<select
    id="type"
    name="type"
    class="form-select
           @error('type') is-invalid @enderror"
    required
>

    <option
        value=""
        disabled
        @selected(old('type') === null)
    >
        Select option type
    </option>

    <option
        value="position"
        @selected(old('type') === 'position')
    >
        Position
    </option>

    <option
        value="location"
        @selected(old('type') === 'location')
    >
        Location
    </option>

    <option
        value="job_type"
        @selected(old('type') === 'job_type')
    >
        Job Type
    </option>

</select>


                @error('type')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- NAME --}}
            <div class="col-12 col-md-6">

                <label
                    for="name"
                    class="form-label fw-semibold"
                >
                    Option Name
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
                    placeholder="Example: Manager"
                    required
                >


                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- BUTTON --}}
            <div class="col-12 col-md-2">

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Add Option
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>



{{-- =========================================================
     FILTER
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div
        class="d-flex flex-column flex-lg-row
               justify-content-between
               align-items-lg-center gap-3"
    >

        <div>

            <h2 class="h5 mb-1">
                Manage Options
            </h2>

            <p class="text-secondary mb-0">
                Edit, activate, deactivate, or remove options.
            </p>

        </div>


        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route(
                    'admin.finding-options.index'
                ) }}"
                class="btn btn-sm
                       {{
                           $selectedType === ''
                               ? 'btn-primary'
                               : 'btn-outline-secondary'
                       }}"
            >
                All
            </a>


            <a
                href="{{ route(
                    'admin.finding-options.index',
                    ['type' => 'position']
                ) }}"
                class="btn btn-sm
                       {{
                           $selectedType === 'position'
                               ? 'btn-primary'
                               : 'btn-outline-secondary'
                       }}"
            >
                Positions
            </a>


            <a
                href="{{ route(
                    'admin.finding-options.index',
                    ['type' => 'location']
                ) }}"
                class="btn btn-sm
                       {{
                           $selectedType === 'location'
                               ? 'btn-primary'
                               : 'btn-outline-secondary'
                       }}"
            >
                Locations
            </a>


            <a
                href="{{ route(
                    'admin.finding-options.index',
                    ['type' => 'job_type']
                ) }}"
                class="btn btn-sm
                       {{
                           $selectedType === 'job_type'
                               ? 'btn-primary'
                               : 'btn-outline-secondary'
                       }}"
            >
                Job Types
            </a>

        </div>

    </div>

</div>



{{-- =========================================================
     OPTIONS
     ========================================================= --}}
<div class="bg-white border rounded-4 shadow-sm p-4">


    @if ($options->isEmpty())

        <div class="text-center py-5">

            <div class="mb-3">

                <svg
                    width="42"
                    height="42"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    class="text-secondary"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8v8"/>
                    <path d="M8 12h8"/>
                </svg>

            </div>

            <h3 class="h5 mb-2">
                No options yet
            </h3>

            <p class="text-secondary mb-0">
                Add your first finding form option above.
            </p>

        </div>


    @else

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th style="width: 180px;">
                            Type
                        </th>

                        <th>
                            Name
                        </th>

                        <th style="width: 130px;">
                            Status
                        </th>

                        <th
                            class="text-end"
                            style="width: 330px;"
                        >
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($options as $option)

                        <tr>


                            {{-- TYPE --}}
                            <td>

                                @if ($option->type === 'position')

                                    <span
                                        class="badge
                                               text-bg-primary"
                                    >
                                        Position
                                    </span>


                                @elseif ($option->type === 'location')

                                    <span
                                        class="badge
                                               text-bg-info"
                                    >
                                        Location
                                    </span>


                                @else

                                    <span
                                        class="badge
                                               text-bg-secondary"
                                    >
                                        Job Type
                                    </span>

                                @endif

                            </td>



                            {{-- NAME --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $option->name }}
                                </div>

                            </td>



                            {{-- STATUS --}}
                            <td>

                                @if ($option->is_active)

                                    <span
                                        class="badge
                                               text-bg-success"
                                    >
                                        Active
                                    </span>

                                @else

                                    <span
                                        class="badge
                                               text-bg-light
                                               border
                                               text-secondary"
                                    >
                                        Inactive
                                    </span>

                                @endif

                            </td>



                            {{-- ACTIONS --}}
                            <td class="text-end">

                                <div
                                    class="d-flex
                                           justify-content-end
                                           flex-wrap gap-2"
                                >


                                    {{-- EDIT BUTTON --}}
                                    <button
                                        type="button"
                                        class="btn
                                               btn-outline-secondary
                                               btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editOption{{ $option->id }}"
                                    >
                                        Edit
                                    </button>



                                    {{-- DELETE --}}
                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.finding-options.destroy',
                                            $option
                                        ) }}"
                                        class="m-0"
                                        onsubmit="return confirm(
                                            'Delete this option permanently?'
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



                        {{-- =================================================
                             EDIT MODAL
                             ================================================= --}}
                        <div
                            class="modal fade"
                            id="editOption{{ $option->id }}"
                            tabindex="-1"
                            aria-hidden="true"
                        >

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.finding-options.update',
                                            $option
                                        ) }}"
                                    >
                                        @csrf
                                        @method('PATCH')


                                        <div class="modal-header">

                                            <h2 class="modal-title fs-5">
                                                Edit Finding Option
                                            </h2>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            ></button>

                                        </div>


                                        <div class="modal-body">


                                            {{-- TYPE --}}
                                            <div class="mb-3">

                                                <label
                                                    for="edit-type-{{ $option->id }}"
                                                    class="form-label fw-semibold"
                                                >
                                                    Option Type
                                                </label>

                                                <select
                                                    id="edit-type-{{ $option->id }}"
                                                    name="type"
                                                    class="form-select"
                                                    required
                                                >

                                                    <option
                                                        value="position"
                                                        @selected(
                                                            $option->type
                                                            === 'position'
                                                        )
                                                    >
                                                        Position
                                                    </option>


                                                    <option
                                                        value="location"
                                                        @selected(
                                                            $option->type
                                                            === 'location'
                                                        )
                                                    >
                                                        Location
                                                    </option>


                                                    <option
                                                        value="job_type"
                                                        @selected(
                                                            $option->type
                                                            === 'job_type'
                                                        )
                                                    >
                                                        Job Type
                                                    </option>

                                                </select>

                                            </div>



                                            {{-- NAME --}}
                                            <div class="mb-3">

                                                <label
                                                    for="edit-name-{{ $option->id }}"
                                                    class="form-label fw-semibold"
                                                >
                                                    Option Name
                                                </label>

                                                <input
                                                    id="edit-name-{{ $option->id }}"
                                                    name="name"
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ $option->name }}"
                                                    required
                                                >

                                            </div>



                                            {{-- ACTIVE --}}
                                            <div>

                                                <input
                                                    type="hidden"
                                                    name="is_active"
                                                    value="0"
                                                >

                                                <div class="form-check form-switch">

                                                    <input
                                                        id="edit-active-{{ $option->id }}"
                                                        name="is_active"
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        value="1"
                                                        @checked(
                                                            $option->is_active
                                                        )
                                                    >

                                                    <label
                                                        for="edit-active-{{ $option->id }}"
                                                        class="form-check-label"
                                                    >
                                                        Active
                                                    </label>

                                                </div>


                                                <div
                                                    class="form-text"
                                                >
                                                    Inactive options will
                                                    not appear in finding
                                                    forms.
                                                </div>

                                            </div>

                                        </div>


                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn
                                                       btn-outline-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Cancel
                                            </button>


                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                Save Changes
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>

@endsection