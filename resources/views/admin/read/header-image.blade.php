@extends('admin.partials.master')

@section('title', 'GROZA | HEADER IMAGE')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Header Image per Subkategori</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Header Image</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    @if(session('success'))
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
          });
        });
      </script>
    @endif

    <div class="card card-dark">
      <div class="card-header">
        <h4 class="card-title">Daftar Subkategori & Hero Product</h4>
      </div>

      <div class="card-body">
        <div class="row">
          @forelse($subcategories as $sub)
            <div class="col-md-4 mb-4">
              <div class="card h-100">
                <img src="{{ asset($sub->header_image ?? 'img/no-image.png') }}" class="card-img-top" alt="{{ $sub->nama_subkategori }}">
                <div class="card-body text-center">
                  <h5>{{ $sub->subcategory_name }} - {{ $sub->category->category_name ?? '-' }}</h5>
                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit-{{ $sub->id }}">
                    <i class="fas fa-edit"></i> Ganti Gambar
                  </button>
                </div>
              </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="modal-edit-{{ $sub->id }}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="{{ route('headerimage.update', $sub->id) }}" method="POST" enctype="multipart/form-data" class="swal-loading">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                      <h5>Ganti Gambar Hero - {{ $sub->subcategory_name }}</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Upload Gambar Baru</label>
                        <input type="file" name="header_image" class="form-control" required>
                        <small class="form-text text-muted">Format: jpg, jpeg, png, webp (maks 2MB)</small>
                      </div>
                      <div class="text-center">
                        <img src="{{ asset($sub->header_image ?? 'img/no-image.png') }}" class="img-fluid rounded" alt="{{ $sub->subcategory_name }}">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center text-muted">Belum ada subkategori.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ✅ Loading saat submit
    const forms = document.querySelectorAll('.swal-loading');
    forms.forEach(form => {
      form.addEventListener('submit', function () {
        Swal.fire({
          title: 'Sedang menyimpan...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
      });
    });
  });
</script>

@endsection

