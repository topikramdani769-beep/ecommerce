@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
    /* BAPE Global Aesthetics */
    body {
        background-color: #ffffff;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    /* Typography */
    .product-title {
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #000;
        font-size: 1.75rem;
    }

    .text-bape-muted {
        color: #666;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    /* Price Styling */
    .price-large {
        font-weight: 900;
        font-size: 1.5rem;
        color: #000;
    }

    /* Image Gallery - Flat & White */
    .main-image-wrapper {
        background-color: #f8f8f8; /* Abu-abu sangat muda khas BAPE */
        border-radius: 0px !important;
        border: none !important;
    }

    .thumb-img {
        border-radius: 0px !important;
        border: 1px solid #eee !important;
        transition: 0.2s;
        background: #f8f8f8;
    }

    .thumb-img.active, .thumb-img:hover {
        border-color: #000 !important;
        opacity: 0.8;
    }

    /* Buttons - Solid Black, No Rounded */
    .btn-bape-black {
        background-color: #000 !important;
        color: #fff !important;
        border-radius: 0px !important;
        border: 1px solid #000 !important;
        padding: 18px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
        transition: 0.3s;
    }

    .btn-bape-black:hover:not(:disabled) {
        background-color: #fff !important;
        color: #000 !important;
    }

    .btn-bape-outline {
        background-color: #fff !important;
        color: #000 !important;
        border-radius: 0px !important;
        border: 1px solid #000 !important;
        text-transform: uppercase;
        font-weight: 800;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    /* Quantity Selector */
    .qty-wrapper {
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        height: 58px;
    }

    /* Details Accordion style */
    .detail-section-title {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 15px 0;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
    }

    .breadcrumb-item, .breadcrumb-item a {
        text-transform: uppercase;
        font-size: 0.65rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #999 !important;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #000 !important;
    }

    /* Badge */
    .badge-discount {
        background: #000 !important;
        border-radius: 0px !important;
        text-transform: uppercase;
        font-weight: 900;
        font-size: 0.7rem;
        padding: 8px 12px;
    }
</style>

<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Kolom Kiri: Galeri --}}
        <div class="col-lg-7">
            <div class="main-image-wrapper position-relative d-flex align-items-center justify-content-center p-5 mb-3">
                <img src="{{ $product->image_url }}" id="main-image" class="img-fluid" 
                     alt="{{ $product->name }}" style="max-height: 600px; object-fit: contain;">
                
                @if($product->has_discount)
                    <div class="position-absolute top-0 start-0 m-0">
                        <span class="badge badge-discount">SALE {{ $product->discount_percentage }}% OFF</span>
                    </div>
                @endif
            </div>

            @if($product->images->count() > 1)
                <div class="d-flex gap-2 overflow-auto custom-scrollbar">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             class="thumb-img" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this)">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kolom Kanan: Info --}}
        <div class="col-lg-5 ps-lg-5">
            <div class="mb-2">
                <span class="text-bape-muted">{{ $product->category->name }}</span>
                <span class="text-bape-muted mx-2">|</span>
                <span class="text-bape-muted">SKU: {{ $product->id + 1000 }}</span>
            </div>

            <h1 class="product-title mb-4">{{ $product->name }}</h1>

            <div class="mb-5">
                @if($product->has_discount)
                    <span class="text-muted text-decoration-line-through me-2" style="font-size: 1.1rem;">{{ $product->formatted_original_price }}</span>
                @endif
                <span class="price-large">{{ $product->formatted_price }}</span>
            </div>

            {{-- Form Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="qty-wrapper d-flex align-items-center bg-white">
                            <button type="button" class="btn btn-link text-dark px-3" onclick="decrementQty()"><i class="ti ti-minus"></i></button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="form-control border-0 text-center fw-bold bg-transparent shadow-none" readonly>
                            <button type="button" class="btn btn-link text-dark px-3" onclick="incrementQty()"><i class="ti ti-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-8">
                        <button type="submit" class="btn btn-bape-black w-100 h-100" @if($product->stock == 0) disabled @endif>
                            TAMBAHKAN KE KERANJANG
                        </button>
                    </div>
                </div>
            </form>

            {{-- Wishlist --}}
            <div class="d-grid mb-5">
                @auth
                    <button type="button" onclick="toggleWishlist({{ $product->id }})"
                            class="btn btn-bape-outline py-3 wishlist-btn-{{ $product->id }}">
                        <i class="ti {{ auth()->user()->hasInWishlist($product) ? 'ti-heart-filled' : 'ti-heart' }} me-2"></i>
                        SIMPAN KE WISHLIST
                    </button>
                @endauth
            </div>

            {{-- Product Detail Section (BAPE Style Accordion) --}}
            <div class="detail-section-title">
                DETAIL PRODUK
                <i class="ti ti-plus"></i>
            </div>
            <div class="py-4">
                <div class="text-dark small lh-lg fw-medium text-uppercase" style="letter-spacing: 0.5px;">
                    {!! nl2br(e($product->description)) !!}
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-bape-muted">BERAT</span>
                        <span class="fw-bold small">{{ $product->weight }}G</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-bape-muted">PENGIRIMAN</span>
                        <span class="fw-bold small">INDONESIA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeMainImage(element) {
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
        element.classList.add('active');
        const main = document.getElementById('main-image');
        main.style.opacity = '0.5';
        setTimeout(() => {
            main.src = element.src;
            main.style.opacity = '1';
        }, 150);
    }

    function incrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) < parseInt(input.max)) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endpush
@endsection