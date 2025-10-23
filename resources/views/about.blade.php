@extends('partials.master')

@section('title', 'GROZA | Tentang Kami')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/Hanasita - 1.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <p class="page-header animated slideInDown">TENTANG GROZA</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="header-links">GROZA</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">TENTANG GROZA</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- ABOUT 1 START -->
{{-- TENTANG KAMI --}}
<div class="container">
    <div class="row" style="min-height: 300px; padding: 0px 15px 0px 15px;"> 
        <div class="col-md-6 d-flex justify-content-center align-items-center mt-5">
            <img src="{{ asset('img/logoGroza.png') }}" alt="Groza Indonesia" style="width: 60%; height: auto;">
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center mt-5">
            <div>
                <p class="info-title">Tentang Kami</p>
                <p class="info-details" style="text-align: justify">
                Didirikan pada tahun 2022, Groza Indonesia menjadi penyedia aksesori motor berkualitas yang menawarkan berbagai komponen dan variasi kendaraan bermotor roda dua. 
                Kini, Groza Indonesia telah bekerja sama dengan berbagai manufaktur dan importir komponen otomotif terkemuka. 
                Dengan jaringan distribusi yang luas, kami melayani pelanggan di seluruh Indonesia, mencakup provinsi Jawa Timur, Jawa Tengah, Jawa Barat, Bali, Sulawesi Selatan, Sulawesi Utara, Sumatra Barat, dan Jambi.
                </p>
            </div>
        </div>
    </div>
</div>
{{-- TENTANG KAMI END --}}

{{-- LAYANAN GROZA --}}
<div class="container-fluid page-header mt-5 mb-5 p-0" style="background-image: url('{{ asset('img/Hanasita - 2.png') }}');">
    <div class="container-fluid page-header-inner py-5">            
        <div class="container text-center">
            <p class="info-title">
                Layanan Kami
            </p>
            <p class="info-details" style="margin-top: -15px;">
                Groza Indonesia mengoperasikan dua model bisnis utama:
            </p>
        <div class="row text-center mt-5">
            <!-- Kolom B2B -->
            <div class="col-md-6 mb-4 mb-md-0 border-end border-secondary">
                <p class="info-title">Distribusi B2B <br> (Business to Business)</p>
                    <hr class="border-secondary w-75 mx-auto my-1">
                <p class="info-details">Kepada Mitra Toko Aksesori Motor</p>
            </div>

            <!-- Kolom B2C -->
            <div class="col-md-6">
                <p class="info-title">Distribusi B2C <br> (Business to Customer)</p>
                    <hr class="border-secondary w-75 mx-auto my-1">
                <p class="info-details">Langsung ke Konsumen Akhir</p>
            </div>

            <p class="info-details mt-3">Kami terus berusaha menjadi mitra terbaik bagi toko-toko aksesori motor dengan memperluas jaringan pemasaran kami. 
                Melalui website ini, kami memberikan solusi inovatif untuk mempermudah proses pemesanan bagi pelanggan kami. 
                Pelanggan dapat memilih dan membeli produk aksesori motor berkualitas melalui E-Commerce resmi Groza Official Indonesia.
            </p>
        </div>
        </div>
    </div>
</div>
{{-- LAYANAN GROZA END --}}

{{-- KEUNGGULAN START --}}
<section class="embla">
<p class="info-title" align="center">KEUNGGULAN GROZA INDONESIA</p>
  <div class="embla__viewport mt-5">
    <div class="embla__container">
      <div class="embla__slide">
        <i class="fas fa-star fa-lg icon embla-icons"></i>
        <hr class="mt-5">
        <h5 class="embla-title">Komponen Motor Berkualitas</h5>
        <p class="embla-details">
          Menyediakan produk aksesoris motor yang terjamin kualitasnya.
        </p>
      </div>
      <div class="embla__slide">
          <i class="fas fa-globe fa-lg icon embla-icons"></i>
          <hr class="mt-5">
          <h5 class="embla-title">Jaringan Distribusi Luas</h5>
          <p class="embla-details">
            Kami melayani seluruh Indonesia, termasuk Jawa, Bali, Sulawesi, dan Sumatra.
          </p>
      </div>
      <div class="embla__slide">
          <i class="fas fa-medal fa-lg icon embla-icons"></i>
          <hr class="mt-5">
          <h5 class="embla-title">Orisinalitas Terjamin</h5>
          <p class="embla-details">
            Produk Groza terjamin keasliannya, dan bergaransi 6 Bulan.
          </p>
      </div>
      <div class="embla__slide">
          <i class="fas fa-trophy fa-lg icon embla-icons"></i>
          <hr class="mt-5">
          <h5 class="embla-title">Harga & Pengiriman Terbaik</h5>
          <p class="embla-details">
            Menawarkan harga terbaik dengan pengiriman yang cepat dan aman.
          </p>
      </div>
      <div class="embla__slide">
          <i class="fas fa-shopping-cart fa-lg icon embla-icons"></i>
          <hr class="mt-5">
          <h5 class="embla-title">Kemudahan Berbelanja Online</h5>
          <p class="embla-details">
            Pesan aksesori motor Anda secara fleksibel dengan akses Marketplace Groza (Shopee, Tokopedia, TikTok Shop).
          </p>
      </div>
    </div>
  </div>
  <div class="embla__dots"></div>
