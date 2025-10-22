@extends('admin.partials.master')
@section('title', 'GROZA | LOKASI DISTRIBUTOR')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Lokasi Distributor</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header d-flex">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Lokasi Distributor...">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>  
                        <button class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-create-lokasi">
                            <i class="fas fa-plus"></i> Tambah Lokasi
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Distributor</th>
                                    <th>Alamat</th>
                                    <th>Kota, Provinsi</th>
                                    <th>Map</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distributorList as $dl)
                                    <tr>
                                        <td>{{ $dl->distributor_name }}</td>
                                        <td>{{ $dl->address }}</td>
                                        <td>{{ $dl->city->city_name ?? '-' }}, {{ $dl->province->province_name ?? '-' }}</td>
                                        <td>
                                            <iframe src="{{ $dl->map_link }}" width="200" height="120"
                                                style="border:0;" allowfullscreen loading="lazy"></iframe>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info"
                                                    data-toggle="modal"
                                                    data-target="#modal-edit-{{ $dl->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form id="deleteForm{{ $dl->id }}" 
                                                  action="{{ route('distributorlist.destroy', $dl->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $dl->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modal-edit-{{ $dl->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('distributorlist.update', $dl->id) }}" method="POST" class="swal-loading">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header">
                                                        <h5>Edit Lokasi Distributor</h5>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Distributor</label>
                                                            <input type="text" name="distributor_name"
                                                                   value="{{ $dl->distributor_name }}"
                                                                   class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <textarea name="address" class="form-control">{{ $dl->address }}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select name="province_id" class="form-control">
                                                                <option value="">-- Pilih Provinsi --</option>
                                                                @foreach($provinces as $p)
                                                                    <option value="{{ $p->id }}"
                                                                        {{ $dl->province_id == $p->id ? 'selected' : '' }}>
                                                                        {{ $p->province_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Kota</label>
                                                            <select name="city_id" class="form-control">
                                                                <option value="">-- Pilih Kota --</option>
                                                                @foreach($cities as $c)
                                                                    <option value="{{ $c->id }}"
                                                                        {{ $dl->city_id == $c->id ? 'selected' : '' }}>
                                                                        {{ $c->city_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Link Map</label>
                                                            <textarea name="map_link" class="form-control"
                                                                placeholder="Paste seluruh kode iframe Google Maps di sini, misal: <iframe src=...</iframe>">{{ $dl->map_link }}</textarea>
                                                            <small class="form-text text-muted">
                                                                Copy seluruh kode <strong>Embed Map</strong> (biasanya dimulai dengan <code>&lt;iframe...&gt;</code>) dari Google Maps.
                                                            </small>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data</td>
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

{{-- Modal Create --}}
<div class="modal fade" id="modal-create-lokasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('distributorlist.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Lokasi Distributor</h5>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Distributor</label>
                        <input type="text" name="distributor_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="province_id" class="form-control">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $p)
                                <option value="{{ $p->id }}">{{ $p->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kota</label>
                        <select name="city_id" class="form-control">
                            <option value="">-- Pilih Kota --</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->id }}">{{ $c->city_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Link Map</label>
                        <textarea name="map_link" class="form-control"
                            placeholder="Paste seluruh kode iframe Google Maps di sini, misal: <iframe src=...</iframe>"></textarea>
                        <small class="form-text text-muted">
                            Copy seluruh kode <strong>Embed Map</strong> (biasanya dimulai dengan <code>&lt;iframe...&gt;</code>) dari Google Maps.
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- LOCATIONS SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. SweetAlert sukses untuk Create / Update / Delete
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // 2. SweetAlert konfirmasi hapus lokasi
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const lokasiId = this.getAttribute('data-id');
            const form = document.getElementById(`deleteForm${lokasiId}`);

            Swal.fire({
                title: 'Yakin hapus lokasi?',
                text: 'Data lokasi ini akan dihapus secara permanen!',
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
                        didOpen: () => Swal.showLoading()
                    });
                    form.submit();
                }
            });
        });
    });

    // 3. Validasi + loading saat form create/update disubmit
    const validatedForms = document.querySelectorAll('.swal-loading');
    validatedForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const distributorName = e.target.querySelector('input[name="distributor_name"]').value.trim();
            const address = e.target.querySelector('textarea[name="address"]').value.trim();
            const province = e.target.querySelector('select[name="province_id"]').value;
            const city = e.target.querySelector('select[name="city_id"]').value;
            const mapLink = e.target.querySelector('textarea[name="map_link"]').value.trim();

            if (!distributorName || !address || !province || !city || !mapLink) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Form belum lengkap!',
                    text: 'Mohon isi semua field sebelum menyimpan.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            // Validasi iframe Google Maps (embed code)
            const iframeRegex = /^<iframe[^>]*src="https:\/\/www\.google\.com\/maps\/embed[^"]*"[^>]*><\/iframe>$/i;
            if (!iframeRegex.test(mapLink)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Format Map Salah!',
                    html: 'Mohon paste seluruh kode <b>Embed Map</b> dari Google Maps.<br><br>Contoh:<br><code>&lt;iframe src="https://www.google.com/maps/embed?...">&lt;/iframe&gt;</code>',
                    confirmButtonColor: '#d33',
                });
                return;
            }

            Swal.fire({
                title: 'Sedang menyimpan...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        });
    });

});
</script>

@endsection
