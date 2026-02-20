@extends('layouts.landing')

@section('title', 'Tentang WONCare')

@push('styles')
    <style>
        .about-hero {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0f9ff 100%);
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, .15) 0%, transparent 70%);
            pointer-events: none;
        }

        .about-hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.04em;
            line-height: 1.15;
        }

        .about-hero-title span {
            background: linear-gradient(135deg, #10b981, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mv-card {
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            border: none;
        }

        .program-card-lg {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            transition: all .25s;
        }

        .program-card-lg:hover {
            box-shadow: 0 12px 40px rgba(15, 23, 42, .1);
            transform: translateY(-4px);
        }

        .team-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            background: #fff;
            transition: all .25s;
        }

        .team-card:hover {
            box-shadow: 0 8px 32px rgba(15, 23, 42, .08);
            transform: translateY(-3px);
        }

        .team-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #0d9488);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 1.6rem;
            margin: 0 auto 1rem;
        }

        .partner-badge {
            display: inline-flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 12px;
            padding: .6rem 1.25rem;
            font-size: .875rem;
            font-weight: 600;
            color: rgba(15, 23, 42, .7);
            transition: all .2s;
        }

        .partner-badge:hover {
            background: #d1fae5;
            border-color: rgba(16, 185, 129, .3);
            color: #059669;
        }

        .timeline-item {
            display: flex;
            gap: 1.5rem;
            padding-bottom: 2rem;
            position: relative;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: 0;
            width: 2px;
            background: rgba(15, 23, 42, .08);
        }

        .timeline-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--wc-green-light);
            border: 3px solid var(--wc-green);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--wc-green);
            font-size: .9rem;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="about-hero">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="wc-label"><i class="bi bi-info-circle-fill"></i> Tentang Kami</div>
                    <h1 class="about-hero-title mt-2">Kami Hadir untuk<br><span>Memberdayakan</span><br>Masyarakat Indonesia
                    </h1>
                    <p style="color:rgba(15,23,42,.6);font-size:1.05rem;line-height:1.75;max-width:520px;margin-top:1rem;">
                        WONCare adalah platform digital yang lahir dari kepedulian terhadap kesejahteraan masyarakat
                        Indonesia melalui pendekatan holistik: keuangan, sosial, dan spiritual.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('auth.register') }}" class="btn btn-wc-primary"><i
                                class="bi bi-person-plus me-2"></i>Bergabung Sekarang</a>
                        <a href="{{ route('landing.contact') }}" class="btn"
                            style="background:transparent;color:var(--wc-green);border:1.5px solid var(--wc-green);border-radius:10px;font-weight:600;padding:.7rem 1.5rem;">
                            <i class="bi bi-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-3">
                        @php $heroStats = [['num' => '2021', 'label' => 'Tahun Berdiri', 'icon' => 'bi-calendar-heart', 'color' => '#10b981', 'bg' => 'rgba(16,185,129,.15)'], ['num' => '12K+', 'label' => 'Anggota Aktif', 'icon' => 'bi-people-fill', 'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,.15)'], ['num' => 'Rp 4,8M', 'label' => 'Total Donasi', 'icon' => 'bi-heart-fill', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,.15)'], ['num' => '4', 'label' => 'Program Sosial', 'icon' => 'bi-globe', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,.15)']]; @endphp
                        @foreach ($heroStats as $s)
                            <div class="col-6">
                                <div
                                    style="background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:16px;padding:1.25rem;text-align:center;box-shadow:0 4px 16px rgba(15,23,42,.06);">
                                    <div
                                        style="width:40px;height:40px;border-radius:12px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-size:1.1rem;color:{{ $s['color'] }};">
                                        <i class="bi {{ $s['icon'] }}"></i></div>
                                    <div
                                        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;font-weight:800;color:#0f172a;letter-spacing:-.03em;">
                                        {{ $s['num'] }}</div>
                                    <div style="font-size:.75rem;color:rgba(15,23,42,.5);margin-top:.2rem;">
                                        {{ $s['label'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MISI & VISI --}}
    <section class="wc-section" style="background:#f8fafc;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-compass-fill"></i> Misi & Visi</div>
                <h2 class="wc-section-title">Landasan Gerak WONCare</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 fade-up">
                    <div class="mv-card" style="background:linear-gradient(135deg,#10b981,#0d9488);">
                        <div
                            style="width:52px;height:52px;border-radius:16px;background:rgba(16,185,129,.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#10b981;margin-bottom:1.5rem;">
                            <i class="bi bi-eye-fill"></i></div>
                        <h3 style="color:#fff;font-size:1.5rem;font-weight:800;margin-bottom:1rem;">Visi</h3>
                        <p style="color:rgba(255,255,255,.7);font-size:1rem;line-height:1.8;">
                            Menjadi platform pemberdayaan masyarakat terdepan di Asia Tenggara yang mengintegrasikan
                            nilai-nilai Islam dengan teknologi modern untuk menciptakan masyarakat yang mandiri, sejahtera,
                            dan berdampak.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 fade-up" style="transition-delay:.1s">
                    <div class="mv-card" style="background:linear-gradient(135deg,#10b981,#0d9488);">
                        <div
                            style="width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;margin-bottom:1.5rem;">
                            <i class="bi bi-rocket-takeoff-fill"></i></div>
                        <h3 style="color:#fff;font-size:1.5rem;font-weight:800;margin-bottom:1rem;">Misi</h3>
                        <ul
                            style="color:rgba(255,255,255,.85);font-size:.95rem;line-height:2;padding-left:1.25rem;margin:0;">
                            <li>Menyediakan edukasi keuangan berbasis nilai Islam yang mudah diakses</li>
                            <li>Memfasilitasi donasi sosial yang transparan dan berdampak nyata</li>
                            <li>Membangun komunitas yang saling mendukung dan memberdayakan</li>
                            <li>Mengembangkan tools keuangan yang membantu perencanaan hidup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAMS --}}
    <section class="wc-section" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-globe-asia-australia"></i> Program Sosial</div>
                <h2 class="wc-section-title">Program Unggulan Kami</h2>
                <p class="wc-section-subtitle mt-3">Empat pilar program sosial WONCare yang berdampak langsung pada
                    masyarakat.</p>
            </div>
            <div class="row g-4">
                @foreach ($programs as $p)
                    <div class="col-md-6 fade-up" style="transition-delay:{{ $loop->index * 0.08 }}s">
                        <div class="program-card-lg">
                            <div style="height:6px;background:{{ $p['color'] }};"></div>
                            <div style="padding:2rem;">
                                <div class="d-flex align-items-start gap-4">
                                    <div
                                        style="width:60px;height:60px;border-radius:18px;background:{{ $p['color'] }}1a;color:{{ $p['color'] }};display:flex;align-items:center;justify-content:center;font-size:1.6rem;flex-shrink:0;">
                                        <i class="bi {{ $p['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <h4 style="font-size:1.15rem;font-weight:800;margin-bottom:.5rem;">
                                            {{ $p['title'] }}</h4>
                                        <p style="font-size:.9rem;color:rgba(15,23,42,.6);line-height:1.75;margin:0;">
                                            {{ $p['desc'] }}</p>
                                        <a href="{{ route('auth.register') }}"
                                            class="d-inline-flex align-items-center gap-1 mt-3"
                                            style="font-size:.85rem;font-weight:600;color:{{ $p['color'] }};text-decoration:none;">
                                            Dukung Program Ini <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TEAM --}}
    <section class="wc-section" style="background:#f8fafc;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-people-fill"></i> Tim Kami</div>
                <h2 class="wc-section-title">Orang-orang di Balik WONCare</h2>
                <p class="wc-section-subtitle mt-3">Tim berdedikasi yang bekerja keras setiap hari untuk mewujudkan misi
                    WONCare.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($team as $member)
                    <div class="col-6 col-md-3 fade-up" style="transition-delay:{{ $loop->index * 0.07 }}s">
                        <div class="team-card">
                            <div class="team-avatar">{{ substr($member['name'], 0, 1) }}</div>
                            <h6 style="font-weight:700;margin-bottom:.25rem;font-size:.95rem;">{{ $member['name'] }}</h6>
                            <span style="font-size:.8rem;color:rgba(15,23,42,.5);">{{ $member['role'] }}</span>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="#"
                                    style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:rgba(15,23,42,.5);font-size:.85rem;text-decoration:none;transition:all .15s;"
                                    onmouseover="this.style.background='#d1fae5';this.style.color='#059669'"
                                    onmouseout="this.style.background='#f1f5f9';this.style.color='rgba(15,23,42,.5)'"><i
                                        class="bi bi-linkedin"></i></a>
                                <a href="#"
                                    style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:rgba(15,23,42,.5);font-size:.85rem;text-decoration:none;transition:all .15s;"
                                    onmouseover="this.style.background='#d1fae5';this.style.color='#059669'"
                                    onmouseout="this.style.background='#f1f5f9';this.style.color='rgba(15,23,42,.5)'"><i
                                        class="bi bi-twitter-x"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TRANSPARENCY --}}
    <section class="wc-section" style="background:#fff;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-up">
                    <div class="wc-label"><i class="bi bi-shield-check-fill"></i> Transparansi</div>
                    <h2 class="wc-section-title mt-2">Laporan Keuangan<br>yang Terbuka & Jujur</h2>
                    <p style="color:rgba(15,23,42,.6);font-size:1rem;line-height:1.8;margin-top:1rem;">
                        WONCare berkomitmen penuh terhadap transparansi. Setiap rupiah yang masuk dan keluar dilaporkan
                        secara terbuka dan dapat diakses oleh seluruh pemangku kepentingan.
                    </p>
                    <div class="row g-3 mt-2">
                        @php $transparencyItems = [['icon' => 'bi-file-earmark-text', 'color' => '#10b981', 'bg' => '#d1fae5', 'title' => 'Laporan Bulanan', 'desc' => 'Diterbitkan setiap bulan'], ['icon' => 'bi-patch-check', 'color' => '#3b82f6', 'bg' => '#dbeafe', 'title' => 'Audit Independen', 'desc' => 'Diaudit pihak ketiga'], ['icon' => 'bi-eye', 'color' => '#7c3aed', 'bg' => '#ede9fe', 'title' => 'Real-time Tracking', 'desc' => 'Pantau donasi langsung'], ['icon' => 'bi-award', 'color' => '#f59e0b', 'bg' => '#fef3c7', 'title' => 'Bersertifikat', 'desc' => 'Lembaga terdaftar resmi']]; @endphp
                        @foreach ($transparencyItems as $item)
                            <div class="col-6">
                                <div
                                    style="display:flex;align-items:center;gap:.75rem;padding:1rem;border:1px solid rgba(15,23,42,.07);border-radius:14px;background:#fff;">
                                    <div
                                        style="width:40px;height:40px;border-radius:12px;background:{{ $item['bg'] }};color:{{ $item['color'] }};display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">
                                        <i class="bi {{ $item['icon'] }}"></i></div>
                                    <div>
                                        <div style="font-size:.85rem;font-weight:700;">{{ $item['title'] }}</div>
                                        <div style="font-size:.75rem;color:rgba(15,23,42,.5);">{{ $item['desc'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('auth.register') }}" class="btn btn-wc-primary mt-4"><i
                            class="bi bi-download me-2"></i>Unduh Laporan Terbaru</a>
                </div>
                <div class="col-lg-6 fade-up" style="transition-delay:.1s">
                    <div style="background:#f8fafc;border-radius:24px;padding:2rem;border:1px solid rgba(15,23,42,.07);">
                        <h5 style="font-weight:800;margin-bottom:1.5rem;">Ringkasan Dana 2025</h5>
                        @php $fundItems = [['label' => 'Total Donasi Masuk', 'amount' => 'Rp 4,8 Miliar', 'pct' => 100, 'color' => '#10b981'], ['label' => 'Masjid Care', 'amount' => 'Rp 1,2 Miliar', 'pct' => 25, 'color' => '#3b82f6'], ['label' => 'Migrant Care', 'amount' => 'Rp 850 Juta', 'pct' => 18, 'color' => '#7c3aed'], ['label' => 'Palestine Care', 'amount' => 'Rp 2,4 Miliar', 'pct' => 50, 'color' => '#ef4444'], ['label' => 'Nusantara Care', 'amount' => 'Rp 350 Juta', 'pct' => 7, 'color' => '#f59e0b']]; @endphp
                        @foreach ($fundItems as $fi)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size:.85rem;font-weight:600;">{{ $fi['label'] }}</span>
                                    <span
                                        style="font-size:.85rem;font-weight:700;color:{{ $fi['color'] }};">{{ $fi['amount'] }}</span>
                                </div>
                                <div class="progress"
                                    style="height:8px;border-radius:999px;background:rgba(15,23,42,.07);">
                                    <div class="progress-bar"
                                        style="width:{{ $fi['pct'] }}%;background:{{ $fi['color'] }};border-radius:999px;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PARTNERS --}}
    <section class="wc-section-sm" style="background:#f8fafc;">
        <div class="container">
            <div class="text-center mb-4 fade-up">
                <div class="wc-label"><i class="bi bi-handshake-fill"></i> Mitra</div>
                <h2 class="wc-section-title">Dipercaya oleh Lembaga Terkemuka</h2>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-3 fade-up">
                @foreach ($partners as $partner)
                    <div class="partner-badge">
                        <i class="bi bi-patch-check-fill me-2" style="color:var(--wc-green);"></i>{{ $partner }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section style="background:linear-gradient(135deg,#10b981,#0d9488);padding:72px 0;">
        <div class="container text-center fade-up">
            <h2 style="font-size:clamp(1.75rem,4vw,2.5rem);font-weight:900;color:#fff;letter-spacing:-.03em;">Siap
                Bergabung dengan WONCare?</h2>
            <p style="color:rgba(255,255,255,.8);font-size:1.05rem;margin-top:.75rem;">Jadilah bagian dari gerakan
                pemberdayaan masyarakat Indonesia.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                <a href="{{ route('auth.register') }}" class="btn"
                    style="background:#fff;color:var(--wc-green);font-weight:700;border-radius:12px;padding:.8rem 2rem;font-size:1rem;">
                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('landing.contact') }}" class="btn"
                    style="background:transparent;color:#fff;font-weight:700;border-radius:12px;border:2px solid rgba(255,255,255,.5);padding:.75rem 2rem;font-size:1rem;">
                    <i class="bi bi-envelope me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </section>

@endsection
