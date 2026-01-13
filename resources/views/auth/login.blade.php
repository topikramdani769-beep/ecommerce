{{-- ======================================== 
FILE: resources/views/auth/login.blade.php 
FUNGSI: Halaman login gaya BAPE (Minimalist Black & White)
======================================== --}} 
@extends('layouts.app') 

@section('content')
<style>
    /* BAPE Global Styling */
    body {
        background-color: #ffffff !important; /* Latar putih bersih */
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #000;
        margin: 0;
        padding: 0;
    }

    .container.mt-5 {
        margin-top: 80px !important;
    }

    /* Card Styling - Flat & No Border */
    .login-card {
        border: none !important;
        background: #fff !important;
        box-shadow: none !important; /* Hilangkan shadow */
        max-width: 400px;
        margin: 0 auto;
    }

    /* Header - Bold & Uppercase */
    .card-header h4 {
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 1.5rem;
    }

    .card-header p {
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #666 !important;
    }

    /* Input Fields - Sharp Corners */
    .form-control {
        padding: 15px !important;
        border-radius: 0px !important; /* Kotak siku khas BAPE */
        border: 1px solid #000 !important; /* Border hitam tipis */
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control:focus {
        border-color: #000 !important;
        box-shadow: none !important;
        outline: 1px solid #000;
    }

    .form-label {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.7rem !important;
        font-weight: 900 !important;
    }

    /* Primary Button - Solid Black */
    .btn-login-primary {
        background: #000 !important;
        color: #fff !important;
        border: 1px solid #000 !important;
        padding: 15px !important;
        border-radius: 0px !important; /* Kotak siku */
        width: 100%;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .btn-login-primary:hover {
        background: #fff !important;
        color: #000 !important;
        transform: none;
    }

    /* Google Button - Outline Black */
    .btn-google {
        border: 1px solid #000 !important;
        background: white !important;
        border-radius: 0px !important;
        padding: 12px !important;
        text-transform: uppercase;
        font-weight: 800;
        font-size: 0.7rem;
        letter-spacing: 1px;
        color: #000 !important;
    }

    .btn-google:hover {
        background: #000 !important;
        color: #fff !important;
    }

    .btn-google svg {
        filter: grayscale(1); /* Membuat logo google monokrom saat hover? opsional */
    }

    /* Links */
    .register-link, .forgot-password-link {
        color: #000 !important;
        font-weight: 900;
        text-decoration: underline !important;
        text-transform: uppercase;
        font-size: 0.7rem;
    }

    .register-link:hover, .forgot-password-link:hover {
        opacity: 0.6;
    }

    hr {
        border-top: 1px solid #000;
        opacity: 1;
    }

    .text-muted {
        color: #666 !important;
    }

    /* Checkbox Square */
    .form-check-input {
        border-radius: 0 !important;
        border: 1px solid #000 !important;
    }
    .form-check-input:checked {
        background-color: #000 !important;
        border-color: #000 !important;
    }
</style>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card login-card">
        {{-- Card Header --}}
        <div class="card-header text-center bg-transparent border-0 pt-4">
          <h4 class="mb-1">Login</h4>
          <p class="text-muted small">Masukan e-mail dan password</p>
        </div>

        <div class="card-body p-4 pt-2">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- FIELD EMAIL --}}
            <div class="mb-3">
              <label for="email" class="form-label small fw-bold">E-mail</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
              name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="">
              
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between">
                <label for="password" class="form-label small fw-bold">Password</label>
                @if (Route::has('password.request'))
                <a class="small forgot-password-link mb-2" href="{{ route('password.request') }}">
                  Lupa Password?
                </a>
                @endif
              </div>

              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password" placeholder="">

              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-4 form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label small text-muted fw-bold" for="remember" style="text-transform: uppercase; font-size: 0.65rem;">
                Ingatkan Saya
              </label>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-login-primary">
                Login
              </button>
            </div>

            <div class="position-relative my-4">
                <hr>
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-bold" style="text-transform: uppercase;">OR</span>
            </div>

            <div class="d-grid gap-2">
              <a href="{{ route('auth.google') }}" class="btn btn-google d-flex align-items-center justify-content-center">
                <svg class="me-2" width="16" height="16" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                  <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                login Menggunakan Google
              </a>
            </div>

            <p class="mt-4 text-center small text-muted fw-bold" style="text-transform: uppercase; font-size: 0.65rem;">
              Tidak Punya Akun?
              <a href="{{ route('register') }}" class="register-link">
                Buat Akun
              </a>
            </p>
          </form>
        </div>
      </div>
      <div class="text-center mt-5">
          <small class="text-dark fw-bold" style="text-transform: uppercase; letter-spacing: 1px;">&copy; {{ date('Y') }} DE LARACHE. ALL RIGHTS RESERVED.</small>
      </div>
    </div>
  </div>
</div>
@endsection