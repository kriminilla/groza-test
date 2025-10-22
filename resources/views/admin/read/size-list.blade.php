@extends('admin.partials.master')

@section('title', 'GROZA | UKURAN')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ukuran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Ukuran</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">

                {{-- Alert sukses/error biasa (fallback) --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <form method="GET" action="{{ route('size.index') }}" class="form-inline">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i> Tambah Ukuran
                            </a>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Ukuran</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sizes as $s)
                                    <tr>
                                        <td>{{ $s->size_label }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $s->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="modal-edit-{{ $s->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Ukuran</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('size.update', $s->id) }}" method="POST" class="swal-loading">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Ukuran</label>
                                                                    <input type="text" name="size_label" class="form-control" value="{{ $s->size_label }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Delete pakai SweetAlert -->
                                            <form id="delete-form-{{ $s->id }}" action="{{ route('size.destroy', $s->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $s->id }}"
                                                        data-name="{{ $s->size_label }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada ukuran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add -->
<div class="modal fade" id="modal-add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Ukuran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('size.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Ukuran</label>
                        <input type="text" name="size_label" class="form-control" placeholder="Masukkan Ukuran..." required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ✅ 1. SweetAlert sukses untuk Create / Update / Delete
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // ✅ 2. SweetAlert konfirmasi hapus ukuran
    // **Perbaikan di sini:** Menggunakan selector .delete-btn agar sesuai dengan HTML.
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const sizeId = this.getAttribute('data-id');
            const sizeName = this.getAttribute('data-name');
            
            // Cari form delete berdasarkan ID ukuran dan simpan referensinya
            const formToDelete = document.getElementById(`delete-form-${sizeId}`);

            // Cek apakah form ditemukan
            if (!formToDelete) {
                console.error(`Form delete untuk ID ${sizeId} tidak ditemukan!`);
                Swal.fire('Error!', 'Form untuk menghapus data tidak ditemukan.', 'error');
                return;
            }

            Swal.fire({
                title: 'Yakin hapus ukuran?',
                text: `Ukuran "${sizeName}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan SweetAlert loading sebelum submit
                    Swal.fire({
                        title: 'Sedang menghapus...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Submit form yang sudah di-cache/ditemukan (formToDelete)
                    formToDelete.submit();
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
{{-- END OF SIZE OPTIONS SCRIPT --}}

@endsection
