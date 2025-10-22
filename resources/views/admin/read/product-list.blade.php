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
            
            {{-- HEADER BAR: Search | Filter Kategori | Tombol Tambah --}}
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex flex-wrap align-items-center flex-grow-1 mb-2 mb-md-0" style="gap: 10px;">
                        {{-- SEARCH --}}
                        <div id="datatables-search-container" class="flex-grow-1"></div>
            
                        {{-- FILTER KATEGORI --}}
                        <select id="filterKategori" class="form-control form-control-sm mr-2" style="width: 200px;">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($category as $cat)
                                <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- TOMBOL TAMBAH PRODUK --}}
                    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>


            <div class="card-body">
                <table id="TableProduct" class="table table-bordered table-hover">
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
                                        - {{ $item->subcategory->subcategory_name }}
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
                </table>
            </div>
        </div>
    </div>
</section>

{{-- SCRIPT PRODUCT LIST --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert Success
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Inisialisasi DataTables
    const table = $('#TableProduct').DataTable({
        responsive: true,
        autoWidth: false,
        dom: "<'row'<'col-md-12'f>>rt<'row'<'col-md-12'p>>",
        language: {
            search: "",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari total _MAX_ data)"
        },
        columnDefs: [
            { orderable: false, targets: 2, className: 'text-center text-nowrap' }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Detail Produk: ' + data[0].match(/<img[^>]*>([\s\S]*)/i)[1].trim();
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({ tableClass: 'table table-sm' })
            }
        }
    });

    // Pindahkan search ke container custom
    $('.dataTables_filter').appendTo('#datatables-search-container');
    $('#TableProduct_filter label').contents().filter(function() {
        return this.nodeType === 3;
    }).remove();
    $('#TableProduct_filter input')
        .attr('placeholder', 'Cari Produk')
        .addClass('form-control form-control-sm')
        .css('width', '200px');

    // Filter kategori
    $('#filterKategori').on('change', function () {
        table.column(1).search($(this).val()).draw();
    });

    // SweetAlert Konfirmasi Hapus
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-nama');
            const form = document.getElementById(`delete-form-${productId}`);

            Swal.fire({
                title: 'Yakin hapus produk?',
                text: `Anda akan menghapus produk: ${productName}. Data yang dihapus tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
{{-- END OF PRODUCT LIST --}}

@endsection
