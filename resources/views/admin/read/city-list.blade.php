@extends('admin.partials.master')

@section('title', 'ADMIN GROZA | DAFTAR KOTA')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Kota</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kota</li>
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
                    {{-- Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari kota...">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-create">
                                <i class="fas fa-plus"></i> Tambah Kota
                            </button>
                        </div>
                    </div>

                    {{-- Tabel data --}}
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Kota</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($city as $item)
                                    <tr>
                                        <td>{{ $item->city_name }}</td>
                                        <td>{{ $item->province->province_name ?? '-' }}</td>
                                        <td class="text-center">
                                            {{-- Tombol Edit --}}
                                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#modal-edit-{{ $item->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                            
                                            {{-- Tombol Delete --}}
                                            <form id="delete-form-{{ $item->id }}" 
                                                  action="{{ route('city.destroy', $item->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->city_name }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modal-edit-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('city.update', $item->id) }}" method="POST" class="swal-loading">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Kota</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Kota</label>
                                                            <input type="text" name="city_name" value="{{ $item->city_name }}" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select name="province_id" class="form-control" required>
                                                                <option value="">-- Pilih Provinsi --</option>
                                                                @foreach($provinces as $prov)
                                                                    <option value="{{ $prov->id }}" 
                                                                        {{ $item->province_id == $prov->id ? 'selected' : '' }}>
                                                                        {{ $prov->province_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            <i class="fas fa-times mr-1"></i> Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data kota</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- /.card-body --}}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal Create --}}
<div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('city.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kota Baru</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kota</label>
                        <input type="text" name="city_name" class="form-control" placeholder="Masukkan nama kota..." required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="province_id" class="form-control" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CITIES SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Konfirmasi hapus dengan SweetAlert
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            let form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus kota ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
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

    // Notifikasi sukses (jika ada session)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
});
</script>
{{-- END OF CITIES SCRIPT --}}

@endsection


