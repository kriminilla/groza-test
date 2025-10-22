@extends('partials.master')

@section('title', 'GROZA | ' . ucfirst($product['name']))

@section('content')

<div class="container-fluid page-header p-0" style="background-image: url('{{ $headerImage }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            @if(isset($product['logo']) && trim($product['logo']) !== '')
                <img src="{{ asset($product['logo']) }}" alt="Logo Produk {{ $product['name'] }}" style="height: auto; width: 50%;">
            @else
                <p class="page-header animated slideInDown">{{ strtoupper($product['name']) }}</p>
            @endif

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">GROZA</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products') }}">PRODUK</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog.subcategories', $subcategory) }}">{{ strtoupper($subcategory) }}</a>
                    </li>
                    <li class="breadcrumb-item text-white active" aria-current="page">
                        {{ strtoupper($product['name']) }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Produk Detail --}}
<div class="container py-5">
    <div class="row align-items-center">
        {{-- Gambar utama --}}
        <div class="col-md-6 mb-4 mb-md-0 text-center">
            <div class="product-image-wrapper position-relative d-inline-block shadow rounded">
                <img id="product-image"
                     src="{{ !empty($product['colors']) ? $product['colors'][0]['image'] : $product['main_image'] }}"
                     class="img-fluid rounded"
                     alt="{{ $product['name'] }}"
                     style="max-height: 500px; object-fit: cover;">
            </div>

            {{-- Galeri --}}
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-3">
                @foreach($product['gallery'] as $index => $item)
                    @php
                        $isVideoFile = \Illuminate\Support\Str::endsWith($item['src'], ['.mp4', '.mov', '.avi', '.mkv']);
                    @endphp

                    @if($item['type'] === 'youtube')
                        {{-- YouTube Thumbnail --}}
                        <div class="thumb youtube-thumb img-thumbnail d-flex align-items-center justify-content-center bg-dark text-white"
                             data-bs-toggle="modal" data-bs-target="#galleryModal"
                             data-index="{{ $index }}"
                             style="width: 80px; height: 80px; cursor: pointer; border: 2px solid transparent;">
                            <i class="fab fa-youtube" style="font-size: 2rem;"></i>
                        </div>

                    @elseif($isVideoFile || $item['type'] === 'video')
                        {{-- Video Upload Thumbnail --}}
                        <video class="thumb video-thumb img-thumbnail"
                               data-bs-toggle="modal" data-bs-target="#galleryModal"
                               data-index="{{ $index }}"
                               style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;"
                               muted>
                            <source src="{{ $item['src'] }}" type="video/mp4">
                        </video>

                    @else
                        {{-- Gambar Thumbnail --}}
                        <img src="{{ $item['src'] }}"
                             class="thumb image-thumb img-thumbnail"
                             data-bs-toggle="modal" data-bs-target="#galleryModal"
                             data-index="{{ $index }}"
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="col-md-6">
            <h2 class="fw-bold mb-3 text-white">{{ ucfirst($product['name']) }}</h2>
            <p class="text-muted mb-4">{{ $product['description'] }}</p>

            @if(!empty($product['colors']))
                <div class="mb-4">
                    <h6 class="font-bold text-white mb-3">Pilihan Warna:</h6>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product['colors'] as $color)
                            <span class="color-option {{ $loop->first ? 'active' : '' }}"
                                  style="background-color: {{ $color['code'] }};
                                         color: {{ strtolower($color['code']) === '#ffffff' ? '#000000' : '#ffffff' }};"
                                  data-image="{{ $color['image'] }}"
                                  data-name="{{ $color['name'] }}">
                                {{ $color['name'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($product['sizes']))
                <div class="mb-4">
                    <h6 class="fw-bold text-white">Varian Tersedia:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($product['sizes'] as $size)
                            <span class="badge bg-secondary p-2">{{ $size }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Galeri --}}
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-body text-center position-relative p-0 rounded-lg">
                <div id="galleryContent"
                     style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                <button class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y ms-2 shadow-sm" id="prevBtn">‹</button>
                <button class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y me-2 shadow-sm" id="nextBtn">›</button>
                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 badge bg-dark opacity-75" id="galleryIndicator"></div>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const gallery = @json($product['gallery']);
    const galleryModal = document.getElementById('galleryModal');
    const galleryContent = document.getElementById("galleryContent");
    const mainProductImage = document.getElementById("product-image");
    const indicator = document.getElementById("galleryIndicator");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    let currentIndex = 0;

    function showItemInModal(index) {
        const item = gallery[index];
        if (!item) return;
        currentIndex = index;
        galleryContent.innerHTML = "";

        const isVideoFile = item.src.match(/\.(mp4|mov|avi|mkv)$/i);

        if (item.type === "youtube") {
            galleryContent.innerHTML = `
                <div style="width: 100%; max-width: 80vw; aspect-ratio: 16 / 9; max-height: 80vh;">
                    <iframe width="100%" height="100%"
                            src="${item.src}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="border-radius: 0.375rem;">
                    </iframe>
                </div>`;
        } else if (item.type === "video" || isVideoFile) {
            galleryContent.innerHTML = `
                <video controls autoplay class="rounded" style="max-height: 80vh; width: 100%; height: auto;">
                    <source src="${item.src}" type="video/mp4">
                    Browser kamu tidak mendukung video tag.
                </video>`;
        } else {
            galleryContent.innerHTML = `
                <img src="${item.src}" class="img-fluid rounded"
                     style="max-height: 80vh;" alt="Gallery Item">`;
        }

        indicator.innerHTML = `${index + 1} / ${gallery.length}`;
    }

    document.querySelectorAll(".thumb").forEach((thumb, index) => {
        thumb.addEventListener("click", () => showItemInModal(index));
    });

    prevBtn.addEventListener("click", () => {
        showItemInModal((currentIndex - 1 + gallery.length) % gallery.length);
    });
    nextBtn.addEventListener("click", () => {
        showItemInModal((currentIndex + 1) % gallery.length);
    });

    galleryModal.addEventListener('hidden.bs.modal', () => galleryContent.innerHTML = '');

    document.querySelectorAll(".color-option").forEach((btn) => {
        btn.addEventListener("click", function() {
            const newImageSrc = this.dataset.image;
            if (newImageSrc) {
                mainProductImage.src = newImageSrc;
            }

            // Update warna aktif
            document.querySelectorAll(".color-option").forEach(el => {
                el.classList.remove("active");
            });
            this.classList.add("active");

            // 🟢 Scroll ke gambar utama (halus, aman di mobile)
            mainProductImage.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        });
    });

});
</script>

@endsection
