@extends('partials.master')

@section('title', 'GROZA | Beranda')

@section('content')
<!-- Landing Carousel Start -->
<div id="carouselExampleControls" class="carousel slide" data-mdb-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach($heroImages as $index => $hero)
            <button type="button" data-mdb-target="#carouselExampleControls"
                    data-mdb-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}"
                    aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index+1 }}">
            </button>
        @endforeach
    </div>

    <!-- Carousel Items -->
    <div class="carousel-inner">
        @foreach($heroImages as $index => $hero)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset($hero->src) }}"
                     loading="lazy"
                     class="d-block w-100"
                     alt="{{ $hero->alt ?? 'Hero Image ' . ($index+1) }}">
            </div>
        @endforeach
    </div>
</div>
<!-- Landing Carousel End -->


<!-- Products Start -->
<p class="section-title">PRODUCTS</p>
<div class="swiper-container">
    <div class="swiper-wrapper">

        <!-- Aksesoris -->
        <div class="swiper-slide">
            <a href="{{ route('product.categories', ['categorySlug' => 'aksesoris']) }}">
                <img src="{{ asset('img/Produk-Kategori-Aksesori.png') }}" 
                     loading="lazy" 
                     alt="Aksesoris Groza">
            </a>
        </div>

        <!-- Pengereman -->
        <div class="swiper-slide">
            <a href="{{ route('product.categories', ['categorySlug' => 'pengereman']) }}">
                <img src="{{ asset('img/Produk-Kategori-Sistem-Pengereman.png') }}" 
                     loading="lazy" 
                     alt="Pengereman Groza">
            </a>
        </div>

        <!-- Suspensi -->
        <div class="swiper-slide">
            <a href="{{ route('product.categories', ['categorySlug' => 'suspensi']) }}">
                <img src="{{ asset('img/Produk-Kategori-Suspensi.png') }}" 
                     loading="lazy" 
                     alt="Suspensi Groza">
            </a>
        </div>

    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<!-- Products End -->


<!-- Benefits Start -->
<p class="section-title">KEUNGGULAN</p>    
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-trophy fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Kualitas Terbaik, <br> Untuk Kendaraan Bermotor</h5>
                    <p class="para">Setiap produk Groza, dari shockbreaker hingga disc brake, dibuat dengan standar kualitas tinggi. Tahan lama, bertenaga, dan selalu bisa diandalkan.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-star fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Teknologi Terbaru, dan Inovatif</h5>
                    <p class="para">Groza selalu menghadirkan produk dengan teknologi canggih, seperti kaliper dan master rem terbaru, untuk memastikan kenyamanan dan keselamatan Anda saat berkendara.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-tasks fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Pilihan Aksesori Lengkap</h5>
                    <p class="para">Mulai dari selang rem hingga handgrip, Groza menyediakan berbagai Aksesori berkualitas untuk meningkatkan performa motor. Tak perlu bingung, semua kebutuhan motor ada di sini!</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-feather fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Desain Stylish dan Ergonomis</h5>
                    <p class="para">Selain berfungsi dengan baik, produk Groza juga memiliki desain yang keren dan nyaman digunakan. Handgrip dan komponen lainnya punya tampilan yang stylish, memberi kesan sporty pada kendaraan motor Anda.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-hand-holding-heart fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Dukungan Purna Jual Terbaik</h5>
                    <p class="para">Nikmati layanan purna jual yang terpercaya dengan garansi resmi 6 bulan. Groza selalu siap memberikan dukungan penuh untuk memastikan pengalaman belanja Anda berjalan lancar.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 wow fadeInDown">
            <div class="cardben">
                <div class="content">
                    <div class="card-icon mx-auto">
                        <i class="fas fa-medal fa-lg"></i>
                    </div>
                    <h5 class="heading" style="color: #ff6600;">Harga Terjangkau dengan Kualitas Premium</h5>
                    <p class="para">Groza memberikan produk berkualitas tinggi dengan harga yang bersaing. Anda nggak perlu khawatir soal harga, karena kualitas tetap jadi prioritas utama Groza!</p>
                </div>
            </div>
        </div> 
    </div>
</div>
<!-- Benefits End -->

<!-- YT Profile Start -->
<div class="container-fluid ytprofile bg-dark my-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $iframe->src }}"  
                            allow="autoplay; encrypted-media" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- YT Profile End -->

<!-- IG Profile Start -->
<p class="section-title">KONTEN TERBARU</p>
<div class="instagram-post" align="center" style="overflow: hidden;">
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-46534d90-82ef-4ddf-afce-9ed23bcd55a8" data-elfsight-app-lazy></div>          
</div>  
<!-- IG Profile End -->

{{-- Artikel Start --}}
@php
$kontenBerita = \App\Models\Article::orderByDesc('views')->take(3)->get();
@endphp

<section class="container my-5">
    <p class="section-title">ARTIKEL TERPOPULER</p>
    <div class="row g-4">
        @foreach($kontenBerita as $article)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{ $loop->index + 1 }}s">
                <div class="card border-0 h-100 shadow-sm bg-dark text-white rounded-3 overflow-hidden p-3">
                    <div class="card-img-wrapper mb-3">
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             loading="lazy" 
                             class="card-img-custom" 
                             alt="{{ $article->title }}">
                    </div>
                
                    <div class="card-body d-flex flex-column justify-content-between p-0">
                        <div>
                            <h5 class="fw-bold text-white text-uppercase mb-2">{{ $article->title }}</h5>
                            <p class="text-secondary text-white small mb-3">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="text-muted small">
                                <i class="bi bi-eye"></i> {{ $article->views }} views
                            </span>
                            <a href="{{ route('articles.detail', $article->slug) }}" 
                               class="btn btn-sm rounded-pill px-3 py-2"
                               style="background-color: #f6805d; color: #ffffff;">
                                Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


{{-- Artikel End --}}

@endsection