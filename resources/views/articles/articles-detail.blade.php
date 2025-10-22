@extends('partials.master')

@section('title', 'GROZA | ' . $content['name'])

@section('content')

<!-- Header Konten -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/cover-shock.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <h1 class="page-header animated slideInDown fw-bold text-white">
                {{ strtoupper($content['name']) }}
            </h1>
            <p class="articleheader-details text-white mt-2">
                {{ $content['publisher'] }} • {{ $content['release-date'] }}
            </p>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">GROZA</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('articles.list') }}">KONTEN</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ strtoupper($content['name']) }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Carousel Galeri -->
@if(!empty($content['gallery']) && count($content['gallery']) > 0)
<section class="container mt-5">
    <div id="kontenCarousel" class="carousel slide artikel-carousel shadow rounded overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($content['gallery'] as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    @if(Str::contains($item['src'], 'youtube.com') || Str::contains($item['src'], 'youtu.be'))
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $item['src'] }}" title="YouTube video" allowfullscreen></iframe>
                        </div>
                    @else
                        <img src="{{ asset($item['src']) }}" class="d-block w-100 carousel-main-img"
                             alt="Konten Galeri {{ $key + 1 }}">
                    @endif
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#kontenCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#kontenCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
        </button>
    </div>

    <!-- Thumbnails -->
    <div class="artikel-carousel-thumbnails d-flex justify-content-center flex-wrap mt-4 gap-2">
        @foreach($content['gallery'] as $key => $item)
            @if(!Str::contains($item['src'], 'youtube.com') && !Str::contains($item['src'], 'youtu.be'))
                <div class="artikel-thumb-wrapper {{ $key == 0 ? 'active' : '' }}"
                     data-bs-target="#kontenCarousel" data-bs-slide-to="{{ $key }}">
                    <img src="{{ asset($item['src']) }}" alt="Thumbnail {{ $key + 1 }}"
                         class="rounded shadow-sm" style="width: 100px; height: 70px; object-fit: cover;">
                </div>
            @endif
        @endforeach
    </div>
</section>
@endif

<!-- Konten Detail -->
<section class="container my-5">
    <article class="mx-auto" style="max-width: 900px;">
        <div class="article-content lh-lg fs-5" style="color: #1f1f1f;">
            {!! $content['content'] !!}
        </div>        
    </article>
</section>

@endsection
