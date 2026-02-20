@extends('layouts.landing')

@section('title', 'Kontak & Bantuan')

@push('styles')
    <style>
        .contact-hero {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0f9ff 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, .12) 0%, transparent 70%);
            pointer-events: none;
        }

        .contact-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            padding: 2rem;
            background: #fff;
            transition: all .2s;
        }

        .contact-card:hover {
            box-shadow: 0 8px 32px rgba(15, 23, 42, .08);
            transform: translateY(-3px);
        }

        .contact-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .faq-item {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: .75rem;
            background: #fff;
            transition: all .2s;
        }

        .faq-item:hover {
            border-color: rgba(16, 185, 129, .2);
        }

        .faq-question {
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            font-weight: 700;
            font-size: .95rem;
            color: #0f172a;
            user-select: none;
        }

        .faq-question .faq-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .2s;
            font-size: .85rem;
            color: rgba(15, 23, 42, .5);
        }

        .faq-item.open .faq-question .faq-icon {
            background: var(--wc-green-light);
            color: var(--wc-green);
            transform: rotate(45deg);
        }

        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease, padding .3s ease;
            font-size: .9rem;
            color: rgba(15, 23, 42, .65);
            line-height: 1.75;
        }

        .faq-item.open .faq-answer {
            max-height: 300px;
            padding-bottom: 1.25rem;
        }

        .form-control-wc {
            border: 1.5px solid rgba(15, 23, 42, .1);
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .9rem;
            transition: all .15s;
        }

        .form-control-wc:focus {
            border-color: var(--wc-green);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, .12);
            outline: none;
        }

        .form-label-wc {
            font-size: .85rem;
            font-weight: 700;
            color: rgba(15, 23, 42, .7);
            margin-bottom: .4rem;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="contact-hero">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="wc-label"><i class="bi bi-headset"></i> Kontak & Bantuan</div>
                    <h1
                        style="font-size:clamp(2rem,5vw,3rem);font-weight:900;color:#0f172a;letter-spacing:-.04em;line-height:1.15;margin-top:.75rem;">
                        Ada Pertanyaan?<br>Kami Siap Membantu!
                    </h1>
                    <p style="color:rgba(15,23,42,.6);font-size:1rem;line-height:1.75;margin-top:1rem;max-width:460px;">
                        Tim WONCare siap membantu Anda Senin–Jumat, 08:00–17:00 WIB. Hubungi kami melalui berbagai saluran
                        yang tersedia.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        @php $channels = [['icon' => 'bi-whatsapp', 'color' => '#25d366', 'bg' => 'rgba(37,211,102,.15)', 'title' => 'WhatsApp', 'value' => '+62 812-3456-7890', 'sub' => 'Respon cepat', 'href' => 'https://wa.me/6281234567890'], ['icon' => 'bi-envelope-fill', 'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,.15)', 'title' => 'Email', 'value' => 'support@woncare.id', 'sub' => 'Respon 1x24 jam', 'href' => 'mailto:support@woncare.id'], ['icon' => 'bi-instagram', 'color' => '#e1306c', 'bg' => 'rgba(225,48,108,.15)', 'title' => 'Instagram', 'value' => '@woncare.id', 'sub' => 'DM kami', 'href' => '#'], ['icon' => 'bi-geo-alt-fill', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,.15)', 'title' => 'Kantor', 'value' => 'Jakarta, Indonesia', 'sub' => 'Kunjungi kami', 'href' => '#']]; @endphp
                        @foreach ($channels as $ch)
                            <div class="col-6">
                                <a href="{{ $ch['href'] }}"
                                    style="display:block;background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:16px;padding:1.25rem;text-decoration:none;transition:all .2s;box-shadow:0 4px 16px rgba(15,23,42,.06);"
                                    onmouseover="this.style.boxShadow='0 8px 24px rgba(16,185,129,.15)';this.style.borderColor='rgba(16,185,129,.3)'"
                                    onmouseout="this.style.boxShadow='0 4px 16px rgba(15,23,42,.06)';this.style.borderColor='rgba(15,23,42,.08)'">
                                    <div
                                        style="width:40px;height:40px;border-radius:12px;background:{{ $ch['bg'] }};display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:{{ $ch['color'] }};margin-bottom:.75rem;">
                                        <i class="bi {{ $ch['icon'] }}"></i></div>
                                    <div
                                        style="font-size:.8rem;font-weight:700;color:rgba(15,23,42,.45);margin-bottom:.2rem;">
                                        {{ $ch['title'] }}</div>
                                    <div style="font-size:.85rem;font-weight:700;color:#0f172a;">{{ $ch['value'] }}</div>
                                    <div style="font-size:.75rem;color:rgba(15,23,42,.45);margin-top:.15rem;">
                                        {{ $ch['sub'] }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT FORM + FAQ --}}
    <section class="wc-section" style="background:#f8fafc;">
        <div class="container">
            <div class="row g-5">

                {{-- Contact Form --}}
                <div class="col-lg-6 fade-up">
                    <div class="wc-label mb-2"><i class="bi bi-send-fill"></i> Kirim Pesan</div>
                    <h2 class="wc-section-title" style="font-size:1.75rem;">Hubungi Tim Kami</h2>
                    <p style="color:rgba(15,23,42,.6);font-size:.9rem;margin-top:.5rem;margin-bottom:1.5rem;">Isi formulir
                        di bawah dan tim kami akan menghubungi Anda dalam 1x24 jam.</p>

                    <form>
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label-wc">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                                <input type="text" class="form-control form-control-wc" placeholder="Nama Anda" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label-wc">Email <span style="color:#ef4444;">*</span></label>
                                <input type="email" class="form-control form-control-wc" placeholder="email@anda.com"
                                    required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-wc">Nomor WhatsApp</label>
                                <input type="tel" class="form-control form-control-wc" placeholder="+62 8xx-xxxx-xxxx">
                            </div>
                            <div class="col-12">
                                <label class="form-label-wc">Topik <span style="color:#ef4444;">*</span></label>
                                <select class="form-control form-control-wc" required>
                                    <option value="">-- Pilih Topik --</option>
                                    <option>Pertanyaan Umum</option>
                                    <option>E-Course & Pembelajaran</option>
                                    <option>Donasi & Program Sosial</option>
                                    <option>Keanggotaan & Akun</option>
                                    <option>Kemitraan & Kolaborasi</option>
                                    <option>Teknis & Bug</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-wc">Pesan <span style="color:#ef4444;">*</span></label>
                                <textarea class="form-control form-control-wc" rows="5"
                                    placeholder="Tuliskan pertanyaan atau pesan Anda di sini..." required style="resize:none;"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-wc-primary w-100">
                                    <i class="bi bi-send me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- WhatsApp CTA --}}
                    <div
                        style="background:#f0fdf4;border:1px solid rgba(16,185,129,.2);border-radius:16px;padding:1.25rem;margin-top:1.5rem;display:flex;align-items:center;gap:1rem;">
                        <div
                            style="width:48px;height:48px;border-radius:14px;background:#d1fae5;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#25d366;flex-shrink:0;">
                            <i class="bi bi-whatsapp"></i></div>
                        <div style="flex:1;">
                            <div style="font-size:.875rem;font-weight:700;color:#0f172a;">Butuh Respon Cepat?</div>
                            <div style="font-size:.8rem;color:rgba(15,23,42,.55);margin-top:.15rem;">Chat langsung via
                                WhatsApp untuk respon lebih cepat.</div>
                        </div>
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-sm"
                            style="background:#25d366;color:#fff;border-radius:10px;font-weight:700;font-size:.82rem;white-space:nowrap;border:none;padding:.5rem 1rem;">
                            <i class="bi bi-whatsapp me-1"></i>Chat WA
                        </a>
                    </div>
                </div>

                {{-- FAQ --}}
                <div class="col-lg-6 fade-up" style="transition-delay:.1s">
                    <div class="wc-label mb-2"><i class="bi bi-question-circle-fill"></i> FAQ</div>
                    <h2 class="wc-section-title" style="font-size:1.75rem;">Pertanyaan yang Sering Ditanyakan</h2>
                    <p style="color:rgba(15,23,42,.6);font-size:.9rem;margin-top:.5rem;margin-bottom:1.5rem;">Temukan
                        jawaban untuk pertanyaan umum seputar WONCare.</p>

                    <div id="faqContainer">
                        @foreach ($faqs as $i => $faq)
                            <div class="faq-item {{ $i === 0 ? 'open' : '' }}" data-index="{{ $i }}">
                                <div class="faq-question">
                                    <span>{{ $faq['q'] }}</span>
                                    <div class="faq-icon"><i class="bi bi-plus"></i></div>
                                </div>
                                <div class="faq-answer">{{ $faq['a'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        style="background:#f8fafc;border-radius:16px;padding:1.25rem;margin-top:1.5rem;border:1px solid rgba(15,23,42,.07);">
                        <p style="font-size:.875rem;color:rgba(15,23,42,.6);margin:0;">
                            <i class="bi bi-lightbulb-fill me-2" style="color:#f59e0b;"></i>
                            Tidak menemukan jawaban yang Anda cari? <a href="#"
                                style="color:var(--wc-green);font-weight:700;text-decoration:none;">Kirim pertanyaan</a> ke
                            tim kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- OFFICE INFO --}}
    <section class="wc-section-sm" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-4 fade-up">
                <div class="wc-label"><i class="bi bi-building-fill"></i> Kantor Kami</div>
                <h2 class="wc-section-title" style="font-size:1.75rem;">Kunjungi WONCare</h2>
            </div>
            <div class="row g-4 justify-content-center">
                @php $offices = [['city' => 'Jakarta (Pusat)', 'address' => 'Jl. Sudirman No. 123, Karet Tengsin, Jakarta Pusat 10220', 'hours' => 'Senin–Jumat, 08:00–17:00 WIB', 'phone' => '+62 21-1234-5678', 'icon' => 'bi-building', 'color' => '#10b981', 'bg' => '#d1fae5'], ['city' => 'Surabaya', 'address' => 'Jl. Pemuda No. 45, Genteng, Surabaya 60271', 'hours' => 'Senin–Jumat, 08:00–17:00 WIB', 'phone' => '+62 31-8765-4321', 'icon' => 'bi-building', 'color' => '#3b82f6', 'bg' => '#dbeafe'], ['city' => 'Seoul, Korea', 'address' => 'Gangnam-gu, Seoul, South Korea', 'hours' => 'Senin–Jumat, 09:00–18:00 KST', 'phone' => '+82 2-1234-5678', 'icon' => 'bi-globe', 'color' => '#7c3aed', 'bg' => '#ede9fe']]; @endphp
                @foreach ($offices as $office)
                    <div class="col-md-4 fade-up" style="transition-delay:{{ $loop->index * 0.07 }}s">
                        <div class="contact-card">
                            <div class="contact-icon"
                                style="background:{{ $office['bg'] }};color:{{ $office['color'] }};"><i
                                    class="bi {{ $office['icon'] }}"></i></div>
                            <h5 style="font-weight:800;font-size:1rem;margin-bottom:.75rem;">{{ $office['city'] }}</h5>
                            <div class="d-flex flex-column gap-2" style="font-size:.85rem;color:rgba(15,23,42,.6);">
                                <div class="d-flex gap-2"><i class="bi bi-geo-alt mt-1"
                                        style="color:{{ $office['color'] }};flex-shrink:0;"></i><span>{{ $office['address'] }}</span>
                                </div>
                                <div class="d-flex gap-2"><i class="bi bi-clock"
                                        style="color:{{ $office['color'] }};flex-shrink:0;"></i><span>{{ $office['hours'] }}</span>
                                </div>
                                <div class="d-flex gap-2"><i class="bi bi-telephone"
                                        style="color:{{ $office['color'] }};flex-shrink:0;"></i><span>{{ $office['phone'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SOCIAL MEDIA --}}
    <section class="wc-section-sm" style="background:#f8fafc;">
        <div class="container">
            <div class="text-center fade-up">
                <div class="wc-label"><i class="bi bi-share-fill"></i> Media Sosial</div>
                <h2 class="wc-section-title" style="font-size:1.75rem;">Ikuti WONCare di Media Sosial</h2>
                <p class="wc-section-subtitle mt-2">Dapatkan update terbaru, tips keuangan, dan inspirasi sosial setiap
                    hari.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    @php $socials = [['icon' => 'bi-instagram', 'label' => 'Instagram', 'handle' => '@woncare.id', 'color' => '#e1306c', 'bg' => '#fce7f3'], ['icon' => 'bi-facebook', 'label' => 'Facebook', 'handle' => 'WONCare Indonesia', 'color' => '#1877f2', 'bg' => '#dbeafe'], ['icon' => 'bi-youtube', 'label' => 'YouTube', 'handle' => 'WONCare Channel', 'color' => '#ff0000', 'bg' => '#fee2e2'], ['icon' => 'bi-twitter-x', 'label' => 'Twitter/X', 'handle' => '@woncare_id', 'color' => '#0f172a', 'bg' => '#f1f5f9'], ['icon' => 'bi-whatsapp', 'label' => 'WhatsApp', 'handle' => 'Grup Komunitas', 'color' => '#25d366', 'bg' => '#d1fae5']]; @endphp
                    @foreach ($socials as $s)
                        <a href="#"
                            style="display:flex;align-items:center;gap:.75rem;background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:14px;padding:.75rem 1.25rem;text-decoration:none;transition:all .2s;"
                            onmouseover="this.style.borderColor='{{ $s['color'] }}40';this.style.boxShadow='0 4px 16px {{ $s['color'] }}20'"
                            onmouseout="this.style.borderColor='rgba(15,23,42,.08)';this.style.boxShadow='none'">
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:{{ $s['bg'] }};color:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;font-size:1rem;">
                                <i class="bi {{ $s['icon'] }}"></i></div>
                            <div>
                                <div style="font-size:.8rem;font-weight:700;color:#0f172a;">{{ $s['label'] }}</div>
                                <div style="font-size:.75rem;color:rgba(15,23,42,.5);">{{ $s['handle'] }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            item.querySelector('.faq-question').addEventListener('click', function() {
                const isOpen = item.classList.contains('open');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
                if (!isOpen) item.classList.add('open');
            });
        });
    </script>
@endpush
