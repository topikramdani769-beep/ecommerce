{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="container py-5">
    {{-- Header dengan Ilustrasi Garis --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="fw-bold display-5 mb-2 text-gradient">Wishlist</h1>
            <p class="text-muted mb-0">Barang-barang wishlistmu tersimpan di sini.</p>
        </div>
        <div class="col-md-6 text-md-end d-none d-md-block">
             <div class="d-inline-flex align-items-center bg-white border rounded-4 px-4 py-3 shadow-sm">
                 <div class="me-3 text-start">
                     <span class="d-block small text-muted">Total Tersimpan</span>
                     <span class="h5 fw-bold mb-0 text-primary">{{ $products->total() }} Produk</span>
                 </div>
                 <i class="bi bi-bookmarks-fill fs-2 text-primary-light"></i>
             </div>
        </div>
    </div>

    @if($products->count())
        {{-- Product Grid dengan Glass Effect --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="wishlist-item-card h-100">
                        <div class="glass-wrapper shadow-sm rounded-4 overflow-hidden border">
                            <x-product-card :product="$product" />
                            
                            {{-- Overlay Badge "Favorit" yang estetik --}}
                            <div class="fav-badge">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination yang dipercantik --}}
        <div class="mt-5 d-flex justify-content-center">
            <div class="glass-pagination p-2 bg-white rounded-pill border shadow-sm">
                {{ $products->links() }}
            </div>
        </div>
    @else
        {{-- Empty State dengan Gaya Playful --}}
        <div class="text-center py-5">
            <div class="empty-state-wrapper mb-4">
                <div class="floating-icons">
                    <i class="bi bi-heart-fill icon-1"></i>
                    <i class="bi bi-star-fill icon-2"></i>
                    <i class="bi bi-bag-heart-fill icon-3"></i>
                </div>
                <div class="main-empty-circle">
                    <i class="bi bi-emoji-smile"></i>
                </div>
            </div>
            <h3 class="fw-bold mt-4">Wah, Masih Kosong!</h3>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Jangan biarkan produk incaranmu hilang. Yuk, mulai cari produk dan klik ikon hati untuk menyimpannya!
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm-hover fw-bold">
                Jelajahi Produk
            </a>
        </div>
    @endif
</div>

<style>
    /* Gradient Text & Colors */
    .text-gradient {
        background: linear-gradient(45deg, #2b2d42, #8d99ae);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-primary-light { color: #8e94f2; }

    /* Card Interaction */
    .wishlist-item-card {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .wishlist-item-card:hover {
        transform: scale(1.05);
        z-index: 10;
    }

    .glass-wrapper {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .fav-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: #ff4d6d;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        z-index: 2;
    }

    /* Floating Animation for Empty State */
    .empty-state-wrapper {
        position: relative;
        display: inline-block;
        padding: 40px;
    }
    .main-empty-circle {
        width: 120px;
        height: 120px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #dee2e6;
    }
    .floating-icons i {
        position: absolute;
        color: #ffccd5;
        animation: float 3s infinite ease-in-out;
    }
    .icon-1 { top: 0; left: 20px; font-size: 1.5rem; animation-delay: 0s; }
    .icon-2 { top: 20px; right: 0; font-size: 1.2rem; animation-delay: 1s; }
    .icon-3 { bottom: 0; right: 30px; font-size: 1.8rem; animation-delay: 0.5s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    /* Pagination Styling */
    .glass-pagination .page-link {
        border: none;
        color: #6c757d;
        border-radius: 50% !important;
        margin: 0 3px;
    }
    .glass-pagination .page-item.active .page-link {
        background-color: #000;
        color: #fff;
    }
</style>
@endsection