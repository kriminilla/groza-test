@extends('admin.partials.master')

@section('title', 'Edit Produk')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Edit Data Produk: {{ $product->product_name }}</h3>
            </div>
            <div class="card-body">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#step-general">
                            <button type="button" class="step-trigger" role="tab" aria-controls="step-general" id="step-general-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">General Info</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-details">
                            <button type="button" class="step-trigger" role="tab" aria-controls="step-details" id="step-details-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Details</span>
                            </button>
                        </div>
                    </div>

                    {{-- Form Edit Produk --}}
                    <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data" id="editProdukForm">
                        
                        @csrf
                        @method('PUT')

                        {{-- Hidden containers untuk menyimpan ID yang akan dihapus --}}
                        <div id="flyer-to-delete-container"></div>
                        <div id="color-to-delete-container"></div>

                        {{-- Error Summary --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Terjadi Kesalahan:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="bs-stepper-content">
                            {{-- STEP 1: General Info --}}
                            <div id="step-general" class="content" role="tabpanel" aria-labelledby="step-general-trigger">
                                <div class="form-group">
                                    <label for="product_name">Nama Produk</label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                            id="product_name" name="product_name"
                                            value="{{ old('product_name', $product->product_name) }}" required>
                                    @error('product_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category_id">Kategori</label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}" {{ old('category_id', $product->category_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="subcategory_id">Subkategori</label>
                                        <select class="form-control @error('subcategory_id') is-invalid @enderror"
                                                id="subcategory_id" name="subcategory_id" required>
                                            <option value="">-- Pilih Subkategori --</option>
                                            {{-- Subcategories di-load via AJAX atau dari controller, pastikan data yang dikirim lengkap --}}
                                            @foreach ($subcategories as $item)
                                                <option value="{{ $item->id }}" {{ old('subcategory_id', $product->subcategory_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->subcategory_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image">Gambar Produk Utama</label><br>
                                    <div id="preview-main-image" class="mb-2">
                                        @if($product->image && Storage::disk('public')->exists($product->image))
                                            <img src="{{ asset('storage/' . $product->image) }}" width="140" class="mb-2" id="mainImagePreview">
                                        @else
                                            <img src="{{ asset('img/no-image.png') }}" width="140" class="mb-2" id="mainImagePreview">
                                        @endif
                                    </div>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label for="caption">Caption Singkat</label>
                                    <textarea class="form-control" id="caption" name="caption" rows="2">{{ old('caption', $product->caption) }}</textarea>
                                </div>

                                <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                            </div>

                            {{-- STEP 2: Details --}}
                            <div id="step-details" class="content" role="tabpanel" aria-labelledby="step-details-trigger">

                                <div class="form-group">
                                    <label for="logo">Logo Produk</label><br>
                                    <div class="mb-2">
                                        @if($product->logo && Storage::disk('public')->exists($product->logo))
                                            <img src="{{ asset('storage/' . $product->logo) }}" width="120" id="logoPreviewExisting">
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                </div>

                                {{-- Pilihan Warna (Perbaikan Input Nama) --}}
                                <div class="form-group">
                                    <label>Pilihan Warna</label>
                                    <div id="color-container">
                                        @forelse($product->colors as $i => $color)
                                            <div class="form-row mb-2 color-item border p-2 rounded existing-color-item" data-color-id="{{ $color->id }}">
                                                <div class="col-md-3">
                                                    @if($color->image && Storage::disk('public')->exists($color->image))
                                                        <img src="{{ asset('storage/' . $color->image) }}" width="80" class="mb-2 d-block existing-color-preview">
                                                    @endif
                                                    <input type="file" class="form-control existing-color-input" name="color_image[]" accept="image/*">
                                                    <input type="hidden" name="color_ids[]" value="{{ $color->id }}">
                                                </div>
                                                <div class="col-md-4">
                                                    {{-- Kode Warna. Nama input: color_code_id[] --}}
                                                    <select class="form-control" name="color_code_id[]">
                                                        <option value="">-- Pilih Kode Warna --</option>
                                                        @foreach($colorCodes as $code)
                                                            <option value="{{ $code->id }}" {{ old("color_code_id.$i", $color->color_code_id) == $code->id ? 'selected' : '' }}>
                                                                {{ $code->color_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-existing-color" data-color-id="{{ $color->id }}">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="add-color">+ Tambah Warna</button>
                                </div>

                                {{-- Flyer (Perbaikan Input Nama) --}}
                                <div class="form-group">
                                    <label>Flyer (Foto / Video)</label>
                                    <div id="flyer-container">
                                        @forelse($product->flyers as $flyer)
                                            @php
                                                $path = 'storage/' . $flyer->flyer;
                                                $ext = pathinfo($flyer->flyer, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($ext), ['jpg','jpeg','png','webp']);
                                                $isVideo = in_array(strtolower($ext), ['mp4','avi','mov', 'quicktime']);
                                            @endphp
                                            <div class="form-row mb-2 flyer-item existing-flyer-item border p-2 rounded" data-flyer-id="{{ $flyer->id }}">
                                                <div class="col-md-8">
                                                    @if(Storage::disk('public')->exists($flyer->flyer))
                                                        @if($isImage)
                                                            <img src="{{ asset($path) }}" width="140" class="mb-2 existing-flyer-preview">
                                                        @elseif($isVideo)
                                                            <video width="240" controls class="mb-2 existing-flyer-preview">
                                                                <source src="{{ asset($path) }}" type="video/mp4">
                                                            </video>
                                                        @endif
                                                    @else
                                                         <div class="text-danger mb-2">File tidak ditemukan.</div>
                                                    @endif
                                                    
                                                    <input type="file" class="form-control existing-flyer-input" name="flyers[]" accept="image/*,video/mp4,video/avi,video/quicktime">
                                                    <input type="hidden" name="existing_flyer_ids[]" value="{{ $flyer->id }}">
                                                </div>
                                                <div class="col-md-2 d-flex align-items-center">
                                                    <button type="button" class="btn btn-danger remove-flyer" data-flyer-id="{{ $flyer->id }}">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="add-flyer">+ Tambah Flyer</button>
                                </div>

                                {{-- Ukuran --}}
                                <div class="form-group">
                                    <label>Ukuran Tersedia</label>
                                    <div class="select2-purple">
                                        <select class="select2" name="sizes[]" multiple="multiple"
                                                data-placeholder="Pilih Ukuran"
                                                style="width: 100%;">
                                            @foreach($sizes as $id => $sizeLabel)
                                                <option value="{{ $id }}"
                                                    {{ in_array($id, old('sizes', $product->sizes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $sizeLabel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary" onclick="stepper.previous()">Previous</button>
                                <button type="button" id="btn-update" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Stepper
    window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    
    // Pastikan variabel $colorCodes dari Controller tersedia
    const colorCodes = {!! json_encode($colorCodes) !!}; 

    function generateColorOptions(selectedValue = '') {
        let options = '<option value="">-- Pilih Kode Warna --</option>';
        colorCodes.forEach(colorCodes => {
            options += `<option value="${colorCodes.id}" ${colorCodes.id == selectedValue ? 'selected' : ''}>${colorCodes.color_name}</option>`;
        });
        return options;
    }

    const colorContainer = document.getElementById('color-container');
    const flyerContainer = document.getElementById('flyer-container');
    const deleteFlyerContainer = document.getElementById('flyer-to-delete-container');
    const deleteColorContainer = document.getElementById('color-to-delete-container');

    // Tambah color baru
    document.getElementById('add-color').addEventListener('click', function() {
        let item = document.createElement('div');
        item.classList.add('form-row', 'mb-2', 'color-item', 'border', 'p-2', 'rounded', 'new-color-item');
        item.innerHTML = `
            <div class="col-md-3">
                <input type="file" class="form-control" name="color_image[]" accept="image/*" required>
                {{-- ID kosong menandakan data baru --}}
                <input type="hidden" name="color_ids[]" value=""> 
            </div>
            <div class="col-md-4">
                <select class="form-control" name="color_code_id[]" required>${generateColorOptions()}</select>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-new-color"><i class="fas fa-trash"></i> Hapus</button>
            </div>`;
        colorContainer.appendChild(item);
    });

    // 2. Event listener untuk hapus warna (baru atau existing)
    colorContainer.addEventListener('click', function(e) {
        // Hapus warna baru (yang belum tersimpan di DB)
        if (e.target.classList.contains('remove-new-color')) {
            e.target.closest('.new-color-item').remove();
            return;
        }

        // Hapus warna existing (tambahkan ID ke input hidden)
        const existingBtn = e.target.closest('.btn-delete-existing-color');
        if (existingBtn) {
            const colorId = existingBtn.dataset.colorId;
            const item = existingBtn.closest('.existing-color-item');

            // Cek apakah item ini sudah dihapus (mencegah double klik)
            if (!item.classList.contains('deleted-item')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                // Nama input yang akan dibaca oleh Controller untuk penghapusan
                input.name = 'deleted_color_ids[]';
                input.value = colorId;
                deleteColorContainer.appendChild(input);
                item.remove();
            }
        }
    });
    
    // Tambah flyer baru
    document.getElementById('add-flyer').addEventListener('click', function() {
        let item = document.createElement('div');
        item.classList.add('form-row', 'mb-2', 'flyer-item', 'rounded', 'new-flyer-item', 'border', 'p-2');
        item.innerHTML = `
            <div class="col-md-8">
                <input type="file" class="form-control new-flyer-input" name="flyers[]" accept="image/*,video/mp4,video/avi,video/quicktime" required>
                <div class="mt-2 new-flyer-preview"></div>
                {{-- ID kosong menandakan data baru --}}
                <input type="hidden" name="existing_flyer_ids[]" value=""> 
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-flyer"><i class="fas fa-trash"></i> Hapus</button>
            </div>`;
        flyerContainer.appendChild(item);
    });

    // 2. Event listener untuk hapus flyer (baru atau existing)
    flyerContainer.addEventListener('click', function(e) {
        
        const removeButton = e.target.closest('.remove-flyer');
        if (removeButton) {
            const item = removeButton.closest('.flyer-item');
            
            // Logika untuk flyer existing (yang sudah ada ID-nya)
            if (item.classList.contains('existing-flyer-item')) {
                const flyerId = item.dataset.flyerId;
                if (flyerId) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    // Nama input yang akan dibaca oleh Controller untuk penghapusan
                    hidden.name = 'deleted_flyer_ids[]';
                    hidden.value = flyerId;
                    deleteFlyerContainer.appendChild(hidden);
                }
            }
            // Hapus item dari DOM
            item.remove();
        }
    });

    // Preview gambar utama
    const mainImageInput = document.getElementById('image');
    const mainImagePreview = document.getElementById('mainImagePreview');
    if (mainImageInput) {
        mainImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = ev => mainImagePreview.src = ev.target.result;
            reader.readAsDataURL(file);
        });
    }
    
    // Submit konfirmasi update
    document.getElementById('btn-update').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin memperbarui produk ini?',
            text: 'Perubahan akan disimpan permanen.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, update!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses simpan
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
    
                // Beri jeda sebentar agar loading muncul
                setTimeout(() => {
                    document.getElementById('editProdukForm').submit();
                }, 500);
            }
        });
    });

    // Inisialisasi Select2
    if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
        $('.select2').select2();
    }
});
</script>

{{-- SweetAlert Notifications --}}
@if(session('success'))
<script>
Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', confirmButtonColor: '#28a745' });
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Menyimpan!',
    html: `<ul style="text-align:left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
    confirmButtonColor: '#d33'
});
</script>
@endif
@endsection