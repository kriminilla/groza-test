@extends('admin.partials.master')

@section('title', 'GROZA | ARTIKEL')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Daftar Artikel</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Artikel</li>
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
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Search -->
                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                <input type="text" id="searchInput" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Kolom Kanan: Tambah Artikel --}}
                            <a href="{{ route('article.create') }}" class="btn btn-primary btn-sm ml-2">
                                <i class="fas fa-plus"></i> Tambah Artikel
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 3%">No.</th>
                                    <th>Judul</th>
                                    <th style="width: 20%">Penulis</th>
                                    <th style="width: 15%">Tanggal Publikasi</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- LOOPING DATA DARI CONTROLLER ($articles) --}}
                                @forelse ($articles as $a)
                                <tr>
                                    <td>{{ $loop->iteration + ($articles->perPage() * ($articles->currentPage() - 1)) }}</td>
                                    <td>{{ Str::limit($a->title, 60) }}</td>
                                    <td>{{ $a->admin->name ?? 'Admin Terhapus' }}</td>
                                    <td>{{ $a->created_at->format('d F Y') }}</td>
                                    
                                    <td class="text-center">
                                        {{-- BUTTON DETAILS --}}
                                        <a href="{{ route('article.show', $a->slug) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        {{-- BUTTON EDIT --}}
                                        <a href="{{ route('article.edit', $a->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- BUTTON DELETE --}}
                                        <form action="{{ route('article.destroy', $a->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form" 
                                              data-title="{{ $a->title }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle mr-2"></i> Tidak ada data artikel yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="card-footer clearfix">
                        {{ $articles->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

    @if (session()->has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // ✅ SweetAlert konfirmasi hapus artikel
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const title = form.getAttribute('data-title');

            Swal.fire({
                title: 'Yakin hapus artikel?',
                text: `Artikel "${title}" akan dihapus permanen.`,
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

});
</script>
@endsection
