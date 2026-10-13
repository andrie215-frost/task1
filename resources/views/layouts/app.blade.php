<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SkillMatch')
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])


    <link
        rel="stylesheet"
        href="{{ asset('css/auth.css') }}"
    >


    @stack('styles')

</head>


<body>


@auth


    {{-- =====================================================
         ADMIN
         LEFT SIDEBAR
         ===================================================== --}}
    @if (auth()->user()->role === 'admin')


        <div class="app-shell">


            <aside
                class="sidebar"
                id="sidebar"
            >

                {{-- BRAND --}}
                <a
                    class="sidebar-brand"
                    href="{{ route('admin.dashboard') }}"
                >

                    <span class="brand-icon">
                        SM
                    </span>

                    <span>
                        SkillMatch
                    </span>

                </a>


                {{-- ADMIN INFO --}}
                <div class="sidebar-user">

                    <div
                        class="sidebar-avatar"
                        style="overflow: hidden;"
                    >

                        @if (auth()->user()->profile_image)

                            <img
                                src="{{ asset(
                                    'storage/' .
                                    auth()->user()->profile_image
                                ) }}"
                                alt="{{ auth()->user()->name }}"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                    display: block;
                                "
                            >

                        @else

                            {{ strtoupper(
                                substr(
                                    auth()->user()->name,
                                    0,
                                    1
                                )
                            ) }}

                        @endif

                    </div>


                    <div class="sidebar-user-info">

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            Administrator
                        </span>

                    </div>

                </div>


                <div class="sidebar-label">
                    Main Menu
                </div>


                <nav class="sidebar-menu">


                    {{-- ADMIN DASHBOARD --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs('admin.dashboard')
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route('admin.dashboard') }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M3 11 12 4l9 7"/>
                                <path d="M5 10v10h14V10"/>
                                <path d="M9 20v-6h6v6"/>
                            </svg>

                        </span>

                        <span>
                            Admin Dashboard
                        </span>

                    </a>


                    {{-- USER MANAGEMENT --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs('admin.users.*')
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route('admin.users.index') }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="9" cy="8" r="4"/>
                                <path d="M2 21a7 7 0 0 1 14 0"/>
                                <path d="M17 8h5"/>
                                <path d="M19.5 5.5v5"/>
                            </svg>

                        </span>

                        <span>
                            User Management
                        </span>

                    </a>


                    {{-- JOB POST MANAGEMENT --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs('admin.job-posts.*')
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route('admin.job-posts.index') }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="16"
                                    rx="2"
                                />
                                <path d="M8 3v4"/>
                                <path d="M16 3v4"/>
                                <path d="M7 11h10"/>
                                <path d="M7 15h6"/>
                            </svg>

                        </span>

                        <span>
                            Job Post Management
                        </span>

                    </a>


                    {{-- SKILLS MANAGEMENT --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs('admin.skills.*')
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route('admin.skills.index') }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 2a5 5 0 0 0-5 5c0 2.3 1.5 4.2 3.5 4.8V15h3v-3.2A5 5 0 0 0 12 2Z"/>
                                <path d="M9.5 19h5"/>
                                <path d="M10.5 22h3"/>
                            </svg>

                        </span>

                        <span>
                            Skills Management
                        </span>

                    </a>


                    {{-- FINDING FORM OPTIONS --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs(
                                'admin.finding-options.*'
                            )
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route(
                            'admin.finding-options.index'
                        ) }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M4 6h16"/>
                                <path d="M4 12h16"/>
                                <path d="M4 18h16"/>
                                <circle cx="8" cy="6" r="2"/>
                                <circle cx="16" cy="12" r="2"/>
                                <circle cx="10" cy="18" r="2"/>
                            </svg>

                        </span>

                        <span>
                            Finding Form Options
                        </span>

                    </a>


                    {{-- ACCOUNT --}}
                    <a
                        class="sidebar-link {{
                            request()->routeIs('account.*')
                                ? 'active'
                                : ''
                        }}"
                        href="{{ route('account.edit') }}"
                    >

                        <span class="sidebar-link-icon">

                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                                <path
                                    d="
                                        M19.4 15
                                        a1.7 1.7 0 0 0 .34 1.88
                                        l.06.06
                                        -2.12 2.12
                                        -.06-.06
                                        a1.7 1.7 0 0 0-1.88-.34
                                        1.7 1.7 0 0 0-1.03 1.56
                                        v.08
                                        h-3
                                        v-.08
                                        a1.7 1.7 0 0 0-1.03-1.56
                                        1.7 1.7 0 0 0-1.88.34
                                        l-.06.06
                                        -2.12-2.12
                                        .06-.06
                                        A1.7 1.7 0 0 0 7 15
                                        a1.7 1.7 0 0 0-1.56-1.03
                                        H5.3
                                        v-3
                                        h.14
                                        A1.7 1.7 0 0 0 7 9.94
                                        a1.7 1.7 0 0 0-.34-1.88
                                        L6.6 8
                                        l2.12-2.12
                                        .06.06
                                        A1.7 1.7 0 0 0 10.66 6.3
                                        a1.7 1.7 0 0 0 1.03-1.56
                                        V4.7
                                        h3
                                        v.04
                                        a1.7 1.7 0 0 0 1.03 1.56
                                        1.7 1.7 0 0 0 1.88-.34
                                        l.06-.06
                                        L19.8 8
                                        l-.06.06
                                        a1.7 1.7 0 0 0-.34 1.88
                                        1.7 1.7 0 0 0 1.56 1.03
                                        H21
                                        v3
                                        h-.04
                                        A1.7 1.7 0 0 0 19.4 15Z
                                    "
                                />

                            </svg>

                        </span>

                        <span>
                            Account
                        </span>

                    </a>


                    {{-- LOGOUT --}}
                    <div class="sidebar-bottom">

                        <form
                            class="logout-form"
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                class="sidebar-link sidebar-logout"
                                type="submit"
                            >

                                <span class="sidebar-link-icon">

                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M10 17l5-5-5-5"/>
                                        <path d="M15 12H3"/>
                                        <path
                                            d="
                                                M14 4h5
                                                a2 2 0 0 1 2 2
                                                v12
                                                a2 2 0 0 1-2 2
                                                h-5
                                            "
                                        />
                                    </svg>

                                </span>

                                <span>
                                    Logout
                                </span>

                            </button>

                        </form>

                    </div>

                </nav>

            </aside>



            {{-- MOBILE OVERLAY --}}
            <div
                class="sidebar-overlay"
                id="sidebar-overlay"
            ></div>



            {{-- ADMIN PAGE --}}
            <div class="page-area">


                <header class="mobile-header">

                    <button
                        class="mobile-menu-button"
                        id="mobile-menu-button"
                        type="button"
                        aria-label="Open sidebar"
                    >
                        ☰
                    </button>


                    <a
                        class="mobile-brand"
                        href="{{ route('admin.dashboard') }}"
                    >
                        SkillMatch
                    </a>

                </header>


                <main class="container-fluid px-3 px-md-4 py-4">


                    {{-- SUCCESS --}}
                    @if (session('success'))

                        <div
                            class="alert alert-success
                                   alert-dismissible fade show"
                            role="alert"
                        >

                            {{ session('success') }}


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    @endif



                    {{-- ERRORS --}}
                    @if ($errors->any())

                        <div
                            class="alert alert-danger
                                   alert-dismissible fade show"
                            role="alert"
                        >

                            <strong>
                                Please fix the following errors:
                            </strong>


                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    @endif


                    @yield('content')

                </main>

            </div>

        </div>



    {{-- =====================================================
         COMPANY + SKILLED PERSON
         TOP NAVIGATION
         ===================================================== --}}
    @else


        <div class="user-app-shell">


            <nav class="navbar navbar-expand-lg sm-topnav">

                <div class="container-fluid px-3 px-xl-4">


                    {{-- BRAND --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="sm-topnav-brand"
                    >

                        <span class="sm-topnav-logo">
                            SM
                        </span>

                        <span class="sm-topnav-brand-name">
                            Skill<span>Match</span>
                        </span>

                    </a>



                    {{-- MOBILE TOGGLE --}}
                    <button
                        class="navbar-toggler sm-topnav-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#skillmatchNavbar"
                        aria-controls="skillmatchNavbar"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>



                    <div
                        class="collapse navbar-collapse"
                        id="skillmatchNavbar"
                    >


                        {{-- CENTER NAV --}}
                        <div class="sm-topnav-center">

                            <ul class="navbar-nav sm-topnav-links">


                                {{-- DASHBOARD --}}
                                <li class="nav-item">

                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="sm-nav-link {{
                                            request()->routeIs('dashboard')
                                                ? 'active'
                                                : ''
                                        }}"
                                    >

                                        <span class="sm-nav-icon">

                                            <svg
                                                width="18"
                                                height="18"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <rect
                                                    x="3"
                                                    y="3"
                                                    width="7"
                                                    height="7"
                                                    rx="1"
                                                />
                                                <rect
                                                    x="14"
                                                    y="3"
                                                    width="7"
                                                    height="7"
                                                    rx="1"
                                                />
                                                <rect
                                                    x="3"
                                                    y="14"
                                                    width="7"
                                                    height="7"
                                                    rx="1"
                                                />
                                                <rect
                                                    x="14"
                                                    y="14"
                                                    width="7"
                                                    height="7"
                                                    rx="1"
                                                />
                                            </svg>

                                        </span>

                                        Dashboard

                                    </a>

                                </li>



                                {{-- COMPANY --}}
                                @if (
                                    auth()->user()->role === 'company'
                                )


                                    {{-- JOB POSTS --}}
                                    <li class="nav-item">

                                        <a
                                            href="{{ route(
                                                'job-posts.index'
                                            ) }}"
                                            class="sm-nav-link {{
                                                request()->routeIs(
                                                    'job-posts.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >

                                            <span class="sm-nav-icon">
                                                ▤
                                            </span>

                                            Job Posts

                                        </a>

                                    </li>


                                    {{-- FIND PEOPLE --}}
                                    <li class="nav-item">

                                        <a
                                            href="{{ route(
                                                'matches.index'
                                            ) }}"
                                            class="sm-nav-link {{
                                                request()->routeIs(
                                                    'matches.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >

                                            <span class="sm-nav-icon">
                                                ⌕
                                            </span>

                                            Find People

                                        </a>

                                    </li>



                                {{-- SKILLED PERSON --}}
                                @else


                                    {{-- JOB FEED --}}
                                    <li class="nav-item">

                                        <a
                                            href="{{ route(
                                                'jobs.index'
                                            ) }}"
                                            class="sm-nav-link {{
                                                request()->routeIs(
                                                    'jobs.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >

                                            <span class="sm-nav-icon">
                                                ▤
                                            </span>

                                            Job Feed

                                        </a>

                                    </li>


                                    {{-- FIND JOBS --}}
                                    <li class="nav-item">

                                        <a
                                            href="{{ route(
                                                'matches.index'
                                            ) }}"
                                            class="sm-nav-link {{
                                                request()->routeIs(
                                                    'matches.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >

                                            <span class="sm-nav-icon">
                                                ⌕
                                            </span>

                                            Find Jobs

                                        </a>

                                    </li>


                                @endif



                                {{-- PROFILE --}}
                                <li class="nav-item">

                                    <a
                                        href="{{ route(
                                            'profile.show'
                                        ) }}"
                                        class="sm-nav-link {{
                                            request()->routeIs(
                                                'profile.*'
                                            )
                                                ? 'active'
                                                : ''
                                        }}"
                                    >

                                        <span class="sm-nav-icon">
                                            ◉
                                        </span>

                                        Profile

                                    </a>

                                </li>



                                {{-- ACCOUNT --}}
                                <li class="nav-item">

                                    <a
                                        href="{{ route(
                                            'account.edit'
                                        ) }}"
                                        class="sm-nav-link {{
                                            request()->routeIs(
                                                'account.*'
                                            )
                                                ? 'active'
                                                : ''
                                        }}"
                                    >

                                        <span class="sm-nav-icon">
                                            ⚙
                                        </span>

                                        Account

                                    </a>

                                </li>

                            </ul>

                        </div>



                        {{-- USER AREA --}}
                        <div class="sm-topnav-user-area">


                            <div class="sm-topnav-user">


                                <div
                                    class="sm-topnav-avatar"
                                    style="overflow: hidden;"
                                >

                                    @if (
                                        auth()->user()->profile_image
                                    )

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                auth()->user()
                                                    ->profile_image
                                            ) }}"
                                            alt="{{ auth()->user()->name }}"
                                            style="
                                                width: 100%;
                                                height: 100%;
                                                object-fit: cover;
                                                display: block;
                                            "
                                        >

                                    @else

                                        {{ strtoupper(
                                            substr(
                                                auth()->user()->name,
                                                0,
                                                1
                                            )
                                        ) }}

                                    @endif

                                </div>


                                <div class="sm-topnav-user-info">

                                    <strong>
                                        {{ auth()->user()->name }}
                                    </strong>

                                    <span>

                                        {{
                                            auth()->user()->role
                                                === 'company'
                                                    ? 'Company Account'
                                                    : 'Skilled Person'
                                        }}

                                    </span>

                                </div>

                            </div>



                            {{-- LOGOUT --}}
                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                                class="m-0"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="sm-topnav-logout"
                                >
                                    Logout
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </nav>



            {{-- USER CONTENT --}}
            <main class="container-fluid px-3 px-md-4 py-4">


                {{-- SUCCESS --}}
                @if (session('success'))

                    <div
                        class="alert alert-success
                               alert-dismissible fade show"
                        role="alert"
                    >

                        {{ session('success') }}


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>

                    </div>

                @endif



                {{-- ERRORS --}}
                @if ($errors->any())

                    <div
                        class="alert alert-danger
                               alert-dismissible fade show"
                        role="alert"
                    >

                        <strong>
                            Please fix the following errors:
                        </strong>


                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>

                    </div>

                @endif


                @yield('content')

            </main>

        </div>


    @endif



