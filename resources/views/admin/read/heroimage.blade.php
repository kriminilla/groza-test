@extends('admin.partials.master')

@section('title', 'GROZA | HERO IMAGE')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Konten Hero Image</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Konten Hero Image</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

          <div class="card card-dark">
              <div class="card-header d-flex justify-content-start align-items-center">
                  <h4 class="card-title mb-0">Konten Header Saat Ini</h4>
                  <button class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#modal-add">
                      <i class="fas fa-plus"></i> Tambah Hero
                  </button>
              </div>
              
                <div class="card-body">
                    <div class="row">
                        @forelse($images as $img)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="{{ asset($img->src) }}" class="card-img-top" alt="{{ $img->alt }}">
                                    <div class="card-body text-center">
                                        <p>{{ $img->alt ?? '-' }}</p>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit-{{ $img->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('heroimage.destroy', $img->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form" 
                                              data-nama="{{ $img->alt ?? 'Hero Image' }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modal-edit-{{ $img->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('heroimage.update', $img->id) }}" method="POST" enctype="multipart/form-data" class="swal-loading">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5>Edit Hero Image</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Upload Gambar Baru (Opsional)</label>
                                                    <input type="file" name="src" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt Text</label>
                                                    <input type="text" name="alt" value="{{ $img->alt }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                <i class="fas fa-image mr-2"></i> Belum ada hero image.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{-- Modal Add --}}
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('heroimage.store') }}" method="POST" enctype="multipart/form-data" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Hero Image</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <input type="file" name="src" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alt Text</label>
                        <input type="text" name="alt" class="form-control">
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

    // ✅ SweetAlert sukses untuk Create / Update / Delete
    @if (session()->has('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif

    // ✅ SweetAlert konfirmasi hapus hero image
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const nama = form.getAttribute('data-nama');
            
            Swal.fire({
                title: 'Yakin hapus gambar ini?',
                text: `Hero "${nama}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang menghapus...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });
    });

    // ✅ SweetAlert loading saat form disubmit (misalnya create/update)
    const loadingForms = document.querySelectorAll('.swal-loading');
    loadingForms.forEach(form => {
        form.addEventListener('submit', function () {
            Swal.fire({
                title: 'Sedang menyimpan...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });

});
</script>


@endsection

