@extends('layouts.app')

@section('content')
<style>
    .profile-page-wrapper {
        background: linear-gradient(135deg, #ff9a44 0%, #fc6076 100%);
        min-height: 100vh;
        margin-top: -24px;
        padding: 30px 0;
        font-family: 'Segoe UI', sans-serif;
    }

    /* Ukuran container utama dibatasi agar tidak terlalu lebar ke samping */
    .profile-container {
        max-width: 1000px; 
    }

    .profile-title {
        color: white;
        font-weight: 700;
        font-size: 1.4rem;
        text-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .profile-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        background: #ffffff;
        height: 100%; /* Menyamakan tinggi card dalam satu baris */
        display: flex;
        flex-direction: column;
    }

    .profile-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        color: #fd7e14;
        font-size: 0.95rem;
        padding: 12px 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .profile-card .card-header::before {
        content: "";
        width: 3px;
        height: 14px;
        background: #fd7e14;
        margin-right: 10px;
        border-radius: 10px;
    }

    .profile-card .card-body {
        padding: 20px !important;
        flex: 1; /* Mengisi ruang sisa agar tinggi sama */
    }

    /* Rampingkan Form */
    .form-control {
        font-size: 0.85rem;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #666;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .btn-sanchez {
        background: linear-gradient(to right, #fd7e14, #ff4500);
        border: none;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        border-radius: 6px;
        padding: 7px 18px;
        transition: 0.2s;
    }

    .btn-sanchez:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(253, 126, 20, 0.2);
        color: white;
    }
</style>

<div class="profile-page-wrapper">
    <div class="container profile-container">
        
        <h2 class="profile-title mb-4">
            <i class="bi bi-person-circle me-2"></i>Pengaturan Profil
        </h2>

        @if (session('success'))
            <div class="alert alert-success py-2 border-0 shadow-sm mb-4" style="border-radius: 10px; font-size: 0.85rem;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            {{-- Baris 1: Informasi Dasar & Foto --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">Informasi Profil</div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">Foto Profil</div>
                    <div class="card-body text-center">
                        @include('profile.partials.update-avatar-form')
                    </div>
                </div>
            </div>

            {{-- Baris 2: Keamanan & Akun Terhubung --}}
            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">Keamanan Akun</div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header">Koneksi Akun</div>
                    <div class="card-body">
                        @include('profile.partials.connected-accounts')
                    </div>
                </div>
            </div>

            {{-- Baris 3: Hapus Akun (Lebar Penuh) --}}
            <div class="col-12">
                <div class="card border-0" style="border-radius: 12px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255,255,255,0.3) !important;">
                    <div class="card-body p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white fw-bold mb-0" style="font-size: 0.9rem;">Hapus Akun</h6>
                            <p class="text-white small mb-0 opacity-75">Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection