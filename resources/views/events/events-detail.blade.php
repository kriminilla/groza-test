@extends('partials.master')

@section('title', 'GROZA | ' . $event->title)

@section('content')

<!-- Header Konten -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/cover-shock.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <h1 class="page-header animated slideInDown fw-bold text-white">
                {{ $event->title }}
            </h1>
            <p class="articleheader-details text-white mt-2">
                Tanggal Pelaksanaan • {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
            </p>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="header-links">GROZA</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.list') }}" class="header-links">KONTEN</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $event->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container my-5">
  <div class="text-center mb-4">
    <img style="height: auto; width: 500px;" src="{{ asset('storage/' . $event->cover) }}" alt="{{ $event->judul }}" class="img-fluid rounded shadow">
  </div>

  <div class="mx-auto" style="max-width: 800px;">
    {!! $event->description !!}
  </div>

  {{-- Galeri --}}
  @if($event->galleries->count())
    <div>
      <h4 class="fw-bold mb-3 text-center">Galeri Kegiatan</h4>
      <div class="row g-3">
        @foreach($event->galleries as $img)
          <div class="col-md-4 col-6">
            <img src="{{ asset('storage/' . $img->image) }}" class="img-fluid rounded shadow-sm" loading="lazy">
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
