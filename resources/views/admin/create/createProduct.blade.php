@extends('admin.partials.master')

@section('title', 'Tambah Produk')

@section('content') 
<div class="row">
    <div class="col-md-12">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Tambah Data Produk</h3>
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

            {{-- Form Tambah Produk --}}
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

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
                             id="product_name" name="product_name" value="{{ old('product_name') }}" required>
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
                              @foreach ($categories as $c)
                                  <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                      {{ $c->category_name }}
                                  </option>
                              @endforeach
                          </select>
                          @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                      </div>
                      <div class="form-group col-md-6">
                          <label for="subcategory_id">Subkategori</label>
                          <select class="form-control @error('subcategory_id') is-invalid @enderror"
                                  id="subcategory_id" name="subcategory_id" required>
                              <option value="">-- Pilih Subkategori --</option>
                              @foreach ($subcategories as $s)
                                  <option value="{{ $s->id }}" {{ old('subcategory_id') == $s->id ? 'selected' : '' }}>
                                      {{ $s->subcategory_name }}
                                  </option>
                              @endforeach
                          </select>
                          @error('subcategory_id')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="image">Gambar Produk</label>
                      <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                      @error('image')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="caption">Caption Singkat</label>
                      <textarea class="form-control @error('caption') is-invalid @enderror"
                                id="caption" name="caption" rows="2">{{ old('caption') }}</textarea>
                      @error('caption')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                </div>

                {{-- STEP 2: Details --}}
                <div id="step-details" class="content" role="tabpanel" aria-labelledby="step-details-trigger">
                  <div class="form-group">
                      <label for="logo">Logo Produk</label>
                      <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                      @error('logo')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="description">Deskripsi</label>
                      <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4">{{ old('description') }}</textarea>
                      @error('description')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  {{-- Pilihan Warna --}}
                  <div class="form-group">
                      <label>Pilihan Warna</label>
                      <div id="warna-container">
                          <div class="form-row mb-2 warna-item">
                              <div class="col-md-5">
                                  <input type="file" class="form-control @error('color_image.*') is-invalid @enderror" name="color_image[]">
                                  @error('color_image.*')
                                    <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                              <div class="col-md-5">
                                  <select class="form-control @error('color_code_id.*') is-invalid @enderror" name="color_code_id[]">
                                      <option value="">-- Pilih Kode Warna --</option>
                                      @foreach($colorCodes as $color)
                                          <option value="{{ $color->id }}" {{ old('color_code_id.0') == $color->id ? 'selected' : '' }}>
                                              {{ $color->color_name }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('color_code_id.*')
                                    <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                              <div class="col-md-2">
                                  <button type="button" class="btn btn-danger remove-color">Hapus</button>
                              </div>
                          </div>
                      </div>
                      <button type="button" class="btn btn-primary btn-sm" id="add-warna">+ Tambah Warna</button>
                  </div>

                  {{-- Flyer --}}
                  <div class="form-group">
                      <label>Flyer (Foto / Video)</label>
                      <div id="flyer-container">
                          <div class="form-row mb-2 flyer-item">
                              <div class="col-md-8">
                                  <input type="file" class="form-control @error('flyer.*') is-invalid @enderror" name="flyer[]">
                                  @error('flyer.*')
                                    <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                              <div class="col-md-2">
                                  <button type="button" class="btn btn-danger remove-flyer">Hapus</button>
                              </div>
                          </div>
                      </div>
                      <button type="button" class="btn btn-primary btn-sm" id="add-flyer">+ Tambah Flyer</button>
                  </div>

                  {{-- Master Ukuran --}}
                  <div class="form-group">
                      <label>Ukuran Tersedia</label>
                      <div class="select2-purple">
                        <select class="select2 @error('sizes') is-invalid @enderror" name="sizes[]" multiple="multiple"
                            data-placeholder="Opsi Ukuran Produk" data-dropdown-css-class="select2-purple" style="width: 100%;">
                            @foreach($sizes as $id => $size_label)
                                <option value="{{ $id }}" {{ in_array($id, old('sizes', [])) ? 'selected' : '' }}>
                                    {{ $size_label }}
                                </option>
                            @endforeach
                        </select>
                        @error('sizes')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @error('sizes.*')
                          <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                  </div>

                  <button type="button" class="btn btn-secondary" onclick="stepper.previous()">Previous</button>
                  <button type="button" id="btn-submit" class="btn btn-success">Simpan</button>
                  {{-- <button type="submit" class="btn btn-success">Simpan</button> --}}
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // === 🧭 STEP 1: Inisialisasi Stepper ===
    window.stepper = new Stepper(document.querySelector('.bs-stepper'));

    // === 🎨 STEP 2: Dynamic Input Warna ===
    const warnaContainer = document.getElementById('warna-container');
    const btnAddWarna = document.getElementById('add-warna');

    if (btnAddWarna) {
        btnAddWarna.addEventListener('click', function () {
            const index = warnaContainer.querySelectorAll('.color-item').length;
            const warnaItem = document.createElement('div');
            warnaItem.classList.add('form-row', 'mb-2', 'warna-item');

            warnaItem.innerHTML = `
                <div class="col-md-5">
                    <input type="file" name="color_image[]" class="form-control" accept="image/*">
                </div>
                <div class="col-md-5">
                    <select class="form-control @error('color_code_id.*') is-invalid @enderror" name="color_code_id[]">
                        <option value="">-- Pilih Kode Warna --</option>
                        @foreach($colorCodes as $color)
                            <option value="{{ $color->id }}" {{ old('color_code_id.0') == $color->id ? 'selected' : '' }}>
                                {{ $color->color_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-color">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            `;
            warnaContainer.appendChild(warnaItem);
        });

        // 🔹 Fungsi hapus warna (sinkron)
        warnaContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-color')) {
                e.target.closest('.color-item').remove();
            }
        });
    }

    // === 🖼️ STEP 3: Dynamic Input Flyer ===
    const flyerContainer = document.getElementById('flyer-container');
    const btnAddFlyer = document.getElementById('add-flyer');

    if (btnAddFlyer) {
        btnAddFlyer.addEventListener('click', function () {
            const flyerItem = document.createElement('div');
            flyerItem.classList.add('form-row', 'mb-2', 'flyer-item');

            flyerItem.innerHTML = `
                <div class="col-md-8">
                    <input type="file" name="flyer[]" class="form-control" accept="image/*,video/*">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-flyer">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            `;
            flyerContainer.appendChild(flyerItem);
        });

        // 🔹 Fungsi hapus flyer (sinkron)
        flyerContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-flyer')) {
                e.target.closest('.flyer-item').remove();
            }
        });
    }

    // === ✅ STEP 4: Validasi dan Konfirmasi Submit ===
    const submitBtn = document.getElementById('btn-submit');
    const form = document.querySelector('form[action="{{ route('product.store') }}"]');

    if (submitBtn && form) {
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // List input wajib berdasarkan validasi backend
            const requiredFields = [
                { id: 'product_name', label: 'Nama Produk' },
                { id: 'category_id', label: 'Kategori' },
                { id: 'subcategory_id', label: 'Subkategori' },
                { id: 'image', label: 'Gambar Produk' }
            ];

            let missing = [];

            requiredFields.forEach(field => {
                const el = document.getElementById(field.id);
                if (!el || !el.value || el.value.trim() === '') {
                    missing.push(field.label);
                    if (el) el.classList.add('is-invalid');
                } else {
                    el.classList.remove('is-invalid');
                }
            });

            if (missing.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Form belum lengkap!',
                    html: 'Kolom berikut wajib diisi:<br><strong>' + missing.join(', ') + '</strong>',
                    confirmButtonColor: '#d33'
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            // Jika semua aman, konfirmasi simpan
            Swal.fire({
                title: 'Yakin ingin menyimpan produk ini?',
                text: 'Pastikan semua data sudah benar sebelum disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // tampilkan loading sebelum form disubmit
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
        
                    // sedikit delay agar animasi loading muncul
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });
        });
    }
});
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    confirmButtonColor: '#28a745'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    confirmButtonColor: '#d33'
});
</script>
@endif

@endsection