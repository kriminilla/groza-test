@extends('admin.partials.master')

@section('title', 'GROZA | DAFTAR PRODUK')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Produk</li>
                    <li class="breadcrumb-item active">Daftar Produk</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            
            {{-- HEADER BAR: Search + Filter + Tambah --}}
            <div class="card-header">
                <div class="d-flex align-items-center">
                    {{-- PENCARIAN --}}
                    <div class="input-group input-group-sm mr-2" style="width: 200px;">
                        <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    {{-- FILTER SUBKATEGORI --}}
                    <div class="mr-2">
                        <select id="filterSubkategori" class="form-control form-control-sm">
                            <option value="">-- Semua Subkategori --</option>
                            @foreach ($subcategories as $sub)
                                <option value="{{ strtolower($sub->subcategory_name) }}">{{ $sub->subcategory_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TOMBOL TAMBAH PRODUK --}}
                    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>

            {{-- TABLE PRODUK --}}
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori/Subkategori</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->image && file_exists(public_path('storage/' . $item->image)))
                                            <a href="{{ asset('storage/' . $item->image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Product Image" class="img-size-50 mr-2">
                                            </a>
                                        @else
                                            <img src="{{ asset('img/no-image.png') }}" alt="No Image" class="img-size-50 mr-2">
                                        @endif
                                        {{ $item->product_name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $item->category->category_name ?? '-' }}
                                    @if($item->subcategory)
                                        - <span class="subkategori-text">{{ $item->subcategory->subcategory_name }}</span>
                                    @else
                                        <span class="subkategori-text">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('product.show', ['product' => $item->id]) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i> Details
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('product.destroy', ['product' => $item->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $item->id }}" data-nama="{{ $item->product_name }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori/Subkategori</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- SCRIPT SWEETALERT + FILTER --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // === FILTER SUBKATEGORI ===
    const filterSelect = document.getElementById('filterSubkategori');
    const tableRows = document.querySelectorAll('#example2 tbody tr');

    filterSelect.addEventListener('change', function () {
        const selected = this.value.toLowerCase();
        tableRows.forEach(row => {
            const subkategoriCell = row.querySelector('.subkategori-text');
            const subkategoriName = subkategoriCell ? subkategoriCell.innerText.trim().toLowerCase() : '';

            // Filter logic
            if (!selected || subkategoriName === selected) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

            // Pastikan baris "Belum ada produk" tetap tampil
            if (row.children.length === 1 && row.children[0].colSpan > 1) {
                row.style.display = '';
            }
        });
    });

    // === SweetAlert Success ===
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // === SweetAlert Konfirmasi Hapus ===
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-nama');
            const form = document.getElementById(`delete-form-${productId}`);

            Swal.fire({
                title: 'Yakin hapus produk?',
                text: `Anda akan menghapus produk: ${productName}. Tindakan ini tidak dapat dibatalkan!`,
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
});
</script>

@endsection
