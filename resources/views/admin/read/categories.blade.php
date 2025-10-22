@extends('admin.partials.master')

@section('title', 'GROZA | KATEGORI')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i> Tambah Kategori
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category as $item)
                                    <tr>
                                        <td>{{ $item->category_name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <div class="modal fade" id="modal-edit-{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Kategori</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('category.update', $item->id) }}" method="POST" class="swal-loading">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="editNama{{ $item->id }}">Nama Kategori</label>
                                                                    <input type="text" name="category_name" class="form-control" id="editNama{{ $item->id }}" value="{{ $item->category_name }}" required>
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

                                            <form id="delete-form-{{ $item->id }}" action="{{ route('category.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                {{-- Ganti type="submit" menjadi type="button" dan tambahkan class delete-btn --}}
                                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->category_name }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada kategori</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('category.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputKategori">Nama Kategori</label>
                        <input type="text" name="category_name" class="form-control" id="inputKategori" placeholder="Masukkan Kategori..." required>
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

{{-- Script SWAL for Category Lists --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // ==========================================================
        // 1. Tampilkan SweetAlert Success (untuk Create/Update/Delete)
        // ==========================================================
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // ==========================================================
        // 2. SweetAlert Konfirmasi Hapus
        // ==========================================================
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const kategoriId = this.getAttribute('data-id');
                const kategoriNama = this.getAttribute('data-nama'); 
                const form = document.getElementById(`delete-form-${kategoriId}`);
                
                Swal.fire({
                    title: 'Yakin hapus kategori?',
                    text: `Anda akan menghapus kategori: ${kategoriNama}. Tindakan ini tidak dapat dibatalkan!`, 
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33', // Warna merah untuk hapus
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
                        
                        // Submit form penghapusan
                        form.submit(); 
                    }
                });
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
</script>
{{-- End of Script SWAL for Category Lists --}}
@endsection

