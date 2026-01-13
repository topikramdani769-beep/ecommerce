@extends('layouts.app')

@section('content')
<style>
    /* Global Wrapper - Memastikan konten di tengah layar */
    .auth-page-wrapper {
        background-color: #ffffff !important;
        min-height: 100vh;
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    /* Card Styling - Ramping dan Siku */
    .bape-card {
        background: #fff !important;
        border: none !important;
        border-radius: 0px !important;
        box-shadow: none !important;
        width: 100%;
        /* KUNCI AGAR TIDAK LEBAR */
        max-width: 400px; 
    }

    /* Header */
    .auth-header {
        background: transparent !important;
        color: #000 !important;
        padding-bottom: 20px;
        text-align: center;
        border-bottom: 2px solid #000;
        margin-bottom: 30px;
    }

    .auth-header h2 {
        font-weight: 900 !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 1.4rem;
        margin-bottom: 5px;
    }

    .auth-header p {
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #666 !important;
    }

    /* Form Labels & Inputs */
    .form-label {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.7rem !important;
        font-weight: 900 !important;
        color: #000 !important;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 0px !important;
        padding: 12px 15px;
        border: 1px solid #000 !important;
        font-size: 0.8rem;
    }

    .form-control:focus {
        border-color: #000 !important;
        box-shadow: none !important;
        outline: 1px solid #000;
    }

    /* Tombol Utama Hitam */
    .btn-bape-black {
        background: #000 !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        padding: 15px;
        font-weight: 900;
        color: white !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: 0.3s;
    }

    .btn-bape-black:hover {
        background: #fff !important;
        color: #000 !important;
    }

    /* Tombol Google */
    .btn-google-outline {
        border-radius: 0px !important;
        border: 1px solid #000 !important;
        text-transform: uppercase;
        font-weight: 800;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 12px !important;
        text-decoration: none;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Link & Divider */
    .footer-link {
        color: #000 !important;
        text-decoration: underline !important;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 900;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 25px 0;
        text-transform: uppercase;
        font-size: 0.65rem;
        font-weight: 900;
    }

    .divider::before, .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #000;
    }

    .divider:not(:empty)::before { margin-right: 1em; }
    .divider:not(:empty)::after { margin-left: 1em; }
</style>

<div class="auth-page-wrapper">
    <div class="bape-card">
        <div class="auth-header">
            <h2>Daftar Akun</h2>
            <p>Bergabung dengan De Larache</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="MASUKKAN NAMA LENGKAP">
                @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="EMAIL@CONTOH.COM">
                @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="MINIMAL 8 KARAKTER">
                @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" name="password_confirmation" required placeholder="ULANGI KATA SANDI">
            </div>

            <button type="submit" class="btn btn-bape-black">
                Daftar Sekarang
            </button>

            <div class="divider">Atau Daftar Dengan</div>

            <div class="d-grid">
                <a href="{{ route('auth.google') }}" class="btn btn-google-outline">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="16" class="me-2" style="filter: grayscale(1);">
                    Akun Google
                </a>
            </div>

            <div class="text-center mt-4">
                <p class="small text-muted mb-0 fw-bold" style="text-transform: uppercase; font-size: 0.65rem;">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="footer-link">Masuk Di Sini</a>
                </p>
            </div>
        </form>

        <div class="text-center mt-5">
            <small class="fw-bold" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.6rem;">
                &copy; {{ date('Y') }} DE LARACHE.
            </small>
        </div>
    </div>
</div>
@endsection