@extends('admin.partials.master')

@section('title', 'GROZA | IFRAME VIDEO')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Konten Video (Iframe)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Konten Video</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Alert SweetAlert jika sukses --}}
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    });
                </script>
            @endif

            <div class="card card-dark">
                <div class="card-header">
                    <h4 class="card-title mb-0">Video Saat Ini</h4>
                </div>
                
                <div class="card-body text-center">
                    @if($iframe->src)
                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                            <iframe class="embed-responsive-item" src="{{ $iframe->src }}" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    @else
                        <p>Belum ada video.</p>
                    @endif

                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit">
                        <i class="fas fa-edit"></i> Ubah Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{-- Modal Edit --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('iframe.update', $iframe->id) }}" method="POST" class="swal-loading">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5>Ubah Iframe Video</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Embed Iframe / Link Video</label>
                        <textarea name="src" class="form-control" placeholder="Paste kode iframe atau link video di sini">{{ $iframe->src }}</textarea>
                        <small class="form-text text-muted">
                            Contoh input:<br>
                            <code>&lt;iframe src="https://www.youtube.com/embed/abc123"&gt;&lt;/iframe&gt;</code><br>
                            atau cukup: <code>https://www.youtube.com/embed/abc123</code>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Saat form disubmit, tampilkan loading SweetAlert
        const forms = document.querySelectorAll('.swal-loading');
        forms.forEach(form => {
            form.addEventListener('submit', function () {
                Swal.fire({
                title: 'Sedang menyimpan...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        });
    });
});
</script>

@endsection

