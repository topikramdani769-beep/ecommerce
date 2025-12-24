{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="container py-5">
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="h3 fw-bolder mb-1">Wishlist Saya</h1>
            <p class="text-muted small mb-0">Temukan kembali produk-produk favorit yang telah Anda simpan.</p>
        </div>
        @if($products->count())
            <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold">
                <i class="bi bi-heart-fill me-1"></i> {{ $products->total() }} Produk
            </span>
        @endif
    </div>

    @if($products->count())
        {{-- Product Grid --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($products as $product)
                <div class="col wishlist-item">
                    <div class="position-relative h-100 transition-up">
                        {{-- Komponen kartu produk tetap dipanggil --}}
                        <x-product-card :product="$product" />
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            <div class="custom-pagination">
                {{ $products->links() }}
            </div>
        </div>
    @else
        {{-- Enhanced Empty State --}}
        <div class="row justify-content-center py-5">
            <div class="col-md-6 text-center">
                <div class="empty-wishlist-icon mb-4">
                    <div class="pulse-ring"></div>
                    <i class="bi bi-heart"></i>
                </div>
                <h4 class="fw-bold text-dark">Wishlist Anda Masih Kosong</h4>
                <p class="text-muted mb-4 px-lg-5">
                    Simpan barang-barang yang Anda incar agar lebih mudah menemukannya saat Anda siap untuk check out.
                </p>
                <a href="{{ route('catalog.index') }}" class="btn btn-dark px-5 py-3 rounded-pill fw-bold shadow-sm">
                    Jelajahi Produk Sekarang
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    /* Styling Dasar */
    body { background-color: #fcfcfd; }
    
    .bg-soft-danger { background-color: #fff1f2; }
    
    /* Animasi Kartu */
    .wishlist-item { transition: all 0.3s ease; }
    .transition-up:hover {
        transform: translateY(-10px);
    }

    /* Kustomisasi Icon Kosong */
    .empty-wishlist-icon {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        font-size: 2.5rem;
        color: #dee2e6;
    }

    .pulse-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid #f8d7da;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    /* Merapikan Pagination Laravel */
    .custom-pagination nav svg {
        width: 20px;
    }
    .custom-pagination nav .flex.justify-between {
        display: none; /* Menyembunyikan teks label mobile default Laravel */
    }
</style>
@endsection