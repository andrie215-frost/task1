@extends('layouts.app')

@section('title', 'Register - SkillMatch')
@section('guest-fullscreen', 'true')

@section('content')
<div class="auth-page">
    <div class="auth-shell">

        <section class="auth-brand-panel">
            <a href="{{ route('home') }}" class="auth-brand">
                <span class="auth-brand-mark">SM</span>
                <span>Skill<span>Match</span></span>
            </a>

            <div class="auth-brand-content">
                <span class="auth-eyebrow">Join SkillMatch</span>
                <h1>Turn your skills into opportunities.</h1>

                <p>
                    Create an account and start connecting
                    with the right people and companies.
                </p>

                <div class="auth-benefits">
                    <div class="auth-benefit"><span>✓</span>Create your professional profile</div>
                    <div class="auth-benefit"><span>✓</span>Discover relevant matches</div>
                    <div class="auth-benefit"><span>✓</span>Connect directly with opportunities</div>
                </div>
            </div>

            <p class="auth-brand-footer">
                Simple matching. Better opportunities.
            </p>
        </section>

        <section class="auth-form-panel">
            <div class="auth-form-wrapper auth-register-wrapper">

                <header class="auth-heading">
                    <h2>Create your account</h2>
                    <p>It only takes a minute to get started.</p>
                </header>

                @if ($errors->any())
                    <div class="auth-alert auth-alert-error">
                        <strong>Please check your information.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="auth-field">
                        <label for="name">Full name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Enter Your Name"
                            autocomplete="name"
                            required
                            autofocus
                        >
                    </div>

                    <div class="auth-field">
                        <label for="email">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="Enter Your Email"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="auth-field">
                        <label>Account type</label>

                        <div class="auth-role-grid">
                            <label class="auth-role-card">
                                <input
                                    type="radio"
                                    name="role"
                                    value="skilled_person"
                                    @checked(
                                        old('role', 'skilled_person')
                                        === 'skilled_person'
                                    )
                                >
                                <span class="auth-role-content">
                                    <strong>Skilled Person</strong>
                                    <small>I'm looking for opportunities.</small>
                                </span>
                            </label>

                            <label class="auth-role-card">
                                <input
                                    type="radio"
                                    name="role"
                                    value="company"
                                    @checked(old('role') === 'company')
                                >
                                <span class="auth-role-content">
                                    <strong>Company</strong>
                                    <small>I'm looking for skilled people.</small>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="auth-password-grid">
                        <div class="auth-field">
                            <label for="password">Password</label>

                            <div class="auth-password">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Password"
                                    autocomplete="new-password"
                                    required
                                >
                                <button
                                    type="button"
                                    class="auth-password-toggle"
                                    data-password-toggle="password"
                                >
                                    Show
                                </button>
                            </div>
                        </div>

                        <div class="auth-field">
                            <label for="password_confirmation">
                                Confirm password
                            </label>

                            <div class="auth-password">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Confirm password"
                                    autocomplete="new-password"
                                    required
                                >
                                <button
                                    type="button"
                                    class="auth-password-toggle"
                                    data-password-toggle="password_confirmation"
                                >
                                    Show
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="auth-submit" type="submit">
                        Create account
                    </button>
                </form>

                <p class="auth-switch">
                    Already have an account?
                    <a href="{{ route('login') }}">Log in</a>
                </p>

            </div>
        </section>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document
        .querySelectorAll('[data-password-toggle]')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(
                    button.dataset.passwordToggle
                );

                if (!input) {
                    return;
                }

                const hidden = input.type === 'password';

                input.type = hidden ? 'text' : 'password';
                button.textContent = hidden ? 'Hide' : 'Show';
            });
        });
</script>
@endpush
