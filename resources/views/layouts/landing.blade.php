<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="@yield('meta_description', 'WONCare – Platform pemberdayaan masyarakat melalui edukasi keuangan, donasi sosial, dan komunitas.')" />
    <title>@yield('title', 'WONCare') – {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    @stack('styles')

    <style>
        :root {
            --wc-green:       #10b981;
            --wc-green-dark:  #059669;
            --wc-green-light: #d1fae5;
            --wc-teal:        #0d9488;
            --wc-navy:        #0f172a;
            --wc-muted:       rgba(15,23,42,.55);
            --wc-border:      rgba(15,23,42,.08);
            --wc-radius:      16px;
            --wc-radius-sm:   10px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--wc-navy);
            background: #fff;
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5,h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
        }

        /* ── Navbar ── */
        .wc-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--wc-border);
            transition: box-shadow .2s;
        }
        .wc-navbar.scrolled { box-shadow: 0 2px 20px rgba(15,23,42,.08); }
        .wc-navbar .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.35rem;
            letter-spacing: -.03em;
            color: var(--wc-green) !important;
        }
        .wc-navbar .nav-link {
            font-size: .875rem;
            font-weight: 500;
            color: var(--wc-muted) !important;
            padding: .45rem .75rem !important;
            border-radius: var(--wc-radius-sm);
            transition: all .15s;
        }
        .wc-navbar .nav-link:hover,
        .wc-navbar .nav-link.active {
            color: var(--wc-green) !important;
            background: var(--wc-green-light);
        }
        .wc-navbar .btn-nav-login {
            font-size: .875rem;
            font-weight: 600;
            color: var(--wc-green) !important;
            border: 1.5px solid var(--wc-green);
            border-radius: var(--wc-radius-sm);
            padding: .4rem 1rem;
            transition: all .15s;
        }
        .wc-navbar .btn-nav-login:hover {
            background: var(--wc-green);
            color: #fff !important;
        }
        .wc-navbar .btn-nav-register {
            font-size: .875rem;
            font-weight: 600;
            background: var(--wc-green);
            color: #fff !important;
            border-radius: var(--wc-radius-sm);
            padding: .4rem 1rem;
            border: none;
            transition: all .15s;
        }
        .wc-navbar .btn-nav-register:hover { background: var(--wc-green-dark); }

        /* ── Page body offset ── */
        .wc-page { padding-top: 72px; }

        /* ── Section helpers ── */
        .wc-section { padding: 80px 0; }
        .wc-section-sm { padding: 56px 0; }
        .wc-section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.2;
        }
        .wc-section-subtitle {
            font-size: 1.05rem;
            color: var(--wc-muted);
            max-width: 560px;
            margin: 0 auto;
        }
        .wc-label {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--wc-green-light);
            color: var(--wc-teal);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .3rem .85rem;
            border-radius: 999px;
            margin-bottom: .75rem;
        }

        /* ── Buttons ── */
        .btn-wc-primary {
            background: var(--wc-green);
            color: #fff;
            font-weight: 700;
            border-radius: var(--wc-radius-sm);
            border: none;
            padding: .75rem 1.75rem;
            font-size: .95rem;
            transition: all .18s;
            box-shadow: 0 4px 16px rgba(16,185,129,.28);
        }
        .btn-wc-primary:hover {
            background: var(--wc-green-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(16,185,129,.35);
        }
        .btn-wc-outline {
            background: transparent;
            color: var(--wc-green);
            font-weight: 700;
            border-radius: var(--wc-radius-sm);
            border: 2px solid var(--wc-green);
            padding: .7rem 1.75rem;
            font-size: .95rem;
            transition: all .18s;
        }
        .btn-wc-outline:hover {
            background: var(--wc-green);
            color: #fff;
        }

        /* ── Cards ── */
        .wc-card {
            border: 1px solid var(--wc-border);
            border-radius: var(--wc-radius);
            background: #fff;
            transition: box-shadow .2s, transform .2s;
        }
        .wc-card:hover {
            box-shadow: 0 8px 32px rgba(15,23,42,.09);
            transform: translateY(-3px);
        }

        /* ── Icon box ── */
        .wc-icon-box {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        /* ── Footer ── */
        .wc-footer {
            background: var(--wc-navy);
            color: rgba(255,255,255,.7);
            padding: 64px 0 32px;
        }
        .wc-footer .footer-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: -.03em;
            color: #fff;
        }
        .wc-footer h6 {
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .wc-footer a {
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .875rem;
            transition: color .15s;
            display: block;
            margin-bottom: .45rem;
        }
        .wc-footer a:hover { color: var(--wc-green); }
        .wc-footer .footer-divider {
            border-color: rgba(255,255,255,.1);
            margin: 40px 0 24px;
        }
        .wc-footer .footer-bottom {
            font-size: .8rem;
            color: rgba(255,255,255,.4);
        }
        .wc-footer .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.7);
            font-size: 1rem;
            transition: all .15s;
            margin-right: .4rem;
            margin-bottom: 0;
        }
        .wc-footer .social-link:hover {
            background: var(--wc-green);
            color: #fff;
        }

        /* ── Animations ── */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .wc-section { padding: 56px 0; }
            .wc-section-sm { padding: 40px 0; }
        }
    </style>
