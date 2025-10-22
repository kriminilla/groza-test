@extends('admin.partials.master')

@section('title', 'GROZA | Detail Event')

@section('content')
<section class="content-header"> 
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Detail Event</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Detail Event</li>
                </ol>
            </div>
        </div>
    </div> 
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Card Event -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $event->title }}</h3>
                        <div class="card-tools">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-tool btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Cover -->
                        @if($event->cover)
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $event->cover) }}" alt="Cover" class="img-fluid rounded shadow">
                            </div>
                        @endif

                        <!-- Detail Info -->
                        <dl class="row">
                            <dt class="col-sm-3">Judul Kegiatan</dt>
                            <dd class="col-sm-9">{{ $event->title }}</dd>

                            <dt class="col-sm-3">Tanggal Kegiatan</dt>
                            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($event->tanggal_kegiatan)->translatedFormat('d F Y') }}</dd>

                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ $event->category->category_name ?? '-' }}</dd>

                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9">{!! nl2br(e($event->description)) !!}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Card Galeri -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Galeri</h3>
                    </div>
                    <div class="card-body">
                        @if($event->galleries && $event->galleries->count() > 0)
                            <div class="row">
                                @foreach($event->galleries as $g)
                                    <div class="col-sm-2 mb-3">
                                        <a href="{{ asset('storage/' . $g->image) }}" data-toggle="lightbox" data-gallery="event-gallery">
                                            <img src="{{ asset('storage/' . $g->image) }}" class="img-fluid rounded shadow-sm"/>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Belum ada galeri untuk event ini.</p>
                        @endif
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-3">
                    <a href="{{ route('event.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- Ekko Lightbox -->
<script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
</script>
@endpush

@push('styles')
<!-- Ekko Lightbox CSS -->
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush
