@extends('layouts.landing')

@section('title', 'Blog & News')

@push('styles')
    <style>
        .blog-hero {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            padding: 80px 0 60px;
        }

        .article-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            transition: all .25s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            box-shadow: 0 12px 40px rgba(15, 23, 42, .1);
            transform: translateY(-4px);
        }

        .article-card-img {
            height: 200px;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .article-card-img .img-icon {
            font-size: 3rem;
            color: rgba(15, 23, 42, .15);
        }

        .article-card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .article-card-body h5 {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.5;
            margin-bottom: .6rem;
        }

        .article-card-body p {
            font-size: .85rem;
            color: rgba(15, 23, 42, .58);
            line-height: 1.7;
            flex: 1;
        }

        .article-meta {
            font-size: .78rem;
            color: rgba(15, 23, 42, .45);
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .cat-badge {
            display: inline-block;
            padding: .2rem .65rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
        }

        .cat-badge.success {
            background: #d1fae5;
            color: #059669;
        }

        .cat-badge.warning {
            background: #fef3c7;
            color: #d97706;
        }

        .cat-badge.info {
            background: #dbeafe;
            color: #2563eb;
        }

        .cat-badge.primary {
            background: #ede9fe;
            color: #7c3aed;
        }

        .filter-btn {
            padding: .4rem 1rem;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 600;
            border: 1.5px solid rgba(15, 23, 42, .1);
            background: #fff;
            color: rgba(15, 23, 42, .6);
            cursor: pointer;
            transition: all .15s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--wc-green);
            border-color: var(--wc-green);
            color: #fff;
        }

        .featured-card {
            border: 1px solid rgba(15, 23, 42, .07);
            border-radius: 24px;
            overflow: hidden;
            background: #fff;
            transition: all .25s;
        }

        .featured-card:hover {
            box-shadow: 0 16px 48px rgba(15, 23, 42, .1);
            transform: translateY(-4px);
        }

        .featured-img {
            height: 320px;
            background: linear-gradient(135deg, #10b981, #0d9488);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="blog-hero">
        <div class="container">
            <div class="text-center fade-up">
                <div class="wc-label"><i class="bi bi-newspaper"></i> Blog & News</div>
                <h1 class="wc-section-title mt-2">Artikel, Edukasi & Berita<br>Terkini WONCare</h1>
                <p class="wc-section-subtitle mt-3">Temukan artikel edukatif tentang keuangan, spiritual, sosial, dan update
                    terbaru kegiatan WONCare.</p>
            </div>

            {{-- Search --}}
            <div class="row justify-content-center mt-4 fade-up">
                <div class="col-md-6">
                    <div class="input-group"
                        style="border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(15,23,42,.08);">
                        <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-0 py-3" placeholder="Cari artikel..."
                            style="font-size:.9rem;">
                        <button class="btn btn-wc-primary px-4 border-0" style="border-radius:0 14px 14px 0;">Cari</button>
                    </div>
                </div>
            </div>

            {{-- Category Filters --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4 fade-up">
                @foreach ($categories as $cat)
                    <button class="filter-btn {{ $loop->first ? 'active' : '' }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURED ARTICLE --}}
    <section class="wc-section-sm" style="background:#fff;">
        <div class="container">
            <div class="wc-label mb-3 fade-up"><i class="bi bi-star-fill"></i> Artikel Pilihan</div>
            <div class="featured-card fade-up">
                <div class="row g-0">
                    <div class="col-lg-5">
                        <div class="featured-img h-100" style="min-height:280px;">
                            <div style="text-align:center;">
                                <i class="bi bi-journal-richtext"
                                    style="font-size:4rem;color:rgba(255,255,255,.2);display:block;margin-bottom:.5rem;"></i>
                                <span style="color:rgba(255,255,255,.4);font-size:.8rem;">Artikel Pilihan</span>
                            </div>
                            <div style="position:absolute;top:1rem;left:1rem;">
                                <span class="cat-badge success">Keuangan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div style="padding:2.5rem;">
                            <div class="article-meta mb-2">
                                <span><i class="bi bi-person me-1"></i>Tim WONCare</span>
                                <span><i class="bi bi-calendar3 me-1"></i>15 Februari 2026</span>
                                <span><i class="bi bi-clock me-1"></i>5 menit baca</span>
                            </div>
                            <h2 style="font-size:1.5rem;font-weight:800;line-height:1.4;margin-bottom:1rem;">Cara Mengelola
                                Keuangan Keluarga dengan Metode 50/30/20</h2>
                            <p style="font-size:.95rem;color:rgba(15,23,42,.6);line-height:1.75;margin-bottom:1.5rem;">
                                Metode 50/30/20 adalah cara sederhana membagi penghasilan untuk kebutuhan, keinginan, dan
                                tabungan. Pelajari cara menerapkannya dalam kehidupan sehari-hari untuk mencapai kebebasan
                                finansial.</p>
                            <a href="{{ route('landing.blog.detail', 1) }}" class="btn btn-wc-primary">
                                <i class="bi bi-book me-2"></i>Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ALL ARTICLES --}}
    <section class="wc-section" style="background:#f8fafc;padding-top:0;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4 fade-up">
                <h4 style="font-weight:800;margin:0;">Semua Artikel</h4>
                <span style="font-size:.85rem;color:rgba(15,23,42,.5);">{{ count($articles) }} artikel</span>
            </div>
            <div class="row g-4">
                @foreach ($articles as $article)
                    <div class="col-sm-6 col-lg-4 fade-up" style="transition-delay:{{ $loop->index * 0.06 }}s">
                        <div class="article-card">
                            <div class="article-card-img">
                                <i class="bi bi-journal-text img-icon"></i>
                                <div style="position:absolute;top:1rem;left:1rem;">
                                    <span class="cat-badge {{ $article['cat_color'] }}">{{ $article['category'] }}</span>
                                </div>
                            </div>
                            <div class="article-card-body">
                                <div class="article-meta mb-2">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $article['date'] }}</span>
                                    <span><i class="bi bi-clock me-1"></i>{{ $article['read_time'] }}</span>
                                </div>
                                <h5>{{ $article['title'] }}</h5>
                                <p>{{ $article['excerpt'] }}</p>
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3"
                                    style="border-top:1px solid rgba(15,23,42,.06);">
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                            style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#10b981,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:700;">
                                            {{ substr($article['author'], 0, 1) }}</div>
                                        <span
                                            style="font-size:.78rem;font-weight:600;color:rgba(15,23,42,.6);">{{ $article['author'] }}</span>
                                    </div>
                                    <a href="{{ route('landing.blog.detail', $article['id']) }}"
                                        style="font-size:.82rem;font-weight:700;color:var(--wc-green);text-decoration:none;display:flex;align-items:center;gap:.3rem;">
                                        Baca <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Load More --}}
            <div class="text-center mt-5 fade-up">
                <button class="btn btn-wc-outline"><i class="bi bi-arrow-down me-2"></i>Muat Lebih Banyak</button>
            </div>
        </div>
    </section>

    {{-- NEWSLETTER --}}
    <section class="wc-section-sm" style="background:#fff;">
        <div class="container">
            <div style="background:linear-gradient(135deg,#10b981,#0d9488);border-radius:24px;padding:3rem;text-align:center;"
                class="fade-up">
                <div class="wc-label" style="background:rgba(255,255,255,.2);color:#fff;border:none;margin-bottom:1rem;"><i
                        class="bi bi-envelope-fill"></i> Newsletter</div>
                <h3 style="color:#fff;font-weight:800;font-size:1.75rem;letter-spacing:-.03em;">Dapatkan Artikel Terbaru di
                    Inbox Anda</h3>
                <p style="color:rgba(255,255,255,.6);margin-top:.5rem;font-size:.95rem;">Daftar newsletter WONCare dan
                    jangan lewatkan satu pun artikel edukatif kami.</p>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-5">
                        <div class="input-group" style="border-radius:12px;overflow:hidden;">
                            <input type="email" class="form-control border-0 py-3" placeholder="Masukkan email Anda..."
                                style="font-size:.9rem;">
                            <button class="btn btn-wc-primary border-0 px-4">Langganan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endpush
