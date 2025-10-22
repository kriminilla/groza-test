@extends('partials.master')

@section('title', 'GROZA | ' . ucfirst(strtolower($categoryName)))

@section('content')

<!-- Header Start -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/Hanasita - 1.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <p class="page-header animated slideInDown">KATALOG {{ strtoupper($categoryName) }} GROZA</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">GROZA</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('liniproduk') }}">PRODUK</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ strtoupper($categoryName) }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Katalog Start -->
<div class="container my-5 center animated slideInUp"> 
  <div class="row g-3">

    @foreach ($subcategories as $index => $sub)
      <div class="col-lg-4 col-md-6">
        <div class="p-4 rounded h-100 d-flex flex-column justify-content-between align-items-center text-center 
                    {{ $loop->iteration % 3 == 0 ? 'bg-orange text-white' : 'bg-putih' }}">
          <div>
            <a href="{{ route('products.subcategories', $sub['slug']) }}" 
               class="{{ $loop->iteration % 3 == 0 ? 'text-white' : 'text-dark' }}">
              <small class="{{ $loop->iteration % 3 == 0 ? 'text-white' : 'text-muted' }}">{{ strtoupper($categoryName) }}</small>
              <h3 class="fw-bold">{{ strtoupper($sub['name']) }}</h3>
            </a>
          </div>
          <a href="{{ route('products.subcategories', $sub['slug']) }}" 
          class="d-flex justify-content-center align-items-end w-100">
          <div class="img-hover d-flex justify-content-center align-items-center text-center" 
               style="height: 250px;"> 
              <img src="{{ $sub['img'] }}" 
                   alt="{{ $sub['name'] }}" 
                   class="img-fluid"
                   style="max-width: 80%; height: auto; object-fit: contain;">
          </div>             
          </a>
        </div>
      </div>
    @endforeach

  </div>
</div>
<!-- Katalog End -->

@endsection
