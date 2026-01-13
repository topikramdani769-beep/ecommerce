@extends('layouts.app')

@section('title', 'De Larache')

@section('content')
<style>
    /* 1. Global & Reset Styling */
    body {
        background-color: #ffffff;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #000;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    /* 2. Hero Section - UKURAN MAKSIMAL (FULL SCREEN) */
    .bape-hero {
        position: relative;
        width: 100%;
        height: 100vh; /* Mengisi seluruh layar monitor (Full Screen) */
        background-color: #000;
        overflow: hidden;
    }

    .bape-hero video {
        position: absolute;
        top: 50%; left: 50%;
        min-width: 100%; min-height: 100%;
        width: auto; height: auto;
        transform: translate(-50%, -50%);
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        bottom: 15%; left: 5%;
        z-index: 2; color: #fff;
        text-shadow: 0px 4px 20px rgba(0,0,0,0.6);
    }

    .hero-overlay h1 {
        font-size: 5rem; /* Font diperbesar agar seimbang dengan video */
        font-weight: 900;
        text-transform: uppercase; letter-spacing: -4px;
        line-height: 0.85;
    }

    /* 3. Product Card Styling */
    .section-title {
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 30px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .scroll-wrapper { position: relative; display: flex; align-items: center; }

    .product-scroll-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 15px;
        padding: 10px 0 30px 0;
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .product-scroll-container::-webkit-scrollbar { display: none; }

    .product-card-fixed {
        flex: 0 0 220px;
        text-align: left;
    }

    .product-image-wrapper {
        background-color: #f8f8f8;
        padding: 20px;
        margin-bottom: 10px;
        transition: 0.3s;
    }

    .product-card-fixed:hover .product-image-wrapper {
        background-color: #f0f0f0;
    }

    .product-image-wrapper img {
        width: 100%;
        height: auto;
        mix-blend-mode: multiply;
    }

    .product-name {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
        color: #000;
        letter-spacing: 0.5px;
    }

    .product-price {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }

    .scroll-btn {
        position: absolute;
        width: 40px; height: 40px;
        background: #000; color: #fff;
        border: none; border-radius: 50%;
        z-index: 10; opacity: 0.5;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }
    .scroll-btn:hover { opacity: 1; }
    .btn-prev { left: -20px; }
    .btn-next { right: -20px; }

    .display-banner-text {
        letter-spacing: -2px; 
        line-height: 1.1;
        font-weight: 900;
        text-transform: uppercase;
    }
</style>

{{-- HERO SECTION --}}
<section class="bape-hero">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('assets/videos/BAPE STA™ IS ON THE ROAD AGAIN.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay">
        <span class="badge bg-white text-dark rounded-0 mb-3 fw-bold px-3">EDISI TERBATAS 2026</span>
        <h1>DE LARACHE<br>SIGNATURE</h1>
        <a href="{{ route('catalog.index') }}" class="btn btn-light rounded-0 fw-bold px-5 py-3 mt-3 shadow-sm">BELI SEKARANG</a>
    </div>
</section>

{{-- NEW ARRIVALS SECTION --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end section-title">
            <h2 class="mb-0 fw-black">Produk Terbaru</h2>
            <a href="{{ route('catalog.index') }}" class="text-dark fw-bold text-decoration-none small">LIHAT SEMUA</a>
        </div>
        
        <div class="scroll-wrapper">
            <button class="scroll-btn btn-prev" onclick="scrollLeftBtn()"><i class="bi bi-chevron-left"></i></button>
            
            <div class="product-scroll-container" id="productContainer">
                @foreach($latestProducts as $product)
                    <div class="product-card-fixed">
                        <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </div>
                            <div class="ps-1">
                                <p class="product-name">{{ $product->name }}</p>
                                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <button class="scroll-btn btn-next" onclick="scrollRightBtn()"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

{{-- SECTION QUOTES --}}
<section class="py-5 bg-black text-white">
    <div class="container-fluid px-0">
        <div class="py-5 border-top border-bottom border-white">
            <div class="d-flex flex-column align-items-center text-center py-5 px-3">
                <span class="badge bg-white text-dark rounded-0 mb-4 fw-bold px-3" style="letter-spacing: 3px;">PERINGATAN</span>
                
                <h2 class="display-banner-text mb-3" style="font-size: calc(1.5rem + 3vw); max-width: 1000px;">
                    Visual bisa dimanipulasi,<br>
                    Namun aroma tidak pernah berbohong tentang siapa dirimu.
                </h2>
                
                <p class="lead mb-4" style="letter-spacing: 4px; font-weight: 300; color: #aaa; font-size: 0.9rem;">DE LARACHE — SENI MENGABADIKAN IDENTITAS</p>
                
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-light rounded-0 fw-bold px-5 py-3 mt-2" style="transition: 0.5s; letter-spacing: 2px;">
                    TELUSURI PRODUK
                </a>
            </div>
        </div>
    </div>
</section>

{{-- VALUE PROPS SECTION --}}
<section class="py-5 border-bottom border-dark bg-white">
    <div class="container">
        <div class="row text-center g-5">
            <div class="col-md-4">
                <div class="mb-3"><i class="bi bi-droplet-half fs-2 text-dark"></i></div>
                <h6 class="fw-black mb-2" style="letter-spacing: 1px;">INTENSITAS TANPA BATAS</h6>
                <p class="small text-muted px-lg-4">Diformulasikan dengan kadar esens tertinggi untuk jejak aroma yang mendominasi.</p>
            </div>
            <div class="col-md-4 border-start border-end border-dark">
                <div class="mb-3"><i class="bi bi-flask fs-2 text-dark"></i></div>
                <h6 class="fw-black mb-2" style="letter-spacing: 1px;">BAHAN LANGKA</h6>
                <p class="small text-muted px-lg-4">Kurasi bahan eksotis dari penjuru dunia untuk karakter yang tiada duanya.</p>
            </div>
            <div class="col-md-4">
                <div class="mb-3"><i class="bi bi-shield-check fs-2 text-dark"></i></div>
                <h6 class="fw-black mb-2" style="letter-spacing: 1px;">PROTEKSI MOLEKULER</h6>
                <p class="small text-muted px-lg-4">Kemasan kedap cahaya untuk menjaga kemurnian struktur aroma Anda.</p>
            </div>
        </div>
    </div>
</section>

<script>
    const container = document.getElementById('productContainer');
    function scrollLeftBtn() { container.scrollBy({ left: -300, behavior: 'smooth' }); }
    function scrollRightBtn() { container.scrollBy({ left: 300, behavior: 'smooth' }); }
</script>
@endsection