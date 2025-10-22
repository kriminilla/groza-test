{{-- resources/views/admin/read/artikel_detail.blade.php --}}
@extends('admin.partials.master')

@section('title', $articles->title)

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $articles->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Artikel</h3>
                        <div class="card-tools">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('article.edit', $articles->id) }}" class="btn btn-tool btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <small class="text-muted">
                                        Dibuat oleh: 
                                        {{-- Pastikan relasi admin ada di Model Artikel --}}
                                        <strong>{{ $articles->admin->name ?? 'Admin Dihapus' }}</strong> 
                                        pada tanggal {{ $articles->created_at->format('d M Y') }}
                                    </small>
                                </p>
                            </div>
                        </div>

                        {{-- COVER UTAMA --}}
                        <div class="text-center mb-4">
                            <h4>Gambar Cover</h4>
                            {{-- Gunakan asset() atau Storage::url() tergantung konfigurasi disk kamu --}}
                            <img src="{{ asset('storage/' . $articles->image) }}" class="img-fluid" alt="Cover Artikel" style="max-height: 400px; object-fit: cover;">
                        </div>
                        
                        <hr>
                        
                        {{-- KONTEN ARTIKEL --}}
                        <h4 class="mb-3">Konten</h4>
                        <div class="article-content">
                            {{-- Tampilkan konten dengan raw HTML --}}
                            {!! $articles->content !!} 
                        </div>

                        <hr>

                        {{-- GALERI ARTIKEL --}}
                        @if($articles->galleries->count() > 0)
                            <h4 class="mb-3">Galeri Tambahan ({{ $articles->galleries->count() }})</h4>
                            <div class="row">
                                @foreach($articles->galleries->sortBy('order') as $galleries)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $galleries->src) }}" class="card-img-top" alt="Galeri Image" style="height: 200px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <p class="card-text text-muted text-center"><small>{{ $galleries->caption ?? 'Tanpa Caption' }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h4 class="text-muted">Tidak ada Galeri Tambahan.</h4>
                        @endif

                    </div>
                    
                    <div class="card-footer">
                        <a href="{{ route('article.index') }}" class="btn btn-default">Kembali ke Daftar Artikel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection