@extends('admin.partials.master')

@section('title', 'Buat Artikel Baru')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Buat Artikel Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item active">Buat Artikel Baru</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulir Artikel Baru</h3>
                    </div>

                    {{-- Pastikan enctype="multipart/form-data" untuk upload file --}}
                    <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data" class="swal-loading">
                        @csrf
                        <div class="card-body">

                            {{-- 1. INPUT UTAMA ARTIKEL --}}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Judul Artikel <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" required>
                                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- 2. COVER UTAMA ARTIKEL --}}
                            <div class="form-group">
                                <label for="image">Gambar Cover Utama <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    {{-- Tambahkan error class pada input file dan gunakan `old('image')` untuk mempertahankan data--}}
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*">
                                    {{-- Pastikan label menampilkan nama file lama jika ada error validasi file--}}
                                    <label class="custom-file-label" for="image">
                                        @if(old('image'))
                                            File telah dipilih
                                        @else
                                            Pilih file...
                                        @endif
                                    </label>
                                </div>
                                {{-- Display error secara terpisah untuk file --}}
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 3. KONTEN ARTIKEL (SUMMERNOTE) --}}
                            <div class="form-group">
                                <label for="summernote">Konten Artikel <span class="text-danger">*</span></label>
                                <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <hr>

                            {{-- 4. GALERI ARTIKEL (DYNAMIC INPUT) --}}
                            <h5>Galeri Tambahan</h5>
                            
                            {{-- Tampilkan error galleries global jika ada --}}
                            @error('galleries') 
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            
                            <div id="galleries-container">
                            @php
                                $oldGalleries = old('galleries', []);
                                if (empty($oldGalleries)) {
                                    $oldGalleries = [[]];
                                }
                            @endphp
                                @foreach ($oldGalleries as $index => $galleriesItem)
                                    <div class="form-group row galleries-item border border-light p-2 mb-2">
                                        
                                        <div class="col-md-5">
                                            <label>File Gambar</label>
                                            {{-- Perhatikan penamaan input: galleries[index][src] --}}
                                            <input type="file" name="galleries[{{ $index }}][src]" class="form-control @error('galleries.' . $index . '.src') is-invalid @enderror" accept="image/*">
                                            @error('galleries.' . $index . '.src') 
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label>Caption</label>
                                            {{-- Perhatikan penamaan input: galleries[index][caption] --}}
                                            <input type="text" name="galleries[{{ $index }}][caption]" class="form-control @error('galleries.' . $index . '.caption') is-invalid @enderror" placeholder="Opsional" value="{{ $galleriesItem['caption'] ?? '' }}">
                                            @error('galleries.' . $index . '.caption') 
                                                <small class="text-danger">{{ $message }}</small> 
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-galleries" style="display:{{ $index === 0 && count($oldGalleries) <= 1 ? 'none' : 'block' }};">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-galleries" class="btn btn-sm btn-success mb-3"><i class="fas fa-plus"></i> Tambah Gambar Galeri</button>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                            <a href="{{ route('article.index') }}" class="btn btn-default float-right">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection {{-- END SECTION CONTENT --}}

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
        data.append("file", file);
        data.append("_token", '{{ csrf_token() }}');
        
        // Kirim file ke endpoint Laravel
        $.ajax({
            url: '{{ route('article.store') }}', 
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                // Setelah berhasil, masukkan URL gambar ke editor
                $('#summernote').summernote('insertImage', response.url);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Gagal mengupload gambar:", errorThrown);
            }
        });
    }

    // 2. Custom file input label
    $(document).on('change', '#gambar', function (event) {
        const fileName = event.target.files.length > 0 ? event.target.files[0].name : 'Pilih file...';
        $(this).next('.custom-file-label').html(fileName);
    });

    // 3. Dynamic gallery
    let galleriesIndex = {{ count(old('galleries', [[]])) }};

    if ($('.galleries-item').length === 1) {
        $('.galleries-item:first').find('.remove-galleries').hide();
    } else {
        $('.galleries-item').find('.remove-galleries').show();
    }

    $('#add-galleries').click(function() {
        const newField = `
            <div class="form-group row galleries-item border border-light p-2 mb-2">
                <div class="col-md-5">
                    <label>File Gambar</label>
                    <input type="file" name="galleries[${galleriesIndex}][src]" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label>Caption</label>
                    <input type="text" name="galleries[${galleriesIndex}][caption]" class="form-control" placeholder="Opsional">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-galleries">Hapus</button>
                </div>
            </div>
        `;
        $('#galleries-container').append(newField);
        galleriesIndex++;
        $('.galleries-item').find('.remove-galleries').show();
    });

    $(document).on('click', '.remove-galleries', function() {
        $(this).closest('.galleries-item').remove();
        if ($('.galleries-item').length === 1) {
            $('.galleries-item:first').find('.remove-galleries').hide();
        }
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
