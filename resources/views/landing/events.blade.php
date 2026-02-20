@extends('layouts.landing')

@section('title', 'Event & Kegiatan')

@push('styles')
    <style>
        .events-hero {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            padding: 80px 0 60px;
        }

        .event-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            background: #fff;
            transition: all .25s;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            box-shadow: 0 12px 40px rgba(15, 23, 42, .1);
            transform: translateY(-4px);
        }

        .event-card-header {
            padding: 1.5rem 1.5rem 0;
        }

        .event-card-body {
            padding: 1rem 1.5rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .event-date-box {
            background: #f8fafc;
            border-radius: 14px;
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .event-date-box .date-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--wc-green-light);
            color: var(--wc-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .type-badge {
            display: inline-block;
            padding: .25rem .75rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
        }

        .type-badge.info {
            background: #dbeafe;
            color: #2563eb;
        }

        .type-badge.success {
            background: #d1fae5;
            color: #059669;
        }

        .type-badge.warning {
            background: #fef3c7;
            color: #d97706;
        }

        .seats-bar {
            height: 6px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .07);
            overflow: hidden;
        }

        .seats-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--wc-green);
        }

        .past-event-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 14px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .07);
            transition: all .2s;
        }

        .past-event-row:hover {
            box-shadow: 0 4px 16px rgba(15, 23, 42, .07);
        }

        .past-event-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: rgba(15, 23, 42, .4);
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="events-hero">
        <div class="container">
            <div class="text-center fade-up">
                <div class="wc-label"><i class="bi bi-calendar-event-fill"></i> Event & Kegiatan</div>
                <h1 class="wc-section-title mt-2">Jadwal Kegiatan<br>Offline & Online WONCare</h1>
                <p class="wc-section-subtitle mt-3">Ikuti berbagai event edukatif, workshop, kajian, dan kegiatan sosial
                    bersama komunitas WONCare.</p>
            </div>

            {{-- Quick Stats --}}
            <div class="row g-3 justify-content-center mt-4 fade-up">
                @php $evStats = [['num' => count($upcoming), 'label' => 'Event Mendatang', 'icon' => 'bi-calendar-check', 'color' => '#10b981', 'bg' => '#d1fae5'], ['num' => count($past), 'label' => 'Event Selesai', 'icon' => 'bi-calendar-x', 'color' => '#3b82f6', 'bg' => '#dbeafe'], ['num' => '2.250+', 'label' => 'Total Peserta', 'icon' => 'bi-people-fill', 'color' => '#7c3aed', 'bg' => '#ede9fe']]; @endphp
                @foreach ($evStats as $s)
                    <div class="col-auto">
                        <div
                            style="background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:16px;padding:.85rem 1.5rem;display:flex;align-items:center;gap:.75rem;">
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:{{ $s['bg'] }};color:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;font-size:.9rem;">
                                <i class="bi {{ $s['icon'] }}"></i></div>
                            <div>
                                <div
                                    style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.2rem;font-weight:800;color:#0f172a;line-height:1;">
                                    {{ $s['num'] }}</div>
                                <div style="font-size:.75rem;color:rgba(15,23,42,.5);">{{ $s['label'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    <section class="wc-section" style="background:#fff;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4 fade-up">
                <div>
                    <div class="wc-label mb-1"><i class="bi bi-clock-fill"></i> Segera Hadir</div>
                    <h2 class="wc-section-title" style="font-size:1.75rem;">Event Mendatang</h2>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($upcoming as $event)
                    <div class="col-md-6 col-lg-3 fade-up" style="transition-delay:{{ $loop->index * 0.07 }}s">
                        <div class="event-card">
                            <div class="event-card-header">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="type-badge {{ $event['type_color'] }}">
                                        <i
                                            class="bi {{ $event['type'] === 'Online' ? 'bi-camera-video' : 'bi-geo-alt' }} me-1"></i>{{ $event['type'] }}
                                    </span>
                                    @if ($event['free'])
                                        <span
                                            style="background:#d1fae5;color:#059669;font-size:.72rem;font-weight:700;padding:.2rem .65rem;border-radius:999px;">GRATIS</span>
                                    @endif
                                </div>
                                <h5 style="font-size:.95rem;font-weight:700;line-height:1.5;margin-bottom:1rem;">
                                    {{ $event['title'] }}</h5>
                            </div>
                            <div class="event-card-body">
                                <div class="event-date-box">
                                    <div class="date-icon"><i class="bi bi-calendar3"></i></div>
                                    <div>
                                        <div style="font-size:.8rem;font-weight:700;color:#0f172a;">{{ $event['date'] }}
                                        </div>
                                        <div style="font-size:.75rem;color:rgba(15,23,42,.5);">{{ $event['time'] }}</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-2 mb-2"
                                    style="font-size:.82rem;color:rgba(15,23,42,.6);">
                                    <i class="bi bi-geo-alt mt-1" style="flex-shrink:0;color:var(--wc-green);"></i>
                                    <span>{{ $event['location'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-3"
                                    style="font-size:.82rem;color:rgba(15,23,42,.6);">
                                    <i class="bi bi-person-badge" style="color:var(--wc-green);"></i>
                                    <span>{{ $event['speaker'] }}</span>
                                </div>

                                @if ($event['seats'] > 0)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1"
                                            style="font-size:.75rem;font-weight:600;">
                                            <span style="color:rgba(15,23,42,.5);">Kursi Terisi</span>
                                            <span
                                                style="color:var(--wc-green);">{{ $event['registered'] }}/{{ $event['seats'] }}</span>
                                        </div>
                                        <div class="seats-bar">
                                            <div class="seats-bar-fill"
                                                style="width:{{ round(($event['registered'] / $event['seats']) * 100) }}%;">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3" style="font-size:.78rem;color:rgba(15,23,42,.45);"><i
                                            class="bi bi-infinity me-1"></i>Terbuka untuk semua</div>
                                @endif

                                <a href="{{ route('auth.register') }}" class="btn btn-wc-primary w-100 mt-auto"
                                    style="font-size:.85rem;padding:.65rem;">
                                    <i class="bi bi-calendar-plus me-2"></i>Daftar Event
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PAST EVENTS --}}
    <section class="wc-section" style="background:#f8fafc;padding-top:0;">
        <div class="container">
            <div class="mb-4 fade-up">
                <div class="wc-label mb-1"><i class="bi bi-archive-fill"></i> Arsip</div>
                <h2 class="wc-section-title" style="font-size:1.75rem;">Event yang Telah Berlalu</h2>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach ($past as $event)
                    <div class="past-event-row fade-up" style="transition-delay:{{ $loop->index * 0.06 }}s">
                        <div class="past-event-icon"><i class="bi bi-calendar-check"></i></div>
                        <div style="flex:1;">
                            <div style="font-size:.9rem;font-weight:700;color:#0f172a;">{{ $event['title'] }}</div>
                            <div class="d-flex align-items-center gap-3 mt-1"
                                style="font-size:.78rem;color:rgba(15,23,42,.5);">
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $event['date'] }}</span>
                                <span><i class="bi bi-camera-video me-1"></i>{{ $event['type'] }}</span>
                                <span><i class="bi bi-people me-1"></i>{{ number_format($event['participants']) }}
                                    peserta</span>
                            </div>
                        </div>
                        <div
                            style="background:#f1f5f9;border-radius:8px;padding:.3rem .75rem;font-size:.75rem;font-weight:600;color:rgba(15,23,42,.5);white-space:nowrap;">
                            Selesai</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section style="background:linear-gradient(135deg,#10b981,#0d9488);padding:72px 0;">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7 fade-up">
                    <div class="wc-label" style="background:rgba(16,185,129,.15);color:#34d399;border:none;"><i
                            class="bi bi-bell-fill"></i> Notifikasi Event</div>
                    <h2
                        style="font-size:clamp(1.5rem,3.5vw,2.25rem);font-weight:900;color:#fff;letter-spacing:-.03em;margin-top:.5rem;">
                        Jangan Lewatkan Event Berikutnya!</h2>
                    <p style="color:rgba(255,255,255,.6);font-size:.95rem;margin-top:.5rem;">Daftar sekarang dan dapatkan
                        notifikasi untuk setiap event WONCare yang akan datang.</p>
                </div>
                <div class="col-lg-5 fade-up text-lg-end" style="transition-delay:.1s">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="{{ route('auth.register') }}" class="btn"
                            style="background:#10b981;color:#fff;font-weight:700;border-radius:12px;padding:.8rem 2rem;font-size:1rem;border:none;">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('landing.contact') }}" class="btn"
                            style="background:transparent;color:#fff;font-weight:700;border-radius:12px;border:2px solid rgba(255,255,255,.3);padding:.75rem 2rem;font-size:1rem;">
                            <i class="bi bi-envelope me-2"></i>Tanya Panitia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
