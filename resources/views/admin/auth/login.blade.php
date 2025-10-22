<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GROZA | ADMIN LOGIN</title>
        
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/web-app-manifest-192x192.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            {{-- Sesuaikan path logo Groza --}}
            <img src="{{ asset('img/logoGroza.png') }}" alt="GROZA Logo" style="width:auto; height: 55px;">
        </div>
        <div class="card-body">
            <b>
                <p class="login-box-msg">LOGIN UNTUK MENGAKSES PAGE</p>
            </b>

            {{-- BLOK NOTIFIKASI ERROR JIKA LOGIN GAGAL --}} 
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ACTION FORM MENGARAH KE ROUTE AUTHENTICATE --}}
            <form action="{{ route('admin.login.submit') }}" method="post">
                @csrf

                {{-- INPUT USERNAME --}}
                <div class="input-group mb-3">
                    <input type="text" 
                           name="username" 
                           class="form-control @error('username') is-invalid @enderror" 
                           placeholder="Username" 
                           value="{{ old('username') }}" 
                           required autofocus>
                
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                
                    @error('username') 
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> 
                    @enderror
                </div>
                
                {{-- INPUT PASSWORD --}}
                <div class="input-group mb-3">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password" 
                           required>
                
                    <div class="input-group-append">
                        <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <span class="fas fa-eye" id="toggleIcon"></span>
                        </div>
                    </div>
                
                    @error('password') 
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> 
                    @enderror
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
            <p class="mt-1">
              <a href="{{ route('admin.password.request') }}">Lupa Password?</a>
            </p>
        </div>
        </div>
    </div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
{{-- SCRIPT UNTUK SHOW / HIDE PASSWORD --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>
</body>
</html>