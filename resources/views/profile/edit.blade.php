@extends('layouts.app')

@section('content')
<style>
    /* RESET BACKGROUND KE PUTIH/HITAM TEMA DE LARACHE */
    .profile-page-wrapper {
        background-color: #ffffff;
        min-height: 100vh;
        padding: 60px 0;
        font-family: 'Inter', sans-serif;
        color: #000;
    }

    /* CONTAINER UTAMA */
    .profile-container {
        max-width: 1000px; 
    }

    /* JUDUL DENGAN FONT GLITCH */
    .profile-title {
        font-family: 'Rubik Glitch', cursive;
        color: #000;
        font-weight: 400;
        font-size: 2.5rem;
        text-transform: uppercase;
        border-bottom: 5px solid #000;
        display: inline-block;
        margin-bottom: 40px !important;
    }

    /* CARD DENGAN STYLE BRUTALIST (Gaya BAPE/Streetwear) */
    .profile-card {
        border: 3px solid #000 !important;
        border-radius: 0 !important; /* Kotak tajam */
        box-shadow: 8px 8px 0px #000; /* Shadow kaku */
        background: #ffffff;
        height: 100%;
        transition: transform 0.2s;
    }

    .profile-card:hover {
        transform: translate(-3px, -3px);
        box-shadow: 11px 11px 0px #ff0000; /* Shadow berubah merah saat hover */
    }

    .profile-card .card-header {
        background: #000 !important;
        border-bottom: none;
        color: #fff !important;
        font-family: 'Rubik Glitch', cursive;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 0 !important;
    }

    .profile-card .card-body {
        padding: 25px !important;
    }

    /* FORM CONTROL STYLE */
    .form-control {
        font-size: 0.9rem;
        border: 2px solid #000;
        border-radius: 0;
        padding: 10px;
        text-transform: uppercase;
        font-weight: 700;
    }

    .form-control:focus {
        border-color: #ff0000;
        box-shadow: none;
        outline: none;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 900;
        color: #000;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* BUTTON STYLE DE LARACHE */
    .btn-sanchez {
        background: #000;
        border: 2px solid #000;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 0.8rem;
        border-radius: 0;
        padding: 10px 20px;
        text-transform: uppercase;
        transition: 0.2s;
        width: 100%;
    }

    .btn-sanchez:hover {
        background: #ff0000;
        border-color: #ff0000;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ALERT SUCCESS */
    .alert-success {
        background: #000;
        color: #fff;
        border: none;
        border-radius: 0;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* HAPUS AKUN SECTION */
    .delete-section {
        border: 3px solid #ff0000 !important;
        background: #fff;
        padding: 20px;
        margin-top: 20px;
    }

    .delete-title {
        font-family: 'Rubik Glitch', cursive;
        color: #ff0000;
    }

    @media (max-width: 768px) {
        .profile-title { font-size: 1.8rem; }
    }
</style>

<div class="profile-page-wrapper">
    <div class="container profile-container">
        
        <h2 class="profile-title mb-4">
            PENGATURAN PROFIL
        </h2>

        @if (session('success'))
            <div class="alert alert-success py-3 shadow mb-4">
                <i class="ti ti-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row g-5">
            {{-- Informasi Dasar --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">INFO PROFIL</div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Foto Profil --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">FOTO PROFIL</div>
                    <div class="card-body text-center">
                        @include('profile.partials.update-avatar-form')
                    </div>
                </div>
            </div>

            {{-- Keamanan --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">KEAMANAN</div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Koneksi --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">KONEKSI</div>
                    <div class="card-body">
                        @include('profile.partials.connected-accounts')
                    </div>
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="col-12">
                <div class="delete-section d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="delete-title mb-1">HAPUS AKUN</h6>
                        <p class="text-dark small mb-0 fw-bold">TINDAKAN INI BERSIFAT PERMANEN!</p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection