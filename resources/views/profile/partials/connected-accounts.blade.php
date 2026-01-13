<style>
    /* Judul dengan Garis Hitam di Samping */
    .connected-title {
        border-left: 4px solid #000 !important;
        padding-left: 15px !important;
        text-transform: uppercase !important;
        font-weight: 900 !important;
        font-size: 1.1rem;
        letter-spacing: 1px;
        margin-bottom: 25px;
    }

    /* List Group Minimalis */
    .list-group-item {
        border: 1px solid #000 !important;
        border-radius: 0 !important;
        margin-bottom: 10px;
        background-color: #fff !important;
    }

    /* Tombol Hitam-Putih Tajam */
    .btn-bape-sm {
        background-color: #000 !important;
        color: #fff !important;
        border-radius: 0 !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        font-size: 0.65rem !important;
        padding: 8px 15px !important;
        border: 1px solid #000 !important;
        letter-spacing: 1px;
    }

    .btn-bape-sm:hover {
        background-color: #fff !important;
        color: #000 !important;
    }

    /* Hilangkan teks pembantu */
    .text-muted, .text-success {
        display: none !important;
    }
</style>

<div class="connected-title">Akun Terhubung</div>

<div class="list-group">
    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
        <div class="d-flex align-items-center gap-3">
            {{-- Icon Google diubah jadi Hitam Putih --}}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <div>
                <h6 class="mb-0 fw-bold" style="letter-spacing: 1px;">GOOGLE ACCOUNT</h6>
            </div>
        </div>

        @if($user->google_id)
            {{-- Karena route unlink tidak ada di web.php, kita arahkan ke profile.edit saja sementara agar tidak error --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-bape-sm">
                CONNECTED
            </a>
        @else
            <a href="{{ route('auth.google') }}" class="btn btn-bape-sm">
                CONNECT
            </a>
        @endif
    </div>
</div>