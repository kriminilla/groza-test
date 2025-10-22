{{-- resources/views/admin/update/artikel.blade.php --}}
@extends('admin.partials.master')

@section('title', 'Edit Artikel: ' . $article->title)

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Artikel: {{ $article->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Formulir Edit Artikel</h3>
                    </div>

                    {{-- Gunakan method PUT/PATCH dan enctype untuk upload file --}}
                    <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Hidden field untuk ID galeri yang akan dihapus --}}
                        <input type="hidden" name="galleries_deleted_ids" id="galleries-deleted-ids" value="">

                        <div class="card-body">

                            {{-- 1. INPUT UTAMA ARTIKEL --}}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Judul Artikel <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title', $article->title) }}" required>
                                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- 2. COVER UTAMA ARTIKEL --}}
                            <div class="form-group">
                                <label>Gambar Cover Utama</label>
                                <p class="mb-2">Gambar Saat Ini: <br>
                                <img src="{{ asset('storage/' . $article->image) }}" alt="" style="width: 30%; height:auto;">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Pilih file baru (Kosongkan jika tidak diubah)...</label>
                                </div>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 3. KONTEN ARTIKEL (SUMMERNOTE) --}}
                            <div class="form-group">
                                <label for="summernote">Konten Artikel <span class="text-danger">*</span></label>
                                <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                                @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <hr>

                            {{-- 4. GALERI ARTIKEL --}}
                            <h5>Galeri Tambahan</h5>
                            
                            {{-- Tampilkan error galeri global jika ada --}}
                            @error('galleries_new') 
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('galleries_existing') 
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div id="galleries-container">
                                
                                {{-- Galeri yang sudah ada --}}
                                @foreach (old('galleries_existing', $article->galleries->keyBy('id')) as $galleriesId => $galleriesItem)
                                    @php
                                        // $galleriesItem bisa berupa Model (jika dari $article->galeri) atau array (jika dari old())
                                        $caption = is_array($galleriesItem) ? ($galleriesItem['caption'] ?? '') : $galleriesItem->caption;
                                        $src = is_array($galleriesItem) ? ($galleriesItem['src'] ?? '') : $galleriesItem->src;
                                    @endphp
                                    <div class="form-group row galleries-item existing-galleries border border-warning p-2 mb-2" data-id="{{ $galleriesId }}">
                                        
                                        <div class="col-md-5">
                                            <label>Gambar Saat Ini</label> <br>
                                            <img src="{{ asset('storage/' . $src) }}" alt="Galleries" style="width: 60%; height: auto; object-fit: cover;">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label>Caption</label>
                                            {{-- Penamaan input untuk existing: galleries_existing[ID_GALERI][caption] --}}
                                            <input type="text" name="galleries_existing[{{ $galleriesId }}][caption]" class="form-control @error('galleries_existing.' . $galleriesId . '.caption') is-invalid @enderror" placeholder="Caption Opsional" value="{{ $caption }}">
                                            @error('galleries_existing.' . $galleriesId . '.caption') 
                                                <small class="text-danger">{{ $message }}</small> 
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-existing-galleries">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Galeri Baru - Untuk retensi data error validasi --}}
                                @php
                                    // Ambil galeri baru dari old() jika ada error
                                    $oldNewGalleries = old('galleries_new', []);
                                @endphp
                                @foreach ($oldNewGalleries as $index => $galleriesItem)
                                    <div class="form-group row galleries-item new-galleries border border-light p-2 mb-2">
                                        <div class="col-md-5">
                                            <label>File Gambar Baru</label>
                                            <input type="file" name="galleries_new[{{ $index }}][src]" class="form-control @error('galleries_new.' . $index . '.src') is-invalid @enderror" accept="image/*">
                                            @error('galleries_new.' . $index . '.src') 
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>Caption</label>
                                            <input type="text" name="galleries_new[{{ $index }}][caption]" class="form-control @error('galleries_new.' . $index . '.caption') is-invalid @enderror" placeholder="Opsional" value="{{ $galleriesItem['caption'] ?? '' }}">
                                            @error('galleries_new.' . $index . '.caption') 
                                                <small class="text-danger">{{ $message }}</small> 
                                            @enderror
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-new-galleries">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" id="add-new-galleries" class="btn btn-sm btn-success mb-3"><i class="fas fa-plus"></i> Tambah Gambar Baru</button>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">Perbarui Artikel</button>
                            <a href="{{ route('article.index') }}" class="btn btn-default float-right">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- Bagian JS (Summernote dan Dynamic Form Logic) --}}
