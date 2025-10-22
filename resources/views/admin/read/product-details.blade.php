@extends('admin.partials.master')

@section('title', 'Detail Produk')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail {{ $product->product_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Produk</li>
                    <li class="breadcrumb-item active">{{ $product->product_name }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $product->product_name }}</h3>
        <div class="card-tools">
            {{-- Tombol Edit --}}
            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-tool btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width: 200px;">Kategori - Subkategori</th>
                    <td>
                        {{ $product->category->category_name ?? '-' }} - {{ $product->subcategory->subcategory_name ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Caption</th>
                    <td>{{ $product->caption }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{!! nl2br(e($product->description)) !!}</td>
                </tr>
                <tr>
                    <th>Gambar Produk</th>
                    <td>
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/' . $product->image) }}" width="200" class="img-thumbnail">
                        @else
                            <img src="{{ asset('img/no-image.png') }}" width="200" class="img-thumbnail">
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Logo Produk</th>
                    <td>
                        @if($product->logo && file_exists(public_path('storage/' . $product->logo)))
                            <div style="display:inline-block; background:#000; padding:10px; border-radius:8px;">
                                <img src="{{ asset('storage/' . $product->logo) }}" width="150">
                            </div>
                        @else
                            <img src="{{ asset('img/no-image.png') }}" width="150" class="img-thumbnail">
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pilihan Warna</th>
                    <td>
                        <div class="row">
                            @forelse($product->colors as $color)
                                <div class="col-md-3 mb-3 text-center">
                                    <div class="card h-100">
                                        @if($color->image && file_exists(public_path('storage/' . $color->image)))
                                            <img src="{{ asset('storage/' . $color->image) }}" class="card-img-top" style="max-height:150px; object-fit:contain;">
                                        @else
                                            <img src="{{ asset('img/no-image.png') }}" class="card-img-top" style="max-height:150px; object-fit:contain;">
                                        @endif
                                        <div class="card-body p-2">
                                            <p class="card-text">
                                                {{ $color->colorCode->color_name ?? '-' }}
                                                <br>
                                                <span style="display:inline-block; width:20px; height:20px; border-radius:50%; background-color:{{ $color->colorCode->color_code ?? '#ccc' }};"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>-</p>
                            @endforelse
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Flyer</th>
                    <td>
                        <div class="row">
                            @forelse($product->flyers as $flyer)
                                <div class="col-md-3 mb-3 text-center">
                                    <div class="card h-100">
                                        <div class="card-body p-2">
                                            @php
                                                $path = public_path('storage/' . $flyer->flyer);
                                                $isVideo = \Illuminate\Support\Str::endsWith($flyer->flyer, ['.mp4', '.mov', '.avi']);
                                            @endphp
                                            @if($flyer->flyer && file_exists($path))
                                                @if($isVideo)
                                                    <video class="w-100" controls style="max-height:200px; object-fit:contain;">
                                                        <source src="{{ asset('storage/' . $flyer->flyer) }}" type="video/mp4">
                                                    </video>
                                                @else
                                                    <img src="{{ asset('storage/' . $flyer->flyer) }}" class="img-fluid" style="max-height:200px; object-fit:contain;">
                                                @endif
                                            @else
                                                <img src="{{ asset('img/no-image.png') }}" class="img-fluid" style="max-height:200px; object-fit:contain;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>-</p>
                            @endforelse
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Ukuran</th>
                    <td>
                        {{ $product->sizes->isNotEmpty() ? implode(', ', $product->sizes->pluck('size_label')->toArray()) : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('product.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
