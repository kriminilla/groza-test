@extends('admin.partials.master')

@section('title', 'GROZA | SUBKATEGORI')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sub-Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sub-Kategori</li>
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
                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mr-2">
                                <select id="filterKategori" class="form-control form-control-sm">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->category_name }}">{{ $c->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <a href="#" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i> Tambah Sub-Kategori
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Sub-Kategori</th>
                                    <th>Kategori</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subcategories as $item)
                                    <tr>
                                        <td>{{ $item->subcategory_name }}</td>
                                        {{-- PERBAIKAN: Menggunakan optional chaining (?->) untuk mencegah error jika relasi 'category' null --}}
                                        <td>{{ $item->category?->category_name ?? 'Tidak Terkait' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-{{ $item->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <div class="modal fade" id="modal-edit-{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Sub-Kategori</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        {{-- Perhatikan penamaan relasi di model Anda adalah 'category' bukan 'categories'. Saya gunakan 'category' --}}
                                                        <form action="{{ route('subcategory.update', $item->id) }}" method="POST" class="swal-loading">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="editNama{{ $item->id }}">Nama Sub-Kategori</label>
                                                                    <input type="text" name="subcategory_name" class="form-control" id="editNama{{ $item->id }}" value="{{ old('subcategory_name', $item->subcategory_name) }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="editKategori{{ $item->id }}">Kategori</label>
                                                                    {{-- Perbaikan: Mengubah name dari kategori_id menjadi category_id --}}
                                                                    <select name="category_id" id="editKategori{{ $item->id }}" class="form-control" required>
                                                                        @foreach($categories as $cat)
                                                                            <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
                                                                                {{ $cat->category_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
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

                                            <form id="delete-form-{{ $item->id }}" action="{{ route('subcategory.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->subcategory_name }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada sub-kategori</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Sub-Kategori</th>
                                    <th>Kategori</th>
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
                <h4 class="modal-title">Tambah Sub-Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subcategory.store') }}" method="POST" class="swal-loading">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputSubKategori">Nama Sub-Kategori</label>
                        <input type="text" name="subcategory_name" class="form-control" id="inputSubKategori" placeholder="Masukkan Sub-Kategori..." required>
                    </div>
                    <div class="form-group">
                        <label for="inputKategori">Kategori</label>
                        {{-- Perbaikan: Mengubah name dari kategori_id menjadi category_id --}}
                        <select name="category_id" id="inputKategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
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

{{-- Script JS dan SweetAlert tetap sama, tapi disarankan diletakkan di bagian akhir file Blade. --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === FILTER KATEGORI ===
    const filterSelect = document.getElementById('filterKategori');
    const tableRows = document.querySelectorAll('#example2 tbody tr');

    filterSelect.addEventListener('change', function () {
        const selected = this.value.toLowerCase();
        tableRows.forEach(row => {
            // PERBAIKAN: Ambil teks kategori dari kolom ke-2
            const categoryCell = row.children[1]; 
            // Pastikan elemen ada dan ambil teksnya
            const categoryName = categoryCell ? categoryCell.innerText.trim().toLowerCase() : ''; 
            
            // Logika filter (mengabaikan baris jika tidak ada teks kategori dan filter tidak dipilih)
            if (!selected || categoryName === selected) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            
            // Tambahan: Pastikan juga baris 'Belum ada sub-kategori' (colspan) tidak difilter
            if (row.children.length === 1 && row.children[0].colSpan > 1) {
                row.style.display = '';
            }
        });
    });

    // === SweetAlert Success untuk Create / Update / Delete ===
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    
    // === SweetAlert Konfirmasi Hapus Sub-Kategori ===
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const subId = this.getAttribute('data-id');
            const subNama = this.getAttribute('data-nama');
            const form = document.getElementById(`delete-form-${subId}`);

            Swal.fire({
                title: 'Yakin hapus sub-kategori?',
                text: `Anda akan menghapus sub-kategori: ${subNama}. Tindakan ini tidak dapat dibatalkan!`,
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

    // === SweetAlert loading saat form disubmit (misalnya create/update) ===
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