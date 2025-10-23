@extends('partials.master')

@section('title', 'GROZA | Artikel')

@section('content')

<!-- Header Konten -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/cover-shock.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <h1 class="page-header animated slideInDown fw-bold text-white">
                DAFTAR ARTIKEL  
            </h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="header-links">GROZA</a></li>
                    <li class="breadcrumb-item">DAFTAR ARTIKEL</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container my-3">
    {{-- Searchbar --}}
    <div class="navbar-container mb-3">
      <div class="search-bar">
        <div class="InputContainer">
          <svg
            class="searchIcon"
            width="20px"
            viewBox="0 0 24 24"
            height="20px"
            xmlns="http://www.w3.org/2000/svg">
            <path fill="none" d="M0 0h24v24H0z"></path>
            <path
              d="M15.5 14h-.79l-.28-.27A6.518 6.518 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
            ></path>
          </svg>
          <input
            class="input"
            id="search-input"
            placeholder="Cari Judul Artikel..."
            type="text"
          />
        </div>  
      </div>
    </div>
    {{-- Searchbar End --}}
    
    {{-- 📦 Daftar Artikel --}}
    <div class="row g-4">
        @foreach($articles as $article)
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

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $articles->links() }}
    </div>
</div>

@endsection
