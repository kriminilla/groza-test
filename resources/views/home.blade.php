@extends('partials.master')

@section('title', 'Homepage')

@section('content')
<!-- Landing Carousel Start -->
<div id="carouselExampleControls" class="carousel slide" data-mdb-ride="carousel" data-mdb-carousel-init>
<div class="carousel-inner">
    <div class="carousel-item active">
        <img src="{{ asset('img/grz1-830.png') }}" loading="lazy" class="d-block w-100" alt="Never Stop, Build and Race It">
    </div>
    <div class="carousel-item">
        <img src="{{ asset('img/grz1-830.png') }}" loading="lazy" class="d-block w-100" alt="Groza Indonesia">
    </div>
    <div class="carousel-item">
        <img src="{{ asset('img/grz1-830.png') }}" loading="lazy" class="d-block w-100" alt="Inovasi Groza">
    </div>
</div>
<button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>
</div>
<!-- Landing Carousel End -->

<!-- Products Start -->
<p class="section-title">PRODUCTS</p>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="img/Produk-Kategori-Aksesori.png" loading="lazy" alt="Aksesoris Groza">
        </div>
        <div class="swiper-slide">
            <img src="img/Produk-Kategori-Sistem-Pengereman.png" loading="lazy" alt="Pengereman Groza">
        </div>
        <div class="swiper-slide">
            <img src="img/Produk-Kategori-Suspensi.png" loading="lazy" alt="Shockbreaker Groza">
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
                    <h5 class="heading" style="color: #e4905b;">Kualitas Terbaik, <br> Untuk Kendaraan Bermotor</h5>
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
                    <h5 class="heading" style="color: #e4905b;">Teknologi Terbaru, dan Inovatif</h5>
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
                    <h5 class="heading" style="color: #e4905b;">Pilihan Aksesori Lengkap</h5>
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
                    <h5 class="heading" style="color: #e4905b;">Desain Stylish dan Ergonomis</h5>
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
                    <h5 class="heading" style="color: #e4905b;">Dukungan Purna Jual Terbaik</h5>
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
                    <h5 class="heading" style="color: #e4905b;">Harga Terjangkau dengan Kualitas Premium</h5>
                    <p class="para">Groza memberikan produk berkualitas tinggi dengan harga yang bersaing. Anda nggak perlu khawatir soal harga, karena kualitas tetap jadi prioritas utama Groza!</p>
                </div>
            </div>
        </div> 
    </div>
</div>
<!-- Benefits End -->

<!-- YT Profile Start -->
<div class="container-fluid fact bg-dark my-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/-lzaXWw-n-0?rel=0&controls=0&autoplay=1&mute=1&loop=1&playlist=-lzaXWw-n-0"  
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
<div class="instagram-post" align="center">
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-46534d90-82ef-4ddf-afce-9ed23bcd55a8" data-elfsight-app-lazy></div>          
</div>  
<!-- IG Profile End -->

<!-- Artikel Start -->
<p class="section-title">ARTIKEL TERPOPULER</p>
<div class="container text-center">
    <div class="row">
        <div class="col-md-4 mb-3 wow fadeInDown">
            <div class="card h-100">
                <img src="img/event1.jpg" loading="lazy" class="card-img-top" alt="...">
                <div class="card-body" style="background-color: #181717; color: #ffffff;">
                    <h5 style="color: #FFFFFF;">Artikel1</h5>
                        <p class="card-text">Deskripsi Singkat Artikel.....</p>
                        <a href="#" class="btn" style="background-color: #f6805d; color: #ffffff;">Selengkapnya →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 wow fadeInDown">
                <div class="card h-100">
                    <img src="img/event1.jpg" loading="lazy" class="card-img-top" alt="...">
                    <div class="card-body" style="background-color: #181717; color: #ffffff;">
                    <h5 style="color: #FFFFFF;">Artikel2</h5>
                    <p class="card-text">Deskripsi Singkat Artikel.....</p>
                    <a href="#" class="btn" style="background-color: #f6805d; color: #ffffff;">Selengkapnya →</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 wow fadeInDown">
            <div class="card h-100">
                <img src="img/event1.jpg" loading="lazy" class="card-img-top" alt="...">
                <div class="card-body" style="background-color: #181717; color: #ffffff;">
                    <h5 style="color: #FFFFFF;">Artikel3</h5>
                    <p class="card-text">Deskripsi Singkat Artikel.....</p>
                    <a href="#" class="btn" style="background-color: #f6805d; color: #ffffff;">Selengkapnya →</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Artikel End -->
@endsection