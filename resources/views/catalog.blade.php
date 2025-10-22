@extends('partials.master')

@section('title', 'GROZA | Katalog Produk')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/Hanasita - 1.png') }}');">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center">
            <p class="page-header animated slideInDown">KATALOG</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase page-directory">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">GROZA</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">KATALOG</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="mt-3 text-center">
    <p class="info-title">KATALOG PRODUK</p>

    <!-- Kontrol -->
    <div class="container-fluid" style="height: 100vh;">
        <iframe 
            src="{{ asset('pdfjs/web/viewer.html') }}?file={{ asset('files/Catalog Groza (July 2025).pdf') }}#disableAnnotationEditor=true&disableDownload=true&disablePrint=true&disableOpenFile=true" 
            width="100%" 
            height="100%" 
            style="border:none;">
        </iframe>

    </div>
</div>


@endsection
