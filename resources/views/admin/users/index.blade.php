@extends('layouts.app')

@section('title', 'Manage Users - SkillMatch')

@section('content')

{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <div>

        <h1 class="h3 mb-2">
            User Management
        </h1>

        <p class="text-secondary mb-0">
            Search, inspect, and manage company
            and skilled-person accounts.
        </p>

    </div>

</div>


{{-- FILTERS --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <form
        method="GET"
        action="{{ route('admin.users.index') }}"
    >

        <div class="row g-3 align-items-end">

            {{-- SEARCH --}}
            <div class="col-12 col-lg-7">

                <label
                    for="search"
                    class="form-label fw-semibold"
                >
                    Search Users
                </label>

                <input
                    id="search"
                    name="search"
                    type="search"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Name, email, company, or professional title"
                >

            </div>


            {{-- ROLE --}}
            <div class="col-12 col-md-6 col-lg-3">

                <label
                    for="role"
                    class="form-label fw-semibold"
                >
                    Account Role
                </label>

                <select
                    id="role"
                    name="role"
                    class="form-select"
                >

                    <option value="">
                        All account roles
                    </option>

                    <option
                        value="skilled_person"
                        @selected(
                            $selectedRole === 'skilled_person'
                        )
                    >
                        Skilled Person
                    </option>

                    <option
                        value="company"
                        @selected(
                            $selectedRole === 'company'
                        )
                    >
                        Company
                    </option>

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


        @if ($search || $selectedRole)

            <div class="mt-3">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Clear Filters
                </a>

            </div>

        @endif

    </form>

</div>


{{-- USERS --}}
<div class="bg-white border rounded-4 shadow-sm p-4">

    <div class="mb-4">

        <h2 class="h4 mb-1">
            Registered Users
        </h2>

        <p class="text-secondary mb-0">
            Showing
            {{ $users->firstItem() ?? 0 }}
            to
            {{ $users->lastItem() ?? 0 }}
            of
            {{ $users->total() }}
            users.
        </p>

    </div>


    @if ($users->isEmpty())

        <div class="text-center py-5">

            <h3 class="h5 mb-2">
                No users found
            </h3>

            <p class="text-secondary mb-3">
                Try changing or clearing the search filters.
            </p>

            <a
                href="{{ route('admin.users.index') }}"
                class="btn btn-outline-secondary"
            >
                Clear Filters
            </a>

        </div>

    @else

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Profile Information</th>
                        <th>Registered</th>

                        <th class="text-end">
                            Actions
                        </th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($users as $managedUser)

                        <tr>

                            {{-- USER --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    {{-- PROFILE IMAGE --}}
                                    @if ($managedUser->profile_image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $managedUser->profile_image
                                            ) }}"
                                            alt="{{ $managedUser->name }}"
                                            class="rounded-circle border flex-shrink-0"
                                            style="
                                                width: 42px;
                                                height: 42px;
                                                object-fit: cover;
                                            "
                                        >

                                    @else

                                        <div
                                            class="rounded-circle
                                                   bg-primary text-white
                                                   d-flex align-items-center
                                                   justify-content-center
                                                   flex-shrink-0"
                                            style="
                                                width: 42px;
                                                height: 42px;
                                            "
                                        >
                                            {{ strtoupper(
                                                substr(
                                                    $managedUser->name,
                                                    0,
                                                    1
                                                )
                                            ) }}
                                        </div>

                                    @endif


                                    <div>

                                        <div class="fw-semibold">
                                            {{ $managedUser->name }}
                                        </div>

                                        <div class="small text-secondary">
                                            {{ $managedUser->email }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- ROLE --}}
                            <td>

                                @if ($managedUser->role === 'company')

                                    <span class="badge text-bg-primary">
                                        Company
                                    </span>

                                @else

                                    <span class="badge text-bg-success">
                                        Skilled Person
                                    </span>

                                @endif

                            </td>


                            {{-- PROFILE --}}
                            <td>

                                @if (
                                    $managedUser->role === 'company'
                                    && $managedUser->companyProfile
                                )

                                    <div class="fw-semibold">
                                        {{ $managedUser
                                            ->companyProfile
                                            ->company_name }}
                                    </div>

                                    <div class="small text-secondary">

                                        {{ $managedUser
                                            ->companyProfile
                                            ->location
                                            ?: 'Location not specified' }}

                                    </div>


                                @elseif (
                                    $managedUser->role === 'skilled_person'
                                    && $managedUser->skilledProfile
                                )

                                    <div class="fw-semibold">
                                        {{ $managedUser
                                            ->skilledProfile
                                            ->professional_title }}
                                    </div>

                                    <div class="small text-secondary">

                                        {{ $managedUser
                                            ->skilledProfile
                                            ->location }}

                                    </div>


                                @else

                                    <span class="text-secondary">
                                        Profile incomplete
                                    </span>

                                @endif

                            </td>


                            {{-- REGISTERED --}}
                            <td>

                                {{ $managedUser->created_at
                                    ->format('M d, Y') }}

                            </td>


                            {{-- ACTIONS --}}
                            <td class="text-end">

                                <div
                                    class="d-flex justify-content-end
                                           align-items-center gap-2"
                                >

                                    <a
                                        href="{{ route(
                                            'admin.users.show',
                                            $managedUser
                                        ) }}"
                                        class="btn
                                               btn-outline-secondary
                                               btn-sm"
                                    >
                                        View
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.users.destroy',
                                            $managedUser
                                        ) }}"
                                        class="m-0"
                                        onsubmit="return confirm(
                                            'Delete this user and all related data?'
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


        {{-- PAGINATION --}}
        @if ($users->hasPages())

            <div
                class="d-flex flex-column flex-md-row
                       justify-content-between
                       align-items-md-center gap-3 mt-4"
            >

                <div class="text-secondary small">

                    Page {{ $users->currentPage() }}
                    of {{ $users->lastPage() }}

                </div>


                <div class="d-flex gap-2">

                    @if ($users->onFirstPage())

                        <button
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                            disabled
                        >
                            Previous
                        </button>

                    @else

                        <a
                            href="{{ $users->previousPageUrl() }}"
                            class="btn
                                   btn-outline-secondary
                                   btn-sm"
                        >
                            Previous
                        </a>

                    @endif


                    @if ($users->hasMorePages())

                        <a
                            href="{{ $users->nextPageUrl() }}"
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

</div>

@endsection