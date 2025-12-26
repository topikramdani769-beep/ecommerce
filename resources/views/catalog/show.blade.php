\{{-- ================================================
     FILE: resources/views/catalog/show.blade.php
     FUNGSI: Halaman detail produk (Versi Teroptimasi)
     ================================================ --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    {{-- Breadcrumb: Dibuat lebih subtle --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ Str::limit($product->name, 25) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Kolom Kiri: Galeri Produk --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden sticky-top" style="top: 2rem; z-index: 1;">
                <div class="position-relative bg-light d-flex align-items-center justify-content-center" style="min-height: 450px;">
                    <img src="{{ $product->image_url }}"
                         id="main-image"
                         class="img-fluid p-3"
                         alt="{{ $product->name }}"
                         style="max-height: 450px; object-fit: contain; transition: all 0.3s ease;">

                    @if($product->has_discount)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge rounded-pill bg-danger px-3 py-2 shadow-sm">
                                <i class="bi bi-lightning-fill me-1"></i> Hemat {{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Gallery: Dibuat lebih rapi --}}
                @if($product->images->count() > 1)
                    <div class="card-footer bg-white border-top-0 p-3">
                        <div class="d-flex gap-2 overflow-auto pb-2 custom-scrollbar">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     class="rounded border thumb-img"
                                     style="width: 70px; height: 70px; object-fit: cover; cursor: pointer; transition: 0.2s;"
                                     onclick="changeMainImage(this)">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: Informasi Produk --}}
        <div class="col-lg-6">
            <div class="ps-lg-3">
                {{-- Kategori & Rating Placeholder --}}
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                       class="badge bg-primary-subtle text-primary text-decoration-none px-3 py-2">
                        {{ $product->category->name }}
                    </a>
                    <span class="text-muted small border-start ps-2">SKU: PROD-{{ $product->id }}</span>
                </div>

                <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>

                {{-- Harga: Lebih Berani --}}
                <div class="d-flex align-items-baseline gap-2 mb-4">
                    <span class="h2 text-primary fw-bolder mb-0">{{ $product->formatted_price }}</span>
                    @if($product->has_discount)
                        <span class="text-muted text-decoration-line-through fs-5">{{ $product->formatted_original_price }}</span>
                    @endif
                </div>

                <hr class="my-4 opacity-50">

                {{-- Status Stok --}}
                <div class="mb-4">
                    <label class="form-label d-block small text-muted text-uppercase fw-bold mb-2">Status Ketersediaan</label>
                    @if($product->stock > 10)
                        <div class="d-inline-flex align-items-center text-success bg-success-subtle px-3 py-1 rounded-pill">
                            <i class="bi bi-check-circle-fill me-2"></i> Stok Tersedia
                        </div>
                    @elseif($product->stock > 0)
                        <div class="d-inline-flex align-items-center text-warning bg-warning-subtle px-3 py-1 rounded-pill">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Stok Terbatas (Sisa {{ $product->stock }})
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center text-danger bg-danger-subtle px-3 py-1 rounded-pill">
                            <i class="bi bi-x-circle-fill me-2"></i> Stok Habis
                        </div>
                    @endif
                </div>

                {{-- Form Add to Cart --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Atur Jumlah</label>
                        </div>
                        <div class="col-auto">
                            <div class="input-group border rounded-3" style="width: 150px; height: 50px;">
                                <button type="button" class="btn btn-link text-dark text-decoration-none px-3" onclick="decrementQty()">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity"
                                       value="1" min="1" max="{{ $product->stock }}"
                                       class="form-control border-0 text-center fw-bold bg-transparent" readonly>
                                <button type="button" class="btn btn-link text-dark text-decoration-none px-3" onclick="incrementQty()">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm h-100 d-flex align-items-center justify-content-center"
                                    @if($product->stock == 0) disabled @endif>
                                <i class="bi bi-cart-plus-fill me-2"></i> Masukkan Keranjang
                            </button>
                        </div>
                    </div>
                </form>

                <div class="d-flex gap-2 mb-4">
                    @auth
                        <button type="button" onclick="toggleWishlist({{ $product->id }})"
                                class="btn btn-outline-danger flex-grow-1 py-2 wishlist-btn-{{ $product->id }}">
                            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                            Wishlist
                        </button>
                    @endauth
                    <button class="btn btn-outline-secondary py-2" title="Bagikan">
                        <i class="bi bi-share"></i>
                    </button>
                </div>

                {{-- Deskripsi Tab --}}
                <div class="card border-0 bg-light rounded-4 mt-5">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Deskripsi Produk</h6>
                        <div class="text-muted lh-lg small">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div class="row mt-4 pt-3 border-top g-2">
                            <div class="col-6">
                                <span class="d-block text-muted small">Berat</span>
                                <span class="fw-bold">{{ $product->weight }} gram</span>
                            </div>
                            <div class="col-6 text-end text-sm-start">
                                <span class="d-block text-muted small">Pengiriman</span>
                                <span class="fw-bold text-success">Seluruh Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .thumb-img:hover { border-color: #0d6efd !important; opacity: 0.8; }
    .custom-scrollbar::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
    .bg-primary-subtle { background-color: #e7f1ff; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-danger-subtle { background-color: #f8d7da; }
</style>

@push('scripts')
<script>
    function changeMainImage(element) {
        const main = document.getElementById('main-image');
        main.style.opacity = '0.5';
        setTimeout(() => {
            main.src = element.src;
            main.style.opacity = '1';
        }, 150);
    }
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
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