</section>
{{-- KEUNGGULAN END --}}

{{-- HI QUALITY PRODUCT START --}}
<div class="container-fluid page-header mt-5 mb-5 p-0" style="background-image: url('{{ asset('img/Hanasita - 2.png') }}');">
  <div class="container-fluid page-header-inner py-5">
    <div class="container">
      <div class="row align-items-center justify-content-center mt-5 mb-5">
        <div class="col-md-6 text-center text-md-start">
          <p class="info-title">
            Produk Berkualitas Tinggi, <br>
            Untuk Kepuasan Customer
          </p>
          <p class="info-details">
            Kami memahami pentingnya kualitas dalam produk aksesori motor,
            oleh karena itu kami hanya menyediakan komponen dan variasi kendaraan bermotor dengan standar tinggi.
            Dengan harga yang bersaing, pengiriman cepat, dan layanan purnajual yang responsif,
            kami berkomitmen untuk memberikan pengalaman belanja terbaik bagi setiap customer.
          </p>
        </div>

        <div class="col-md-6 text-center">
          <img src="{{ asset('img/dazzle.jpeg') }}" style="width: 70%; height: auto;" alt="Kaliper Radial Groza Dazzle" class="img-fluid custom-img">
        </div>
      </div>
    </div>
  </div>
</div>
{{-- HI QUALITY PRODUCT END --}

{{-- PENGAJUAN KEMITRAAN  --}}
<div class="container my-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4 info-title">Formulir Pengajuan Kemitraan</h2>
      <form id="waForm">
        @csrf
        <div class="inputGroup mb-4">
            <input type="text" id="nama_toko" required autocomplete="off">
            <label for="nama_toko">Nama Toko</label>
        </div>
        <div class="inputGroup mb-4">
            <input type="text" id="nama_owner" required autocomplete="off">
            <label for="nama_owner">Nama Owner</label>
        </div>
        <div class="inputGroup mb-4">
            <input type="text" id="alamat_toko" required autocomplete="off">
            <label for="alamat_toko">Alamat Toko</label>
        </div>
        <div class="inputGroup mb-4">
            <input type="text" id="provinsi" required autocomplete="off">
            <label for="provinsi">Provinsi</label>
        </div>
        <div class="inputGroup mb-4">
            <input type="tel" id="telepon" required autocomplete="off">
            <label for="telepon">Nomor Telepon</label>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </div>
      </form>

    </div>

    <div class="col-md-6 d-flex align-items-center justify-content-center mt-5 mt-md-0">
      <div class="p-4 rounded">
        <h3 class="info-title mb-3">Bergabunglah dengan Jaringan Kemitraan Kami</h3>
        <p class="info-details" align="justify">Kami membuka kesempatan seluas-luasnya bagi Anda yang ingin menjadi bagian dari keluarga besar kami. Dengan menjadi mitra, Anda akan mendapatkan akses ke produk-produk berkualitas tinggi, dukungan pemasaran, serta margin keuntungan yang menarik.</p>
        <p class="info-details" align="justify">Isi formulir di samping untuk memulai proses pengajuan. Tim kami akan segera menghubungi Anda untuk mendiskusikan potensi kerja sama yang saling menguntungkan.</p>
      </div>
    </div>
  </div>
</div>
{{-- PENGAJUAN KEMITRAAN END--}}

{{-- ABOUT 1 END --}}

@endsection