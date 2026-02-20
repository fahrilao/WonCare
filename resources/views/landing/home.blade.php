@extends('layouts.landing')

@section('title', 'Beranda')

@push('styles')
    <style>
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0f9ff 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 100px 0 80px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, .12) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(16, 185, 129, .1);
            border: 1px solid rgba(16, 185, 129, .2);
            color: #059669;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .35rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.25rem;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            letter-spacing: -.04em;
            line-height: 1.1;
            color: #0f172a;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, #10b981, #0d9488);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.1rem;
            color: rgba(15, 23, 42, .6);
            line-height: 1.75;
            max-width: 520px;
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(15, 23, 42, .07);
        }

        .hero-stat-item .stat-number {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.03em;
        }

        .hero-stat-item .stat-label {
            font-size: .8rem;
            color: rgba(15, 23, 42, .5);
            font-weight: 500;
        }

        .hero-video-card {
            background: linear-gradient(135deg, #10b981, #0d9488);
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(16, 185, 129, .22);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            aspect-ratio: 16/10;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-video-play {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            border: 2px solid rgba(255, 255, 255, .25);
        }

        .hero-video-play:hover {
            background: var(--wc-green);
            border-color: var(--wc-green);
            transform: scale(1.08);
        }

        .hero-video-play i {
            font-size: 1.8rem;
            color: #fff;
            margin-left: 4px;
        }

        .hero-video-label {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 12px;
            padding: .6rem 1rem;
            color: #fff;
            font-size: .8rem;
            font-weight: 600;
        }

        .hero-float-card {
            position: absolute;
            background: #fff;
            border-radius: 16px;
            padding: .75rem 1rem;
            box-shadow: 0 8px 32px rgba(15, 23, 42, .12);
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .8rem;
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
        }

        .hero-float-card.card-1 {
            top: -20px;
            right: -20px;
        }

        .hero-float-card.card-2 {
            bottom: 20px;
            left: -30px;
        }

        .hero-float-card .fc-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
        }

        .feature-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: all .25s;
            background: #fff;
        }

        .feature-card:hover {
            border-color: rgba(16, 185, 129, .25);
            box-shadow: 0 12px 40px rgba(16, 185, 129, .1);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .stats-section {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            padding: 72px 0;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-card .stat-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -.04em;
            line-height: 1;
        }

        .stat-card .stat-num span {
            color: rgba(255, 255, 255, .7);
        }

        .stat-card .stat-lbl {
            font-size: .875rem;
            color: rgba(255, 255, 255, .75);
            margin-top: .4rem;
            font-weight: 500;
        }

        .program-card {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, .07);
            background: #fff;
            transition: all .25s;
        }

        .program-card:hover {
            box-shadow: 0 12px 40px rgba(15, 23, 42, .1);
            transform: translateY(-4px);
        }

        .testimonial-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            background: #fff;
            transition: all .25s;
        }

        .testimonial-card:hover {
            box-shadow: 0 8px 32px rgba(15, 23, 42, .08);
            transform: translateY(-3px);
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--wc-green), var(--wc-teal));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stars {
            color: #f59e0b;
            font-size: .9rem;
        }

        .cta-section {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
            pointer-events: none;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="hero-section">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge"><i class="bi bi-stars"></i> Platform Sosial & Keuangan #1</div>
                    <h1 class="hero-title">
                        <span class="highlight">Berdaya</span> &<br>
                        <span class="highlight">Berdampak</span><br>
                        Bersama WONCare
                    </h1>
                    <p class="hero-desc mt-3">Platform digital yang mengintegrasikan edukasi keuangan, donasi sosial, dan
                        komunitas untuk memberdayakan masyarakat Indonesia.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('auth.register') }}" class="btn btn-wc-primary"><i
                                class="bi bi-person-plus me-2"></i>Daftar Sekarang</a>
                        <a href="{{ route('auth.login') }}" class="btn btn-wc-outline"><i
                                class="bi bi-box-arrow-in-right me-2"></i>Masuk</a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="stat-number">{{ number_format($stats['donors']) }}+</div>
                            <div class="stat-label">Donatur Aktif</div>
                        </div>
                        <div style="width:1px;background:rgba(15,23,42,.08);"></div>
                        <div class="hero-stat-item">
                            <div class="stat-number">{{ number_format($stats['participants']) }}+</div>
                            <div class="stat-label">Peserta Kursus</div>
                        </div>
                        <div style="width:1px;background:rgba(15,23,42,.08);"></div>
                        <div class="hero-stat-item">
                            <div class="stat-number">{{ number_format($stats['activities']) }}+</div>
                            <div class="stat-label">Kegiatan Sosial</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative d-flex justify-content-center">
                        <div class="hero-video-card">
                            <div class="hero-video-play">
                                <i class="bi bi-play-fill"></i>
                            </div>
                            <div class="hero-video-label"><i class="bi bi-play-circle me-1"></i> Tonton Video Intro WONCare
                            </div>
                            <div
                                style="position:absolute;top:20px;right:20px;width:80px;height:80px;border-radius:50%;background:rgba(16,185,129,.15);">
                            </div>
                        </div>
                        <div class="hero-float-card card-1">
                            <div class="fc-icon" style="background:#d1fae5;color:#059669;"><i
                                    class="bi bi-mortarboard-fill"></i></div>
                            <div>
                                <div style="font-size:.7rem;color:rgba(15,23,42,.5);">E-Course</div>
                                <div>50+ Kursus</div>
                            </div>
                        </div>
                        <div class="hero-float-card card-2">
                            <div class="fc-icon" style="background:#fef3c7;color:#d97706;"><i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <div style="font-size:.7rem;color:rgba(15,23,42,.5);">Donasi Terkumpul</div>
                                <div>Rp 4,8 Miliar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="wc-section" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-grid-3x3-gap-fill"></i> Fitur Utama</div>
                <h2 class="wc-section-title">Semua yang Anda Butuhkan<br>dalam Satu Platform</h2>
                <p class="wc-section-subtitle mt-3">WONCare hadir dengan fitur lengkap untuk mendukung perjalanan finansial
                    dan sosial Anda.</p>
            </div>
            <div class="row g-4">
                @php
                    $features = [
                        [
                            'icon' => 'bi-mortarboard-fill',
                            'bg' => '#d1fae5',
                            'color' => '#059669',
                            'title' => 'E-Course Keuangan',
                            'desc' =>
                                'Pelajari manajemen keuangan, investasi syariah, dan perencanaan masa depan melalui kursus interaktif bersertifikat.',
                            'cta' => 'Mulai Belajar',
                        ],
                        [
                            'icon' => 'bi-heart-fill',
                            'bg' => '#fef3c7',
                            'color' => '#d97706',
                            'title' => 'Donasi Transparan',
                            'desc' =>
                                'Berdonasi untuk berbagai program sosial dengan sistem pelaporan transparan. Pantau dampak donasi Anda secara real-time.',
                            'cta' => 'Donasi Sekarang',
                        ],
                        [
                            'icon' => 'bi-people-fill',
                            'bg' => '#ede9fe',
                            'color' => '#7c3aed',
                            'title' => 'Komunitas Aktif',
                            'desc' =>
                                'Bergabung dengan komunitas yang peduli. Ikuti diskusi, event, dan kegiatan sosial bersama ribuan anggota aktif.',
                            'cta' => 'Gabung Komunitas',
                        ],
                        [
                            'icon' => 'bi-calculator-fill',
                            'bg' => '#dbeafe',
                            'color' => '#2563eb',
                            'title' => 'Tools Keuangan',
                            'desc' =>
                                'Hitung zakat otomatis, lacak pemasukan & pengeluaran, buat target tabungan, dan unduh laporan keuangan pribadi.',
                            'cta' => 'Coba Gratis',
                        ],
                ]; @endphp
                @foreach ($features as $f)
                    <div class="col-sm-6 col-lg-3 fade-up" style="transition-delay:{{ $loop->index * 0.07 }}s">
                        <div class="feature-card">
                            <div class="feature-icon" style="background:{{ $f['bg'] }};color:{{ $f['color'] }};"><i
                                    class="bi {{ $f['icon'] }}"></i></div>
                            <h5>{{ $f['title'] }}</h5>
                            <p style="font-size:.875rem;color:rgba(15,23,42,.58);line-height:1.7;margin:0;">
                                {{ $f['desc'] }}</p>
                            <a href="{{ route('auth.register') }}" class="d-inline-flex align-items-center gap-1 mt-3"
                                style="font-size:.85rem;font-weight:600;color:var(--wc-green);text-decoration:none;">{{ $f['cta'] }}
                                <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="stats-section fade-up">
        <div class="container">
            <div class="row g-0 align-items-center justify-content-center">
                @php $statsItems = [['num' => $stats['donors'], 'label' => 'Donatur Aktif', 'icon' => 'bi-heart'], ['num' => $stats['participants'], 'label' => 'Peserta Kursus', 'icon' => 'bi-mortarboard'], ['num' => $stats['activities'], 'label' => 'Kegiatan Sosial', 'icon' => 'bi-calendar-event'], ['num' => $stats['campaigns'], 'label' => 'Kampanye Aktif', 'icon' => 'bi-megaphone']]; @endphp
                @foreach ($statsItems as $s)
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <div class="stat-num">{{ number_format($s['num']) }}<span>+</span></div>
                            <div class="stat-lbl"><i class="bi {{ $s['icon'] }} me-1"></i>{{ $s['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PROGRAMS --}}
    <section class="wc-section" style="background:#f8fafc;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-globe-asia-australia"></i> Program Sosial</div>
                <h2 class="wc-section-title">4 Program Unggulan WONCare</h2>
                <p class="wc-section-subtitle mt-3">Setiap donasi Anda disalurkan melalui program-program terverifikasi yang
                    berdampak nyata.</p>
            </div>
            <div class="row g-4">
                @php
                    $programs = [
                        [
                            'icon' => 'bi-building',
                            'color' => '#10b981',
                            'bg' => '#d1fae5',
                            'title' => 'Masjid Care',
                            'desc' =>
                                'Renovasi dan pemberdayaan masjid di daerah terpencil sebagai pusat kegiatan sosial dan pendidikan umat.',
                            'raised' => 'Rp 1,2 M',
                            'goal' => 'Rp 2 M',
                            'pct' => 60,
                        ],
                        [
                            'icon' => 'bi-airplane',
                            'color' => '#3b82f6',
                            'bg' => '#dbeafe',
                            'title' => 'Migrant Care',
                            'desc' =>
                                'Pendampingan TKI di luar negeri, bantuan hukum, pelatihan wirausaha, dan program pemulangan.',
                            'raised' => 'Rp 850 Jt',
                            'goal' => 'Rp 1,5 M',
                            'pct' => 57,
                        ],
                        [
                            'icon' => 'bi-heart-pulse',
                            'color' => '#ef4444',
                            'bg' => '#fee2e2',
                            'title' => 'Palestine Care',
                            'desc' =>
                                'Solidaritas kemanusiaan untuk saudara di Palestina melalui donasi, advokasi, dan kampanye global.',
                            'raised' => 'Rp 2,4 M',
                            'goal' => 'Rp 3 M',
                            'pct' => 80,
                        ],
                        [
                            'icon' => 'bi-map',
                            'color' => '#f59e0b',
                            'bg' => '#fef3c7',
                            'title' => 'Nusantara Care',
                            'desc' =>
                                'Pemberdayaan masyarakat di seluruh Nusantara melalui pendidikan, ekonomi, dan kesehatan.',
                            'raised' => 'Rp 600 Jt',
                            'goal' => 'Rp 1 M',
                            'pct' => 60,
                        ],
                ]; @endphp
                @foreach ($programs as $p)
                    <div class="col-sm-6 col-lg-3 fade-up" style="transition-delay:{{ $loop->index * 0.07 }}s">
                        <div class="program-card h-100">
                            <div style="height:8px;background:{{ $p['color'] }};"></div>
                            <div style="padding:1.75rem;">
                                <div
                                    style="width:52px;height:52px;border-radius:14px;background:{{ $p['bg'] }};color:{{ $p['color'] }};display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1rem;">
                                    <i class="bi {{ $p['icon'] }}"></i>
                                </div>
                                <h5 style="font-size:1rem;font-weight:700;margin-bottom:.5rem;">{{ $p['title'] }}</h5>
                                <p style="font-size:.85rem;color:rgba(15,23,42,.58);line-height:1.65;margin-bottom:1rem;">
                                    {{ $p['desc'] }}</p>
                                <div class="d-flex justify-content-between mb-1" style="font-size:.75rem;font-weight:600;">
                                    <span style="color:{{ $p['color'] }};">{{ $p['raised'] }} terkumpul</span>
                                    <span style="color:rgba(15,23,42,.4);">{{ $p['goal'] }}</span>
                                </div>
                                <div class="progress" style="height:6px;border-radius:999px;background:rgba(15,23,42,.07);">
                                    <div class="progress-bar"
                                        style="width:{{ $p['pct'] }}%;background:{{ $p['color'] }};border-radius:999px;">
                                    </div>
                                </div>
                                <a href="{{ route('auth.register') }}" class="btn btn-sm w-100 mt-3 fw-bold"
                                    style="border-radius:10px;background:{{ $p['bg'] }};color:{{ $p['color'] }};border:none;font-size:.82rem;">Donasi
                                    Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="wc-section" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <div class="wc-label"><i class="bi bi-chat-quote-fill"></i> Testimoni</div>
                <h2 class="wc-section-title">Apa Kata Pengguna WONCare?</h2>
                <p class="wc-section-subtitle mt-3">Ribuan pengguna telah merasakan manfaat nyata dari platform WONCare.
                </p>
            </div>
            <div class="row g-4">
                @foreach ($testimonials as $t)
                    <div class="col-md-4 fade-up" style="transition-delay:{{ $loop->index * 0.08 }}s">
                        <div class="testimonial-card">
                            <div class="stars mb-3">
                                @for ($i = 0; $i < $t['rating']; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                            <p
                                style="font-size:.9rem;color:rgba(15,23,42,.65);line-height:1.75;font-style:italic;margin-bottom:1.25rem;">
                                "{{ $t['text'] }}"</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar">{{ substr($t['name'], 0, 1) }}</div>
                                <div>
                                    <div style="font-weight:700;font-size:.9rem;">{{ $t['name'] }}</div>
                                    <div style="font-size:.8rem;color:rgba(15,23,42,.5);">{{ $t['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 fade-up">
                    <div class="wc-label" style="background:rgba(255,255,255,.15);color:#fff;border:none;"><i
                            class="bi bi-rocket-takeoff"></i> Mulai Sekarang</div>
                    <h2
                        style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:900;color:#fff;letter-spacing:-.03em;margin-top:.5rem;">
                        Bergabunglah dengan 12.000+<br>Anggota WONCare
                    </h2>
                    <p style="color:rgba(255,255,255,.8);font-size:1.05rem;margin-top:.75rem;">Daftar gratis sekarang dan
                        mulai perjalanan Anda menuju kemandirian finansial dan dampak sosial yang nyata.</p>
                </div>
                <div class="col-lg-5 fade-up text-lg-end" style="transition-delay:.1s">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="{{ route('auth.register') }}" class="btn"
                            style="background:#fff;color:var(--wc-green);font-weight:700;border-radius:12px;padding:.8rem 2rem;font-size:1rem;box-shadow:0 4px 20px rgba(0,0,0,.15);">
                            <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                        </a>
                        <a href="{{ route('landing.about') }}" class="btn"
                            style="background:transparent;color:#fff;font-weight:700;border-radius:12px;border:2px solid rgba(255,255,255,.5);padding:.75rem 2rem;font-size:1rem;">
                            <i class="bi bi-info-circle me-2"></i>Pelajari Lebih
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
