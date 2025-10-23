@extends('partials.master')

@section('title', 'GROZA | Produk')

@section('content')

{{-- Page Header --}}
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/Hanasita - 2.png') }}');">
  <div class="container-fluid page-header-inner py-5">
    <div class="container text-center">
      <p class="page-header animated slideInDown">KATALOG PRODUK GROZA</p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center text-uppercase page-directory">
          <li class="breadcrumb-item"><a href="{{ url('/') }}" class="header-links">GROZA</a></li>
          <li class="breadcrumb-item text-white active" aria-current="page">PRODUK</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
{{-- Page Header End --}}

{{-- Produk List --}}
<div class="container my-5 center animated slideInUp" style="overflow: hidden;">
  <div class="row g-3">

    {{-- Kaliper --}}
    @php $kaliper = $subcategories->where('subcategory_name', 'Kaliper')->first(); @endphp
    <div class="col-lg-6">
     <div class="bg-putih rounded h-100 product-card">
       <div class="product-text">
         <a href="{{ route('catalog.subcategories', 'kaliper') }}">
           <small>Pengereman</small>
           <h3 class="fw-bold mb-0">KALIPER</h3>
         </a>
       </div>
       <div class="product-image img-hover">
         <a href="{{ route('catalog.subcategories', 'kaliper') }}">
           <img src="{{ asset($kaliper->image ?? 'img/kaliper.png') }}" alt="Groza Kaliper" style="max-width: 250px;">
         </a>
       </div>
     </div>
   </div>




    {{-- Master Rem --}}
    @php $masterrem = $subcategories->where('subcategory_name', 'Master Rem')->first(); @endphp
    <div class="col-lg-3">
      <div class="p-4 bg-putih rounded h-100 d-flex flex-column align-items-center justify-content-between text-center">
        <div>
          <small>Pengereman</small>
          <a href="{{ route('catalog.subcategories', 'master-rem') }}">
            <h3 class="fw-bold">MASTER REM</h3>
          </a>
        </div>
        <div class="img-hover mt-3">
          <a href="{{ route('catalog.subcategories', 'master-rem') }}">
            <img src="{{ asset($masterrem->image ?? 'img/master-rem.png') }}" alt="Groza Master Rem"
                 style="max-width: 200px;">
          </a>
        </div>
      </div>
    </div>

    {{-- Selang Rem --}}
    @php $selang = $subcategories->where('subcategory_name', 'Selang Rem')->first(); @endphp
    <div class="col-lg-3">
      <div class="p-4 bg-orange text-white rounded h-100 d-flex flex-column align-items-center justify-content-between text-center">
        <div>
          <small class="text-white">Pengereman</small>
          <a href="{{ route('catalog.subcategories', 'selang-rem') }}">
            <h3 class="fw-bold">SELANG REM</h3>
          </a>
        </div>
        <div class="img-hover mt-3">
          <a href="{{ route('catalog.subcategories', 'selang-rem') }}">
            <img src="{{ asset($selang->image ?? 'img/selang-rem.png') }}" alt="Groza Selang Rem"
                 style="max-width: 180px;">
          </a>
        </div>
      </div>
    </div>

    {{-- Disc Brake --}}
    @php $piringan = $subcategories->where('subcategory_name', 'Piringan')->first(); @endphp
    <div class="col-lg-3">
      <div class="p-4 bg-orange rounded h-100 d-flex flex-column align-items-center justify-content-between text-center">
        <div>
          <small class="text-white">Pengereman</small>
          <a href="{{ route('catalog.subcategories', 'piringan') }}">
            <h3 class="fw-bold">DISC BRAKE</h3>
          </a>
        </div>
        <div class="img-hover mt-1">
          <a href="{{ route('catalog.subcategories', 'piringan') }}">
            <img src="{{ asset($piringan->image ?? 'img/piringan.png') }}" alt="Groza Piringan"
                 style="max-width: 235px;">
          </a>
        </div>
      </div>
    </div>

    {{-- Shockbreaker --}}
    @php $shockbreaker = $subcategories->where('subcategory_name', 'Shockbreaker')->first(); @endphp
    <div class="col-lg-4">
      <div class="p-4 bg-putih rounded h-100 d-flex flex-column align-items-center justify-content-between text-center">
        <div>
          <small>Suspensi</small>
          <a href="{{ route('catalog.subcategories', 'shockbreaker') }}">
            <h3 class="fw-bold">SHOCKBREAKER</h3>
          </a>
        </div>
        <div class="img-hover mt-1">
          <a href="{{ route('catalog.subcategories', 'shockbreaker') }}">
            <img src="{{ asset($shockbreaker->image ?? 'img/shockbreaker.png') }}" alt="Groza Shockbreaker"
                 style="max-width: 230px;">
          </a>
        </div>
      </div>
    </div>

    {{-- Swing Arm --}}
    @php $swing = $subcategories->where('subcategory_name', 'Swing Arm')->first(); @endphp  
    <div class="col-lg-5">
      <div class="bg-putih rounded h-100 product-card">
        <div class="product-text">
          <a href="{{ route('catalog.subcategories', 'swing-arm') }}">
            <small>Suspensi</small>
            <h3 class="fw-bold">SWING ARM</h3>
          </a>
        </div>
        <div class="product-image img-hover">
          <a href="{{ route('catalog.subcategories', 'swing-arm') }}">
            <img src="{{ asset($swing->image ?? 'img/swing-arm.png') }}" alt="Groza Swing Arm"
                 style="max-width: 350px;">
          </a>
        </div>
      </div>
    </div>


    {{-- Tabung Minyak --}}
    @php $tabung = $subcategories->where('subcategory_name', 'Tabung Minyak')->first(); @endphp
    <div class="col-lg-6">
      <div class="bg-putih rounded h-100 product-card">
        <div class="product-text">
          <a href="{{ route('catalog.subcategories', 'tabung-minyak') }}">
            <small>Aksesoris</small>
            <h3 class="fw-bold">TABUNG MINYAK REM</h3>
          </a>
        </div>
        <div class="product-image img-hover">
          <a href="{{ route('catalog.subcategories', 'tabung-minyak') }}">
            <img src="{{ asset($tabung->image ?? 'img/botol-minyak.png') }}" alt="Groza Fluid Tank"
                 style="max-width: 220px;">
          </a>
        </div>
      </div>
    </div>


    {{-- Handgrip --}}
    @php $handgrip = $subcategories->where('subcategory_name', 'Handgrip')->first(); @endphp
    <div class="col-lg-3">
      <div class="p-4 bg-putih rounded h-100 d-flex flex-column justify-content-between align-items-center text-center">
        <div>
          <small>Aksesoris</small>
          <a href="{{ route('catalog.subcategories', 'handgrip') }}">
            <h3 class="fw-bold">HANDGRIP</h3>
          </a>
        </div>
        <div class="img-hover mt-3">
          <a href="{{ route('catalog.subcategories', 'handgrip') }}">
            <img src="{{ asset($handgrip->image ?? 'img/handgrip.png') }}" alt="Groza Handgrip"
                 style="max-width: 180px;">
          </a>
        </div>
      </div>
    </div>

    {{-- Gas Spontan --}}
    @php $gas = $subcategories->where('subcategory_name', 'Gas Spontan')->first(); @endphp
    <div class="col-lg-3">
      <div class="p-4 bg-orange rounded h-100 d-flex flex-column justify-content-center align-items-center text-center">
        <div>
          <small class="text-white">Aksesoris</small>
          <a href="{{ route('catalog.subcategories', 'gas-spontan') }}">
            <h3 class="fw-bold">GAS SPONTAN</h3>
          </a>
        </div>
        <div class="img-hover mt-3 d-flex justify-content-center align-items-center" style="flex: 1;">
          <a href="{{ route('catalog.subcategories', 'gas-spontan') }}">
            <img src="{{ asset($gas->image ?? 'img/gas-spontan.png') }}" alt="Groza Gas Spontan"
                 style="max-width: 190px;">
          </a>
        </div>
      </div>
    </div>

  </div>
</div>
{{-- Produk List End --}}

@endsection
