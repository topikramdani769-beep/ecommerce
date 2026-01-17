@extends('layouts.app')

@section('title', 'De Larache')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Rubik+Glitch&family=Pirata+One&display=swap" rel="stylesheet">

<style>
    /* 1. Global & Reset */
    body {
        background-color: #ffffff;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #000;
        margin: 0; padding: 0;
        overflow-x: hidden;
    }

    /* 2. Hero Section */
    .bape-hero {
        position: relative;
        width: 100%;
        height: 100vh;
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
        opacity: 0.7; /* Membuat video agak gelap agar teks menonjol */
    }

    .hero-overlay {
        position: absolute;
        bottom: 15%; left: 5%;
        z-index: 2; color: #fff;
    }

    /* Judul Hero Rusak */
    .hero-overlay h1 {
        font-family: 'Rubik Glitch', cursive;
        font-size: 6rem;
        text-transform: uppercase; 
        line-height: 0.9;
        margin-bottom: 20px;
        text-shadow: 5px 5px 0px rgba(255, 0, 0, 0.3); /* Bayangan merah samar */
    }

    /* 3. Product Section */
    .section-title {
        border-bottom: 3px solid #000;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }

    .section-title h2 {
        font-family: 'Rubik Glitch', cursive;
        font-size: 2.5rem;
        text-transform: uppercase;
    }

    .scroll-wrapper { 
        position: relative; 
        display: flex; 
        align-items: center; 
    }

    .product-scroll-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 20px;
        padding: 10px 0 30px 0;
        scrollbar-width: none; 
    }
    .product-scroll-container::-webkit-scrollbar { display: none; }

    .product-card-fixed {
        flex: 0 0 240px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .product-card-fixed:hover {
        transform: translateY(-5px);
    }

    .product-image-wrapper {
        background-color: #f8f8f8;
        width: 100%;
        height: 280px; 
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .product-card-fixed:hover .product-image-wrapper {
        background-color: #ffffff;
        border: 1px solid #000;
    }

    .product-image-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        mix-blend-mode: multiply;
    }

    /* Nama Produk Rusak */
    .product-name {
        font-family: 'Pirata One', cursive;
        font-size: 1.2rem;
        text-transform: uppercase;
        margin-bottom: 4px;
        color: #000;
        min-height: 1.2em; 
        letter-spacing: 1px;
    }

    .product-price {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #444;
        font-weight: 900;
    }

    /* Navigasi */
    .scroll-btn {
        position: absolute;
        width: 45px; height: 45px;
        background: #000; color: #fff;
        border: none; border-radius: 0; /* Kotak agar lebih industrial */
        z-index: 10; opacity: 0.7;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }
    .scroll-btn:hover { opacity: 1; background: #ff0000; }

    /* Tombol Lihat Semua */
    .btn-glitch-custom {
        font-family: 'Rubik Glitch', cursive;
        border: 2px solid #000;
        padding: 15px 40px;
        background: transparent;
        color: #000;
        text-decoration: none;
        font-size: 1.2rem;
        transition: 0.3s;
    }

    .btn-glitch-custom:hover {
        background: #000;
        color: #fff;
    }

    /* Quote Section - Seram & Megah */
    .quote-text {
        font-family: 'Pirata One', cursive;
        font-size: calc(2rem + 3vw) !important;
        line-height: 1.1;
        color: #fff;
        text-shadow: 0 0 20px rgba(255,255,255,0.2);
    }

    @media (max-width: 768px) {
        .hero-overlay h1 { font-size: 3.5rem; }
        .quote-text { font-size: 2rem !important; }
    }
</style>

{{-- HERO SECTION --}}
<section class="bape-hero">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('assets/videos/BAPE STA™ IS ON THE ROAD AGAIN.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay">
        <span class="badge bg-danger text-white rounded-0 mb-3 fw-bold px-3">EDISI TERBATAS 2026</span>
        <h1>DE LARACHE<br>SIGNATURE</h1>
        <a href="{{ route('catalog.index') }}" class="btn-glitch-custom" style="background: white;">BELI SEKARANG</a>
    </div>
</section>

{{-- NEW ARRIVALS SECTION --}}
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2 class="mb-0">Produk Terbaru</h2>
        </div>
        
        <div class="scroll-wrapper">
            <button class="scroll-btn btn-prev" onclick="scrollLeftBtn()">
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <div class="product-scroll-container" id="productContainer">
                @foreach($latestProducts as $product)
                    <div class="product-card-fixed">
                        <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-info">
                                <p class="product-name">{{ $product->name }}</p>
                                <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <button class="scroll-btn btn-next" onclick="scrollRightBtn()">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <div class="view-all-container mt-5 text-center">
            <a href="{{ route('catalog.index') }}" class="btn-glitch-custom">
                LIHAT SEMUA PRODUK
            </a>
        </div>
    </div>
</section>

{{-- SECTION QUOTES --}}
<section class="py-5 bg-black text-white">
    <div class="container-fluid px-0">
        <div class="py-5 border-top border-bottom border-white" style="background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');">
            <div class="d-flex flex-column align-items-center text-center py-5 px-3">
                <span class="badge bg-danger text-white rounded-0 mb-4 fw-bold px-3" style="letter-spacing: 3px;">PERINGATAN</span>
                
                <h2 class="quote-text mb-3">
                    Visual bisa dimanipulasi,<br>
                    Namun aroma tidak pernah berbohong tentang siapa dirimu.
                </h2>
                
                <p class="lead mb-4" style="letter-spacing: 4px; font-weight: 300; color: #ff0000; font-family: 'Inter'; font-size: 0.8rem;">DE LARACHE — SENI MENGABADIKAN IDENTITAS</p>
                
                <a href="{{ route('catalog.index') }}" class="btn-glitch-custom" style="color: white; border-color: white;">
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
                <h6 class="fw-black mb-2" style="font-family: 'Pirata One'; letter-spacing: 1px; font-size: 1.5rem;">INTENSITAS TANPA BATAS</h6>
                <p class="small text-muted px-lg-4">Diformulasikan dengan kadar esens tertinggi untuk jejak aroma yang mendominasi.</p>
            </div>
            <div class="col-md-4 border-start border-end border-dark">
                <div class="mb-3"><i class="bi bi-flask fs-2 text-dark"></i></div>
                <h6 class="fw-black mb-2" style="font-family: 'Pirata One'; letter-spacing: 1px; font-size: 1.5rem;">BAHAN LANGKA</h6>
                <p class="small text-muted px-lg-4">Kurasi bahan eksotis dari penjuru dunia untuk karakter yang tiada duanya.</p>
            </div>
            <div class="col-md-4">
                <div class="mb-3"><i class="bi bi-shield-check fs-2 text-dark"></i></div>
                <h6 class="fw-black mb-2" style="font-family: 'Pirata One'; letter-spacing: 1px; font-size: 1.5rem;">PROTEKSI MOLEKULER</h6>
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