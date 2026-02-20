@extends('layouts.landing')

@section('title', $article['title'])

@push('styles')
<style>
.blog-detail-hero { background:linear-gradient(135deg,#0f172a,#1e293b); padding:80px 0 60px; }
.article-content { font-size:1.05rem; line-height:1.9; color:rgba(15,23,42,.75); }
.article-content h4 { font-size:1.25rem; font-weight:800; color:#0f172a; margin:2rem 0 .75rem; }
.article-content p { margin-bottom:1.25rem; }
.article-content strong { color:#0f172a; }
.article-content ul, .article-content ol { padding-left:1.5rem; margin-bottom:1.25rem; }
.article-content li { margin-bottom:.5rem; }
.share-btn { display:inline-flex; align-items:center; gap:.5rem; padding:.5rem 1.1rem; border-radius:10px; font-size:.82rem; font-weight:600; border:1.5px solid rgba(15,23,42,.1); background:#fff; color:rgba(15,23,42,.65); text-decoration:none; transition:all .15s; }
.share-btn:hover { background:#f1f5f9; color:#0f172a; }
.related-card { border:1px solid rgba(15,23,42,.07); border-radius:16px; overflow:hidden; background:#fff; transition:all .2s; }
.related-card:hover { box-shadow:0 8px 28px rgba(15,23,42,.09); transform:translateY(-3px); }
.related-img { height:140px; background:linear-gradient(135deg,#e2e8f0,#cbd5e1); display:flex; align-items:center; justify-content:center; }
.cat-badge { display:inline-block; padding:.2rem .65rem; border-radius:999px; font-size:.72rem; font-weight:700; }
.cat-badge.success { background:#d1fae5; color:#059669; }
.cat-badge.warning { background:#fef3c7; color:#d97706; }
.cat-badge.info { background:#dbeafe; color:#2563eb; }
.cat-badge.primary { background:#ede9fe; color:#7c3aed; }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="blog-detail-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb justify-content-center" style="font-size:.82rem;">
                        <li class="breadcrumb-item"><a href="{{ route('landing.home') }}" style="color:rgba(255,255,255,.5);text-decoration:none;">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('landing.blog') }}" style="color:rgba(255,255,255,.5);text-decoration:none;">Blog</a></li>
                        <li class="breadcrumb-item active" style="color:rgba(255,255,255,.35);">Artikel</li>
                    </ol>
                </nav>
                <span class="cat-badge {{ $article['cat_color'] }} mb-3 d-inline-block">{{ $article['category'] }}</span>
                <h1 style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:900;color:#fff;letter-spacing:-.03em;line-height:1.25;">{{ $article['title'] }}</h1>
                <div class="d-flex align-items-center justify-content-center gap-3 mt-3 flex-wrap" style="font-size:.82rem;color:rgba(255,255,255,.5);">
                    <span><i class="bi bi-person me-1"></i>{{ $article['author'] }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $article['date'] }}</span>
                    <span><i class="bi bi-clock me-1"></i>{{ $article['read_time'] }} baca</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="wc-section">
    <div class="container">
        <div class="row justify-content-center g-5">

            {{-- Main Article --}}
            <div class="col-lg-8">
                {{-- Article Image Placeholder --}}
                <div style="height:360px;background:linear-gradient(135deg,#e2e8f0,#cbd5e1);border-radius:20px;display:flex;align-items:center;justify-content:center;margin-bottom:2.5rem;" class="fade-up">
                    <i class="bi bi-journal-richtext" style="font-size:4rem;color:rgba(15,23,42,.15);"></i>
                </div>

                {{-- Content --}}
                <div class="article-content fade-up">
                    {!! $article['content'] !!}
                </div>

                {{-- Tags --}}
                <div class="d-flex flex-wrap gap-2 mt-4 pt-4 fade-up" style="border-top:1px solid rgba(15,23,42,.07);">
                    <span style="font-size:.82rem;font-weight:600;color:rgba(15,23,42,.5);">Tag:</span>
                    @foreach(['Keuangan', 'Perencanaan', 'Keluarga', 'Tips'] as $tag)
                    <a href="#" style="padding:.3rem .85rem;border-radius:999px;background:#f1f5f9;font-size:.78rem;font-weight:600;color:rgba(15,23,42,.6);text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#d1fae5';this.style.color='#059669'" onmouseout="this.style.background='#f1f5f9';this.style.color='rgba(15,23,42,.6)'">{{ $tag }}</a>
                    @endforeach
                </div>

                {{-- Share --}}
                <div class="mt-4 pt-4 fade-up" style="border-top:1px solid rgba(15,23,42,.07);">
                    <p style="font-size:.85rem;font-weight:700;color:rgba(15,23,42,.5);margin-bottom:.75rem;">Bagikan Artikel:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="share-btn"><i class="bi bi-whatsapp" style="color:#25d366;"></i>WhatsApp</a>
                        <a href="#" class="share-btn"><i class="bi bi-facebook" style="color:#1877f2;"></i>Facebook</a>
                        <a href="#" class="share-btn"><i class="bi bi-twitter-x"></i>Twitter</a>
                        <a href="#" class="share-btn"><i class="bi bi-link-45deg"></i>Salin Link</a>
                    </div>
                </div>

                {{-- Author Box --}}
                <div class="mt-5 fade-up" style="background:#f8fafc;border-radius:20px;padding:1.75rem;border:1px solid rgba(15,23,42,.07);">
                    <div class="d-flex align-items-center gap-4">
                        <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#10b981,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.4rem;flex-shrink:0;">{{ substr($article['author'],0,1) }}</div>
                        <div>
                            <div style="font-weight:800;font-size:1rem;">{{ $article['author'] }}</div>
                            <div style="font-size:.82rem;color:rgba(15,23,42,.5);margin-top:.2rem;">Tim Konten WONCare – Berfokus pada edukasi keuangan dan pemberdayaan masyarakat.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- CTA Box --}}
                <div style="background:linear-gradient(135deg,#10b981,#0d9488);border-radius:20px;padding:1.75rem;margin-bottom:1.5rem;" class="fade-up">
                    <i class="bi bi-rocket-takeoff-fill" style="font-size:2rem;color:rgba(255,255,255,.6);margin-bottom:.75rem;display:block;"></i>
                    <h5 style="color:#fff;font-weight:800;margin-bottom:.5rem;">Mulai Perjalanan Finansial Anda</h5>
                    <p style="color:rgba(255,255,255,.75);font-size:.85rem;line-height:1.65;margin-bottom:1rem;">Daftar WONCare gratis dan akses ratusan konten edukasi keuangan.</p>
                    <a href="{{ route('auth.register') }}" class="btn w-100" style="background:#fff;color:var(--wc-green);font-weight:700;border-radius:10px;font-size:.9rem;">Daftar Gratis</a>
                </div>

                {{-- Categories --}}
                <div style="border:1px solid rgba(15,23,42,.07);border-radius:20px;padding:1.5rem;background:#fff;margin-bottom:1.5rem;" class="fade-up">
                    <h6 style="font-weight:800;margin-bottom:1rem;">Kategori</h6>
                    @foreach(['Keuangan' => ['count'=>12,'color'=>'success'], 'Spiritual' => ['count'=>8,'color'=>'warning'], 'Sosial' => ['count'=>10,'color'=>'info'], 'Kegiatan' => ['count'=>6,'color'=>'primary']] as $cat => $data)
                    <a href="{{ route('landing.blog') }}" class="d-flex align-items-center justify-content-between py-2" style="text-decoration:none;border-bottom:1px solid rgba(15,23,42,.05);">
                        <span style="font-size:.875rem;font-weight:600;color:rgba(15,23,42,.7);">{{ $cat }}</span>
                        <span class="cat-badge {{ $data['color'] }}">{{ $data['count'] }}</span>
                    </a>
                    @endforeach
                </div>

                {{-- Recent Articles --}}
                <div style="border:1px solid rgba(15,23,42,.07);border-radius:20px;padding:1.5rem;background:#fff;" class="fade-up">
                    <h6 style="font-weight:800;margin-bottom:1rem;">Artikel Terbaru</h6>
                    @foreach($related as $rel)
                    <a href="{{ route('landing.blog.detail', $rel['id']) }}" class="d-flex gap-3 mb-3 pb-3" style="text-decoration:none;border-bottom:1px solid rgba(15,23,42,.05);">
                        <div style="width:56px;height:56px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-journal-text" style="color:rgba(15,23,42,.3);"></i></div>
                        <div>
                            <div style="font-size:.82rem;font-weight:700;color:#0f172a;line-height:1.4;margin-bottom:.25rem;">{{ $rel['title'] }}</div>
                            <div style="font-size:.75rem;color:rgba(15,23,42,.45);">{{ $rel['date'] }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Related Articles --}}
        <div class="mt-5 pt-4 fade-up" style="border-top:1px solid rgba(15,23,42,.07);">
            <h4 style="font-weight:800;margin-bottom:1.5rem;">Artikel Terkait</h4>
            <div class="row g-4">
                @foreach($related as $rel)
                <div class="col-md-6 fade-up">
                    <div class="related-card">
                        <div class="related-img"><i class="bi bi-journal-text" style="font-size:2rem;color:rgba(15,23,42,.15);"></i></div>
                        <div style="padding:1.25rem;">
                            <span class="cat-badge {{ $rel['cat_color'] }} mb-2 d-inline-block">{{ $rel['category'] }}</span>
                            <h6 style="font-weight:700;line-height:1.5;margin-bottom:.5rem;">{{ $rel['title'] }}</h6>
                            <div style="font-size:.78rem;color:rgba(15,23,42,.45);">{{ $rel['date'] }}</div>
                            <a href="{{ route('landing.blog.detail', $rel['id']) }}" class="d-inline-flex align-items-center gap-1 mt-2" style="font-size:.82rem;font-weight:700;color:var(--wc-green);text-decoration:none;">
                                Baca <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