</head>
<body class="wc-page">

    <!-- Navbar -->
    <nav class="wc-navbar navbar navbar-expand-lg" id="wc-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing.home') }}">
                <i class="bi bi-heart-fill me-1" style="color:var(--wc-green);font-size:1.1rem;"></i>WONCare
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list" style="font-size:1.5rem;color:var(--wc-navy);"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.home') ? 'active' : '' }}" href="{{ route('landing.home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.about') ? 'active' : '' }}" href="{{ route('landing.about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.blog*') ? 'active' : '' }}" href="{{ route('landing.blog') }}">Blog & News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.events') ? 'active' : '' }}" href="{{ route('landing.events') }}">Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.contact') ? 'active' : '' }}" href="{{ route('landing.contact') }}">Kontak</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <!-- Language -->
                    <div class="dropdown">
                        <button class="btn btn-sm border-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size:.8rem;font-weight:500;">
                            <i class="bi bi-translate me-1"></i>
                            {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px;min-width:130px;">
                            <li><a class="dropdown-item" href="{{ route('language.change', 'id') }}">🇮🇩 Bahasa</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'en') }}">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'ko') }}">🇰🇷 Korean</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('auth.login') }}" class="btn-nav-login btn">Masuk</a>
                    <a href="{{ route('auth.register') }}" class="btn-nav-register btn">Daftar</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- /Navbar -->

    <!-- Page Content -->
    @yield('content')
    <!-- /Page Content -->

    <!-- Footer -->
    <footer class="wc-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand mb-3">
                        <i class="bi bi-heart-fill me-2" style="color:var(--wc-green);"></i>WONCare
                    </div>
                    <p style="font-size:.875rem;line-height:1.7;max-width:300px;">
                        Platform pemberdayaan masyarakat melalui edukasi keuangan, donasi sosial, dan komunitas yang berdaya & berdampak.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Platform</h6>
                    <a href="{{ route('landing.home') }}">Beranda</a>
                    <a href="{{ route('landing.about') }}">Tentang Kami</a>
                    <a href="{{ route('landing.blog') }}">Blog & News</a>
                    <a href="{{ route('landing.events') }}">Event</a>
                    <a href="{{ route('landing.contact') }}">Kontak</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Program</h6>
                    <a href="#">Masjid Care</a>
                    <a href="#">Migrant Care</a>
                    <a href="#">Palestine Care</a>
                    <a href="#">Nusantara Care</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Member</h6>
                    <a href="{{ route('auth.register') }}">Daftar Sekarang</a>
                    <a href="{{ route('auth.login') }}">Masuk</a>
                    <a href="{{ route('auth.login') }}">E-Course</a>
                    <a href="{{ route('auth.login') }}">Donasi</a>
                    <a href="{{ route('auth.login') }}">Komunitas</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Kontak</h6>
                    <a href="mailto:support@woncare.id"><i class="bi bi-envelope me-1"></i>support@woncare.id</a>
                    <a href="https://wa.me/6281234567890" target="_blank"><i class="bi bi-whatsapp me-1"></i>+62 812-3456-7890</a>
                    <a href="#"><i class="bi bi-geo-alt me-1"></i>Jakarta, Indonesia</a>
                </div>
            </div>

            <hr class="footer-divider" />

            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 footer-bottom">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                <div class="d-flex gap-3">
                    <a href="#" style="color:rgba(255,255,255,.4);font-size:.8rem;text-decoration:none;">Kebijakan Privasi</a>
                    <a href="#" style="color:rgba(255,255,255,.4);font-size:.8rem;text-decoration:none;">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('wc-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Intersection observer for fade-up animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>

    @stack('scripts')
</body>
</html>