@section('scripts')
<script>
$(document).ready(function() {
    // 1. Inisialisasi Summernote
    $('#summernote').summernote({
        placeholder: 'Tulis konten artikel di sini...',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['help']]
        ],
        callbacks: {
        onImageUpload: function(files) {
            // Fungsi yang dipanggil saat gambar di-drag atau di-paste
            for(let i = 0; i < files.length; i++) {
                uploadImage(files[i]);
            }
        }
    }
    });
    
    function uploadImage(file) {
        let data = new FormData();
        data.append("file", file); // Nama harus 'file' sesuai di controller
        data.append("_token", '{{ csrf_token() }}'); 
        
        // Kirim file ke endpoint Laravel
        $.ajax({
            // GANTI BAGIAN INI: Gunakan route khusus upload
            url: '{{ route('article.uploadimage') }}', 
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                // Setelah berhasil, masukkan URL gambar ke editor
                // response.url akan berisi URL publik dari Storage::url()
                $('#summernote').summernote('insertImage', response.url);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Gagal mengupload gambar:", errorThrown);
                // Tambahkan alert agar Anda tahu kenapa gagal
                alert("Gagal mengupload gambar. Cek Console Log."); 
            }
        });
    }


    // 2. Custom file input label untuk cover utama
    $(document).on('change', '#gambar', function (event) {
        const fileName = event.target.files.length > 0 ? event.target.files[0].name : 'Pilih file baru...';
        $(this).next('.custom-file-label').html(fileName);
    });

    // 3. Dynamic gallery for NEW items
    // Mulai index baru dari jumlah total old new items + 1
    let galleriesNewIndex = {{ count(old('galleries_new', [])) }};
    let deletedIds = []; // Array untuk menyimpan ID galeri yang akan dihapus

    // A. Hapus Galeri Baru yang Belum Disimpan
    $(document).on('click', '.remove-new-galleries', function() {
        const item = $(this).closest('.new-galleries');
    
        Swal.fire({
            title: 'Hapus Gambar Baru?',
            text: 'Gambar ini belum disimpan, tapi akan dihapus dari formulir.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                item.fadeOut(400, function() {
                    $(this).remove();
                });
    
                Swal.fire({
                    icon: 'success',
                    title: 'Dihapus!',
                    text: 'Gambar baru dihapus dari formulir.',
                    timer: 1200,
                    showConfirmButton: false
                });
            }
        });
    });

    // B. Tambah Galeri Baru
    $('#add-new-galleries').click(function() {
        const newField = `
            <div class="form-group row galleries-item new-galleries border border-light p-2 mb-2">
                <div class="col-md-5">
                    <input type="file" name="galleries_new[${galleriesNewIndex}][src]" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="galleries_new[${galleriesNewIndex}][caption]" class="form-control" placeholder="Opsional">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-new-galleries">Hapus</button>
                </div>
            </div>
        `;
        $('#galleries-container').append(newField);
        galleriesNewIndex++;
    });

    // C. Hapus Galeri yang Sudah Ada (Existing)
    $(document).on('click', '.remove-existing-galleries', function() {
        const item = $(this).closest('.existing-galleries');
        const galleriesId = item.data('id');
    
        Swal.fire({
            title: 'Hapus Gambar?',
            text: 'Gambar ini akan dihapus permanen setelah kamu menyimpan perubahan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tambahkan ID ke daftar deleted
                if (!deletedIds.includes(galleriesId)) {
                    deletedIds.push(galleriesId);
                    $('#galleries-deleted-ids').val(deletedIds.join(','));
                }
    
                // Hapus elemen dari DOM
                item.fadeOut(400, function() {
                    $(this).remove();
                });
    
                Swal.fire({
                    icon: 'success',
                    title: 'Dihapus!',
                    text: `Gambar ID ${galleriesId} telah ditandai untuk dihapus.`,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // ✅ Konfirmasi sebelum submit form update artikel
    $('form').on('submit', function(e) {
        e.preventDefault(); // cegah submit langsung
    
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Pastikan semua data sudah benar sebelum menyimpan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik "Ya, simpan!"
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
    
                // Submit form setelah 400ms biar animasi sempat jalan
                setTimeout(() => {
                    e.target.submit();
                }, 400);
            }
        });
    });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Saat ada perubahan file
    document.querySelectorAll('.custom-file-input').forEach(function (input) {
        input.addEventListener('change', function (e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
            let label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });
});
</script>
@endsection