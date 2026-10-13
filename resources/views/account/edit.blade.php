@extends('layouts.app')

@section('title', 'Account Settings - SkillMatch')

@section('content')


{{-- HEADER --}}
<div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

    <h1 class="h3 mb-2">
        Account Settings
    </h1>

    <p class="text-secondary mb-0">

        @if ($user->role === 'admin')
            Manage your profile picture, login email address,
            and password.
        @else
            Manage your login email address and password.
        @endif

    </p>

</div>



{{-- =========================================================
     ADMIN PROFILE PICTURE
     ========================================================= --}}
@if ($user->role === 'admin')

    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

        <div
            class="d-flex flex-column flex-md-row
                   align-items-md-center gap-4"
        >

            {{-- CURRENT IMAGE --}}
            <div class="flex-shrink-0">

                @if ($user->profile_image)

                    <img
                        src="{{ asset(
                            'storage/' . $user->profile_image
                        ) }}"
                        alt="{{ $user->name }}"
                        class="rounded-circle border"
                        style="
                            width: 96px;
                            height: 96px;
                            object-fit: cover;
                        "
                    >

                @else

                    <div
                        class="rounded-circle
                               bg-primary text-white
                               d-flex align-items-center
                               justify-content-center
                               fw-semibold"
                        style="
                            width: 96px;
                            height: 96px;
                            font-size: 1.8rem;
                        "
                    >
                        {{ strtoupper(
                            substr(
                                $user->name,
                                0,
                                1
                            )
                        ) }}
                    </div>

                @endif

            </div>


            {{-- UPLOAD FORM --}}
            <div class="flex-grow-1">

                <h2 class="h5 mb-2">
                    Profile Picture
                </h2>

                <p class="text-secondary mb-3">
                    Upload the picture shown on your administrator account.
                </p>


                <form
                    method="POST"
                    action="{{ route(
                        'account.profile-image.update'
                    ) }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PATCH')


                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-lg-8">

                            <label
                                for="profile_image"
                                class="form-label fw-semibold"
                            >
                                Choose Image
                            </label>

                            <input
                                id="profile_image"
                                name="profile_image"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control
                                       @error('profile_image')
                                           is-invalid
                                       @enderror"
                                required
                            >


                            @error('profile_image')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div class="form-text">
                                JPG, JPEG, PNG, or WEBP.
                                Maximum file size: 2 MB.
                            </div>

                        </div>


                        <div class="col-12 col-lg-4">

                            <div class="d-grid">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Update Picture
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endif



<div class="row g-4">


    {{-- =====================================================
         UPDATE EMAIL
         ===================================================== --}}
    <div class="col-12 col-lg-6">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="mb-4">

                <h2 class="h5 mb-2">
                    Email Address
                </h2>

                <p class="text-secondary mb-0">
                    Change the email address used to log in
                    to your SkillMatch account.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('account.email.update') }}"
            >
                @csrf
                @method('PATCH')


                {{-- EMAIL --}}
                <div class="mb-4">

                    <label
                        for="email"
                        class="form-label fw-semibold"
                    >
                        Email Address
                    </label>


                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control
                               @error('email')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'email',
                            $user->email
                        ) }}"
                        required
                    >


                    @error('email')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- CURRENT PASSWORD --}}
                <div class="mb-4">

                    <label
                        for="email_current_password"
                        class="form-label fw-semibold"
                    >
                        Current Password
                    </label>


                    <input
                        id="email_current_password"
                        name="email_current_password"
                        type="password"
                        class="form-control
                               @error('email_current_password')
                                   is-invalid
                               @enderror"
                        autocomplete="current-password"
                        required
                    >


                    @error('email_current_password')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Enter your current password to confirm
                        the email change.
                    </div>

                </div>



                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Update Email
                </button>

            </form>

        </div>

    </div>



    {{-- =====================================================
         CHANGE PASSWORD
         ===================================================== --}}
    <div class="col-12 col-lg-6">

        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">

            <div class="mb-4">

                <h2 class="h5 mb-2">
                    Change Password
                </h2>

                <p class="text-secondary mb-0">
                    Use a secure password for your account.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('account.password.update') }}"
            >
                @csrf
                @method('PATCH')


                {{-- CURRENT PASSWORD --}}
                <div class="mb-4">

                    <label
                        for="password_current_password"
                        class="form-label fw-semibold"
                    >
                        Current Password
                    </label>


                    <input
                        id="password_current_password"
                        name="password_current_password"
                        type="password"
                        class="form-control
                               @error('password_current_password')
                                   is-invalid
                               @enderror"
                        autocomplete="current-password"
                        required
                    >


                    @error('password_current_password')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- NEW PASSWORD --}}
                <div class="mb-4">

                    <label
                        for="password"
                        class="form-label fw-semibold"
                    >
                        New Password
                    </label>


                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control
                               @error('password')
                                   is-invalid
                               @enderror"
                        autocomplete="new-password"
                        required
                    >


                    @error('password')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Password must contain at least
                        8 characters.
                    </div>

                </div>



                {{-- CONFIRM PASSWORD --}}
                <div class="mb-4">

                    <label
                        for="password_confirmation"
                        class="form-label fw-semibold"
                    >
                        Confirm New Password
                    </label>


                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="form-control"
                        autocomplete="new-password"
                        required
                    >

                </div>



                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Change Password
                </button>

            </form>

        </div>

    </div>

</div>

@endsection