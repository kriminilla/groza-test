@extends('partials.master')

@section('title', 'GROZA | Katalog ' . $categoryName)

@section('content')

{{-- Page Header --}}
<div class="container-fluid page-header p-0" style="background-image: url('{{ $headerImage }}');">
  <div class="container-fluid page-header-inner py-5">
    <div class="container text-center">
      <p class="page-header animated slideInDown">KATALOG {{ strtoupper($categoryName) }}</p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center text-uppercase page-directory">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">GROZA</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products') }}">PRODUK</a></li>
          <li class="breadcrumb-item text-white active" aria-current="page">{{ $categoryName }}</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
{{-- Page Header End --}}

{{-- Searchbar --}}
<div class="navbar-container mt-3">
  <div class="search-bar">
    <div class="InputContainer">
      <svg class="searchIcon" width="20px" viewBox="0 0 24 24" height="20px" xmlns="http://www.w3.org/2000/svg">
        <path fill="none" d="M0 0h24v24H0z"></path>
        <path
          d="M15.5 14h-.79l-.28-.27A6.518 6.518 0 0 0 16 9.5 
             6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 
             4.99L20.49 19l-4.99-5zm-6 0C7.01 14 
             5 11.99 5 9.5S7.01 5 9.5 5 
             14 7.01 14 9.5 11.99 14 9.5 14z">
        </path>
      </svg>
      <input class="input" id="search-input" placeholder="Nama Produk" type="text" />
    </div>  
  </div>
</div>
{{-- Searchbar End --}}

{{-- Product List --}}
<div class="container my-3 center animated slideInUp">
  <div class="row g-3">

    @if($productList->isEmpty())
      {{-- Jika belum ada produk --}}
      <div class="col-12 text-center">
        <div class="p-5 rounded shadow-sm">
          <h4 class="fw-bold text-white">Belum Ada Produk</h4>
          <p class="text-muted mb-0 text-white">
            Produk <strong>{{ strtoupper($categoryName) }}</strong> sedang dalam proses update 
            dan akan segera hadir di katalog kami.
          </p>
        </div>
      </div>
    @else
      {{-- Loop Produk --}}
      @foreach($productList as $p)
        <div class="col-lg-3 col-md-4 col-sm-6 product-item">
          <div class="p-4 bg-putih rounded h-100 d-flex flex-column align-items-center justify-content-center">
            <small>{{ strtoupper($categoryName) }}</small>
            <a href="{{ route('products.detail', [$categorySlug, $p['slug']]) }}">
              <h3 class="fw-bold">{{ $p['name'] }}</h3>
            </a>
            <div class="img-hover mt-2">
              <a href="{{ route('products.detail', [$categorySlug, $p['slug']]) }}">
                <img src="{{ asset($p['img']) }}" 
                     alt="Groza {{ $categoryName }} {{ $p['name'] }}" 
                     style="max-width: 200px; height: auto;">
              </a>
            </div>
            <p class="mt-2 text-muted">{{ $p['desc'] }}</p>
          </div>
        </div>
      @endforeach
    @endif

  </div>
</div>
{{-- Product List End --}}

{{-- Search Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const productItems = document.querySelectorAll('.product-item');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();

            productItems.forEach(item => {
                const productName = item.querySelector('h3.fw-bold').textContent.toLowerCase();
                item.style.display = productName.includes(searchTerm) ? 'block' : 'none';
            });
        });
    }
});
</script>
{{-- Search Script End --}}

@endsection
