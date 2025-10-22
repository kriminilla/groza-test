@extends('admin.partials.master')

@section('title', 'GROZA | Tambah Event')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">Tambah Event</h1>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Tambah Event</li>
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
                        <h3 class="card-title">Form Tambah Event</h3>
                    </div>
                    
                    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="swal-loading" id="formEvent">
                        @csrf
                        <div class="card-body">
                            <!-- Judul Kegiatan -->
                            <div class="form-group">
                                <label for="title">Judul Kegiatan</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" placeholder="Masukkan title kegiatan" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kegiatan -->
                            <div class="form-group">
                                <label for="event_date">Tanggal Kegiatan</label>
                                <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                                       id="event_date" value="{{ old('event_date') }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Tulis deskripsi kegiatan">{{ old('description') }}</textarea>
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
                                    @foreach($categories as $item)
                                        <option value="{{ $item->id }}" {{ old('category_event_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cover -->
                            <div class="form-group">
                                <label for="cover">Cover (Maksimal 20MB)</label>
                                <input type="file" name="cover" id="cover" class="form-control-file @error('cover') is-invalid @enderror"
                                       accept="image/*">
                                @error('cover')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Galeri -->
                            <div class="form-group">
                                <label for="galleries">Galeri (Bisa lebih dari 1, Maksimal 20MB per gambar)</label>
                                
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
                            </div>
                        </div>
                        
                        <!-- Tombol Submit -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('event.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('galleries-container');
    const addBtn = document.getElementById('add-galleries');

    addBtn.addEventListener('click', function() {
        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mb-2');
        inputGroup.innerHTML = `
            <input type="file" name="galleries[]" class="form-control-file" accept="image/*">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-galleries"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(inputGroup);
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-galleries')) {
            e.target.closest('.input-group').remove();
        }
    });

    // ✅ Validasi sebelum submit pakai SweetAlert
    const form = document.getElementById('formEvent');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const title = document.getElementById('title').value.trim();
        const eventDate = document.getElementById('event_date').value.trim();
        const desc = document.getElementById('description').value.trim();
        const category = document.getElementById('category_event_id').value.trim();

        if (!title || !eventDate || !desc || !category) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Mohon isi semua field yang wajib diisi!',
            });
            return;
        }

        // ✅ Jika valid, tampilkan loading swal dan submit form
        Swal.fire({
            title: 'Sedang menyimpan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                form.submit();
            }
        });
    });
});
</script>
@endsection
