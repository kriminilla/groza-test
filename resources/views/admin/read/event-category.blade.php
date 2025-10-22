@extends('admin.partials.master')

@section('title', 'GROZA | KATEGORI EVENT')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Kategori Event</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kategori Event</li>
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

                    <!-- Header Card -->
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
                            <button class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-create">
                                <i class="fas fa-plus"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>

                    <!-- Body Card -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width:70%">Nama Kategori</th>
                                    <th style="width:30%">Actions</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @forelse($category as $item)
                                <tr>
                                    <td>{{ $item->category_name }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <!-- Tombol Delete -->
                                        <form action="{{ route('eventcategory.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form" 
                                              data-nama="{{ $item->category_name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modal-edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('eventcategory.update', $item->id) }}" method="POST" class="swal-loading">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Kategori Event</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Kategori</label>
                                                        <input type="text" name="category_name" class="form-control" value="{{ $item->category_name }}" required>
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
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">
                                            <i class="fas fa-info-circle mr-2"></i> Belum ada kategori event.
                                        </td>
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

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('eventcategory.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kategori Event</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori Event</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Masukkan Kategori Baru..." required>
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

    // ✅ SweetAlert konfirmasi hapus kategori
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const nama = form.getAttribute('data-nama');

            Swal.fire({
                title: 'Yakin hapus kategori?',
                text: `Kategori "${nama}" akan dihapus permanen.`,
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