{{-- =========================================================
     GUEST
     ========================================================= --}}
@else


    @hasSection('guest-fullscreen')


        @yield('content')


    @else


        <header class="guest-nav">

            <div class="guest-nav-container">


                <a
                    class="guest-brand"
                    href="{{ route('home') }}"
                >
                    SkillMatch
                </a>


                <div class="guest-links">

                    <a href="{{ route('login') }}">
                        Login
                    </a>


                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ route('register') }}"
                    >
                        Register
                    </a>

                </div>

            </div>

        </header>


        <main class="container py-4">


            {{-- SUCCESS --}}
            @if (session('success'))

                <div
                    class="alert alert-success
                           alert-dismissible fade show"
                    role="alert"
                >

                    {{ session('success') }}


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            @endif



            {{-- ERRORS --}}
            @if ($errors->any())

                <div
                    class="alert alert-danger
                           alert-dismissible fade show"
                    role="alert"
                >

                    <strong>
                        Please fix the following errors:
                    </strong>


                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            @endif


            @yield('content')

        </main>


    @endif


@endauth



@stack('scripts')



{{-- =========================================================
     ADMIN SIDEBAR JAVASCRIPT
     ========================================================= --}}
@auth

    @if (auth()->user()->role === 'admin')

        <script>

            const sidebar =
                document.getElementById('sidebar');

            const overlay =
                document.getElementById('sidebar-overlay');

            const menuButton =
                document.getElementById('mobile-menu-button');


            function openSidebar() {

                sidebar.classList.add('open');

                overlay.classList.add('show');

                document.body.style.overflow = 'hidden';
            }


            function closeSidebar() {

                sidebar.classList.remove('open');

                overlay.classList.remove('show');

                document.body.style.overflow = '';
            }


            menuButton?.addEventListener(
                'click',
                openSidebar
            );


            overlay?.addEventListener(
                'click',
                closeSidebar
            );


            document.addEventListener(
                'keydown',
                function (event) {

                    if (event.key === 'Escape') {
                        closeSidebar();
                    }

                }
            );


            window.addEventListener(
                'resize',
                function () {

                    if (window.innerWidth > 900) {
                        closeSidebar();
                    }

                }
            );

        </script>

    @endif

@endauth


</body>

</html>