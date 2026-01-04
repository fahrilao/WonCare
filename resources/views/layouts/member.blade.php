<!doctype html>

<html lang="en" class=" layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-skin="default"
    data-bs-theme="light" data-assets-path="{{ asset('') }}" data-template="horizontal-menu-template-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ config('app.name') }} - @yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />

    <script src="{{ asset('assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
    @stack('vendor_styles')

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('assets/js/config.js') }}"></script>

    <style>
        body.member-onboarding {
            background: #f7faf9;
        }

        body.member-onboarding .content-wrapper {
            background: transparent;
        }

        body.member-onboarding .container-p-y {
            padding-top: 2.5rem !important;
            padding-bottom: 3rem !important;
        }

        body.member-onboarding .onboarding-shell {
            max-width: 820px;
            margin: 0 auto;
        }

        body.member-onboarding .onboarding-card {
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            background: #fff;
        }

        body.member-onboarding .onboarding-card .card-body {
            padding: 2.25rem !important;
        }

        body.member-onboarding .onboarding-step {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .4rem .85rem;
            border-radius: 999px;
            background: rgba(16, 185, 129, 0.10);
            color: #0f766e;
            font-weight: 600;
            font-size: .85rem;
        }

        body.member-onboarding .onboarding-progress {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: .5rem;
            margin: .75rem auto 0;
            max-width: 260px;
        }

        body.member-onboarding .onboarding-progress span {
            height: 8px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.08);
        }

        body.member-onboarding .onboarding-progress span.is-done {
            background: rgba(16, 185, 129, 0.35);
        }

        body.member-onboarding .onboarding-progress span.is-active {
            background: #10b981;
        }

        body.member-onboarding .onboarding-title {
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        body.member-onboarding .onboarding-subtitle {
            color: rgba(15, 23, 42, 0.62);
            font-size: 1rem;
        }

        body.member-onboarding .onboarding-tile {
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 16px;
            padding: 1.25rem;
            height: 100%;
        }

        body.member-onboarding .onboarding-tile .tile-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 185, 129, 0.12);
            color: #0f766e;
        }

        body.member-onboarding .onboarding-tile.tile-primary {
            background: rgba(16, 185, 129, 0.10);
        }

        body.member-onboarding .onboarding-tile.tile-success {
            background: rgba(20, 184, 166, 0.10);
        }

        body.member-onboarding .onboarding-tile.tile-info {
            background: rgba(56, 189, 248, 0.10);
        }

        body.member-onboarding .onboarding-tile.tile-warning {
            background: rgba(251, 191, 36, 0.14);
        }

        body.member-onboarding .onboarding-actions .btn {
            border-radius: 14px;
            padding: .9rem 1.1rem;
            font-weight: 700;
        }

        body.member-onboarding .onboarding-actions .btn.btn-primary {
            background: #10b981;
            border-color: #10b981;
        }

        body.member-onboarding .onboarding-actions .btn.btn-primary:hover {
            background: #0ea371;
            border-color: #0ea371;
        }

        body.member-onboarding .onboarding-actions .btn.btn-label-secondary {
            background: rgba(15, 23, 42, 0.05);
            border-color: rgba(15, 23, 42, 0.06);
        }

        body.member-onboarding .onboarding-actions .btn.btn-label-secondary:hover {
            background: rgba(15, 23, 42, 0.08);
        }

        body.member-onboarding .page-animate {
            animation: onboardingFadeUp 520ms cubic-bezier(.2, .8, .2, 1) both;
        }

        body.member-onboarding .tile-animate {
            animation: onboardingFadeUp 620ms cubic-bezier(.2, .8, .2, 1) both;
        }

        body.member-onboarding .tile-animate:nth-child(1) {
            animation-delay: 60ms;
        }

        body.member-onboarding .tile-animate:nth-child(2) {
            animation-delay: 120ms;
        }

        body.member-onboarding .tile-animate:nth-child(3) {
            animation-delay: 180ms;
        }

        body.member-onboarding .tile-animate:nth-child(4) {
            animation-delay: 240ms;
        }

        @keyframes onboardingFadeUp {
            from {
                opacity: 0;
                transform: translate3d(0, 12px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            body.member-onboarding .page-animate,
            body.member-onboarding .tile-animate {
                animation: none !important;
            }
        }

        body.member-modern {
            background: #f7faf9;
        }

        body.member-modern .content-wrapper {
            background: transparent;
        }

        body.member-modern .page-animate {
            animation: memberFadeUp 520ms cubic-bezier(.2, .8, .2, 1) both;
        }

        body.member-modern .card {
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        body.member-modern .btn {
            border-radius: 12px;
        }

        body.member-modern .btn.btn-success,
        body.member-modern .btn.btn-primary {
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.18);
        }

        body.member-modern .badge {
            border-radius: 999px;
        }

        body.member-modern #layout-navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        body.member-modern #layout-navbar .navbar-nav .nav-link {
            color: rgba(15, 23, 42, 0.72);
            font-weight: 600;
            padding: .55rem .85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        body.member-modern #layout-navbar .navbar-nav .nav-link:hover {
            background: rgba(15, 23, 42, 0.06);
            color: rgba(15, 23, 42, 0.86);
        }

        body.member-modern #layout-navbar .navbar-nav .nav-link.active {
            background: rgba(16, 185, 129, 0.12);
            color: #0f766e;
        }

        body.member-modern #layout-navbar .navbar-nav .nav-link .icon-base {
            font-size: 1.05rem;
        }

        @keyframes memberFadeUp {
            from {
                opacity: 0;
                transform: translate3d(0, 12px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            body.member-modern .page-animate {
                animation: none !important;
            }
        }
    </style>
</head>

<body class="@yield('body_class')">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            <nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4 ms-0">
                        <a href="{{ route('dashboard') }}" class="app-brand-link">
                            <span class="app-brand-text demo menu-text fw-bold text-heading">
                                {{ config('app.name') }}
                            </span>
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i
                                class="icon-base ti tabler-x icon-sm d-flex align-items-center justify-content-center"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none  ">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base ti tabler-menu-2 icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
                        <ul class="navbar-nav me-auto align-items-xl-center d-none d-xl-flex">
                            @include('layouts.navigations.member')
                        </ul>

                        <div class="navbar-nav align-items-center">

                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <li class="nav-item dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base ti tabler-sun icon-md theme-icon-active"></i>
                                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="nav-theme-text">
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center active"
                                            data-bs-theme-value="light" aria-pressed="false">
                                            <span><i class="icon-base ti tabler-sun icon-md me-3"
                                                    data-icon="sun"></i>Light</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center"
                                            data-bs-theme-value="dark" aria-pressed="true">
                                            <span><i class="icon-base ti tabler-moon-stars icon-md me-3"
                                                    data-icon="moon-stars"></i>Dark</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center"
                                            data-bs-theme-value="system" aria-pressed="false">
                                            <span><i class="icon-base ti tabler-device-desktop-analytics icon-md me-3"
                                                    data-icon="device-desktop-analytics"></i>System</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <!-- Language -->
                            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base ti tabler-language icon-22px text-heading"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('language.change', 'en') }}"
                                            data-language="en" data-text-direction="ltr">
                                            <span>English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('language.change', 'ko') }}"
                                            data-language="ko" data-text-direction="ltr">
                                            <span>Korean</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('language.change', 'id') }}"
                                            data-language="id" data-text-direction="ltr">
                                            <span>Bahasa</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <h6 class="mb-0">{{ auth('member')->user()->name }}</h6>
                                            <small class="text-body-secondary">Member</small>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1 mx-n2"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="icon-base ti tabler-user icon-md me-3"></i>
                                            <span>{{ __('common.my_profile') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.change-password') }}">
                                            <i class="icon-base ti tabler-key icon-md me-3"></i>
                                            <span>{{ __('members.change_password') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1 mx-n2"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            <i
                                                class="icon-base ti tabler-power icon-md me-3"></i><span>{{ __('common.logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl grow container-p-y">
                        @yield('content')
                    </div>
                    <!--/ Content -->
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    &#169;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    {{ config('app.name') }}
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    @stack('vendor_scripts')

    <!-- Main JS -->

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: `{{ __('common.success') }}`,
                text: `{{ session('success') }}`,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: `{{ __('common.failed') }}`,
                text: `{{ session('error') }}`,
            });
        @endif
    </script>
    @stack('scripts')
</body>

</html>
