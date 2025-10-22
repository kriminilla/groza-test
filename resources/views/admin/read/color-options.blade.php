@extends('admin.partials.master')

@section('title', 'GROZA | OPSI WARNA')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Opsi Warna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Produk</li>
                    <li class="breadcrumb-item active">Opsi Warna</li>
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
                    <div class="card-header d-flex align-items-center">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-add">
                            <i class="fas fa-plus"></i> Tambah Warna
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Warna</th> 
                                    <th>Kode Warna</th>
                                    <th>Preview</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($colorOptions as $c)
                                <tr>
                                    <td>{{ $c->color_name }}</td>
                                    <td>{{ $c->color_code }}</td>
                                    <td>
                                        <span style="background-color: {{ $c->color_code }}; display: block; width: 40px; height: 20px; border: 1px solid #ccc;"></span>
                                    </td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $c->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <!-- Tombol Delete pakai SweetAlert -->
                                        <form id="delete-form-{{ $c->id }}" action="{{ route('color.destroy', $c->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $c->id }}"
                                                    data-name="{{ $c->color_name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modal-edit-{{ $c->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('color.update', $c->id) }}" method="POST" class="swal-loading">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Warna</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Warna</label>
                                                        <input type="text" name="color_name" class="form-control" value="{{ $c->color_name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kode Warna</label>
                                                        <input type="text" name="color_code" class="form-control" value="{{ $c->color_code }}" required>
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
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada warna</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Warna</th>
                                    <th>Kode Warna</th>
                                    <th>Preview</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal-add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('color.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Warna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Warna</label>
                        <input type="text" name="color_name" class="form-control" placeholder="Masukkan Warna Baru..." required>
                    </div>
                    <div class="form-group">
                        <label>Kode Warna</label>
                        <input type="text" name="color_code" class="form-control" placeholder="contoh: #000000 atau red" required>
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

{{-- COLOR OPTIONS SCRIPT --}}
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

    // ✅ 2. SweetAlert konfirmasi hapus warna
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const warnaId = this.getAttribute('data-id');
            const warnaNama = this.getAttribute('data-name');
            const form = document.getElementById(`delete-form-${warnaId}`);

            Swal.fire({
                title: 'Yakin hapus warna?',
                text: `Warna "${warnaNama}" akan dihapus secara permanen!`,
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
{{-- END OF COLOR OPTIONS SCRIPT --}}

@endsection

