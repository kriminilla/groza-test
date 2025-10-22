<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GROZA | RESET PASSWORD</title>
      
  <link href="{{ asset('img/favicon.ico') }}" rel="icon">
  <link rel="icon" type="image/x-icon" href="{{ asset('img/web-app-manifest-192x192.png') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
    .invalid-feedback {
      display: block;
      font-size: 0.875rem;
      color: #dc3545;
    }
  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="{{ asset('img/logoGroza.png') }}" alt="GROZA Logo" style="width:auto; height: 55px;">
    </div>

    <div class="card-body">
      <p class="login-box-msg">Lupa Password?</p>

      {{-- Pesan sukses --}}
      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      {{-- Pesan error validasi --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="resetForm" action="{{ route('admin.password.email') }}" method="post" novalidate>
        @csrf
        <div class="input-group mb-3">
          <input 
            type="email" 
            name="email" 
            class="form-control @error('email') is-invalid @enderror" 
            placeholder="Email" 
            value="{{ old('email') }}" 
            required 
            autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
      </form>

      <p class="mt-3 mb-1"><a href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
  </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<!-- Validasi sisi klien -->
<script>
document.getElementById('resetForm').addEventListener('submit', function (e) {
  const emailInput = this.email;
  const emailValue = emailInput.value.trim();
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (emailValue === '') {
    e.preventDefault();
    alert('Email tidak boleh kosong.');
    emailInput.focus();
  } else if (!emailRegex.test(emailValue)) {
    e.preventDefault();
    alert('Masukkan format email yang valid.');
    emailInput.focus();
  }
});
</script>
</body>
</html>
