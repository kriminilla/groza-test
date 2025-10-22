@extends('admin.partials.master')

@section('title', 'GROZA | PROVINSI')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Provinsi</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Provinsi</li>
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
                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-create">
                                <i class="fas fa-plus"></i> Tambah Provinsi
                            </button>
                        </div>
                    </div>

                    <!-- Body Card -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width:70%">Nama Provinsi</th>
                                    <th style="width:30%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($province as $p)
                                <tr>
                                    <td>{{ $p->province_name }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $p->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <!-- Tombol Delete pakai SweetAlert -->
                                        <form id="delete-form-{{ $p->id }}" action="{{ route('province.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $p->id }}"
                                                    data-name="{{ $p->province_name }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modal-edit-{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('province.update', $p->id) }}" method="POST" class="swal-loading">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Provinsi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Provinsi</label>
                                                        <input type="text" name="province_name" class="form-control" value="{{ $p->province_name }}" required>
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
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Provinsi</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('province.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Provinsi</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Provinsi</label>
                        <input type="text" name="province_name" class="form-control" placeholder="Masukkan Provinsi Baru..." required>
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

{{-- PROVINCE SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Notifikasi sukses (jika ada session success)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

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

    // 🛑 KOREKSI: Konfirmasi hapus data
    // Kita targetkan tombol delete, lalu cari form terdekatnya
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            // Temukan form DELETE terdekat
            let form = this.closest('form'); 

            Swal.fire({
                title: 'Yakin hapus province ini?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading sebelum submit form
                    Swal.fire({
                        title: 'Sedang menghapus...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Submit form DELETE
                    form.submit();
                }
            });
        });
    });
});
</script>
{{-- END OF PROVINCE SCRIPT --}}

@endsection


