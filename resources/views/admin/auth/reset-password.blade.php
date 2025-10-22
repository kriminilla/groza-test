<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GROZA | ADMIN RESET PASSWORD</title>

  <link href="{{ asset('img/favicon.ico') }}" rel="icon">
  <link rel="icon" type="image/x-icon" href="{{ asset('img/web-app-manifest-192x192.png') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <p class="login-box-msg">Reset Password Baru</p>

      {{-- Pesan sukses dari Laravel --}}
      @if (session('status'))
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('status') }}',
            confirmButtonColor: '#3085d6'
          });
        </script>
      @endif

      {{-- Pesan error dari Laravel --}}
      @if ($errors->any())
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33'
          });
        </script>
      @endif

      <form id="resetPasswordForm" action="{{ route('admin.password.update') }}" method="post" novalidate class="swal-loading">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password Baru (min. 8 karakter)" required minlength="8">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
      </form>

      <p class="mt-3 mb-1 text-center">
        <a href="{{ route('login') }}">Kembali ke Login</a>
      </p>
    </div>
  </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script>
document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
  const email = this.email.value.trim();
  const password = this.password.value.trim();
  const confirmPassword = this.password_confirmation.value.trim();
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Validasi client-side
  if (!email) {
    e.preventDefault();
    Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Email tidak boleh kosong.' });
    return;
  }
  if (!emailRegex.test(email)) {
    e.preventDefault();
    Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Format email tidak valid.' });
    return;
  }
  if (password.length < 8) {
    e.preventDefault();
    Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Password minimal 8 karakter.' });
    return;
  }
  if (password !== confirmPassword) {
    e.preventDefault();
    Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Konfirmasi password tidak cocok.' });
    return;
  }

  // Loading state saat submit
  Swal.fire({
    title: 'Sedang memproses...',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
});
</script>
</body>
</html>
