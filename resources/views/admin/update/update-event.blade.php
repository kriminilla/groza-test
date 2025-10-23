 @extends('admin.partials.master')

@section('title', 'GROZA | Edit Event')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Edit Event</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Edit Event</li>
                </ol>
            </div>
        </div>
    </div> 
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Event</h3>
                    </div>
                    
                    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="swal-loading">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Judul Kegiatan -->
                            <div class="form-group">
                                <label for="title">Judul Kegiatan</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kegiatan -->
                            <div class="form-group">
                                <label for="event_date">Tanggal Kegiatan</label>
                                <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                                       id="event_date" value="{{ old('event_date', $event->event_date) }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                          required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori Event -->
                            <div class="form-group">
                                <label for="category_event_id">Kategori Event</label>
                                <select name="category_event_id" id="category_event_id" 
                                        class="form-control @error('category_event_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_event_id', $event->category_event_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cover -->
                            <div class="form-group">
                                <label for="cover">Cover (Maksimal 20MB)</label><br>
                                @if($event->cover)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $event->cover) }}" alt="Cover" width="200" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="cover" id="cover" class="form-control-file @error('cover') is-invalid @enderror" accept="image/*">
                                @error('cover')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti cover.</small>
                            </div>
                            <!-- Galeri -->
                            <div class="form-group">
                                <label for="gallery">Galeri (Bisa lebih dari 1, Maksimal 20MB per gambar)</label>
                                
                                <!-- Tampilkan galeri lama -->
                                {{-- @if($event->galleries && $event->galleries->count() > 0)
                                    <div class="mb-3 d-flex flex-wrap">
                                        @foreach($event->galleries as $g)
                                            <div class="p-1">
                                                <img src="{{ asset('storage/' . $g->image) }}" alt="Galeri" width="120" class="img-thumbnail">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif --}}

                                <!-- Galeri Lama -->
                                @if($event->galleries && $event->galleries->count() > 0)
                                    <div class="mb-3 d-flex flex-wrap">
                                        @foreach($event->galleries as $g)
                                            <div class="p-2 text-center old-gallery-item" style="position: relative;">
                                                <img src="{{ asset('storage/' . $g->image) }}" alt="Galeri" width="120" class="img-thumbnail mb-1">
                                                <button type="button" class="btn btn-danger btn-sm delete-old-gallery" data-id="{{ $g->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Hidden field untuk galeri yang dihapus -->
                                <input type="hidden" name="deleted_galleries" id="deleted_galleries">

                            
                                <div id="galleries-container">
                                    <div class="input-group mb-2">
                                        <input type="file" name="galleries[]" class="form-control-file @error('galleries.*') is-invalid @enderror" accept="image/*">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-galleries d-none"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            
                                <button type="button" id="add-galleries" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Gambar</button>
                            
                                @error('galleries.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Biarkan kosong jika tidak ingin menambah galeri baru.</small>
                            </div>              
                        </div>
                        
                        <!-- Tombol Submit -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('event.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Maksimal ukuran file (20MB)
    const maxSize = 3 * 1024 * 1024;

    // 🔹 Validasi Cover Utama
    const coverInput = document.getElementById('cover');
    if (coverInput) {
        coverInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file && file.size > maxSize) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran File Terlalu Besar!',
                    html: `Gambar cover tidak boleh lebih dari <b>${Math.round(maxSize / (1024 * 1024))} MB</b>.<br>
                           File kamu sekarang berukuran <b>${(file.size / (1024 * 1024)).toFixed(2)} MB</b>`,
                    confirmButtonColor: '#ff6600'
                });
                e.target.value = ''; // reset input
            }
        });
    }

    // 🔹 Validasi Galeri
    $(document).on('change', 'input[name="galleries[]"]', function (e) {
        const file = e.target.files[0];
        if (file && file.size > maxSize) {
            Swal.fire({
                icon: 'warning',
                title: 'Ukuran File Terlalu Besar!',
                html: `Gambar galeri tidak boleh lebih dari <b>${Math.round(maxSize / (1024 * 1024))} MB</b>.<br>
                       File kamu sekarang berukuran <b>${(file.size / (1024 * 1024)).toFixed(2)} MB</b>`,
                confirmButtonColor: '#ff6600'
            });
            e.target.value = ''; // reset input
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // === VARIABEL DASAR ===
    const container = document.getElementById('galleries-container');
    const addBtn = document.getElementById('add-galleries');
    let deleteList = []; // Simpan ID galeri lama yang ingin dihapus

    // === 🟢 TAMBAH INPUT GALERI BARU ===
    addBtn.addEventListener('click', function() {
        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mb-2');
        inputGroup.innerHTML = `
            <input type="file" name="galleries[]" class="form-control-file" accept="image/*" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-galleries"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(inputGroup);
    });

    // === 🔴 HAPUS INPUT GALERI BARU SEBELUM DISIMPAN ===
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-galleries')) {
            Swal.fire({
                title: 'Hapus gambar ini?',
                text: 'Gambar baru ini akan dihapus dari formulir.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    e.target.closest('.input-group').remove();
                }
            });
        }
    });

    // === 🔴 HAPUS GALERI LAMA YANG SUDAH ADA ===
    document.querySelectorAll('.delete-old-gallery').forEach(btn => {
        btn.addEventListener('click', function() {
            const galleryId = this.dataset.id;
            const wrapper = this.closest('.old-gallery-item');

            Swal.fire({
                title: 'Hapus gambar ini?',
                text: 'Gambar ini akan dihapus permanen setelah kamu menyimpan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    deleteList.push(galleryId);
                    document.getElementById('deleted_galleries').value = deleteList.join(',');
                    wrapper.remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: 'Gambar ditandai untuk dihapus.',
                        timer: 1200,
                        showConfirmButton: false
                    });
                }
            });
        });
    });

    // === 💾 KONFIRMASI SUBMIT (SweetAlert Loading) ===
    const form = document.querySelector('.swal-loading');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Pastikan semua data sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                setTimeout(() => form.submit(), 400);
            }
        });
    });
});
</script>

@endsection
