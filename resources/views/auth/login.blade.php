@extends('layouts.app')

@section('title', 'Login - SkillMatch')
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
                <span class="auth-eyebrow">Welcome back</span>
                <h1>Find opportunities that match your skills.</h1>

                <p>
                    SkillMatch helps skilled people connect with
                    companies looking for the right talent.
                </p>

                <div class="auth-benefits">
                    <div class="auth-benefit"><span>✓</span>Find relevant opportunities</div>
                    <div class="auth-benefit"><span>✓</span>Connect with companies</div>
                    <div class="auth-benefit"><span>✓</span>Build your professional profile</div>
                </div>
            </div>

            <p class="auth-brand-footer">
                Your skills deserve the right opportunity.
            </p>
        </section>

        <section class="auth-form-panel">
            <div class="auth-form-wrapper">

                <header class="auth-heading">
                    <h2>Log in</h2>
                    <p>Enter your details to access your account.</p>
                </header>

                @if (session('success'))
                    <div class="auth-alert auth-alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-alert auth-alert-error">
                        <strong>Unable to log in.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

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
                            autofocus
                        >
                    </div>

                    <div class="auth-field">
                        <div class="auth-label-row">
                            <label for="password">Password</label>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="auth-small-link"
                                >
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <div class="auth-password">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
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

                    <label class="auth-checkbox">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                        >
                        <span>Remember me</span>
                    </label>

                    <button class="auth-submit" type="submit">
                        Log in
                    </button>
                </form>

                <p class="auth-switch">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create one</a>
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
