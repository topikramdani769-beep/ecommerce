@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<style>
    /* 1. Base Style - White Gallery */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -2px; 
        font-size: 2.2rem;
        line-height: 1;
    }

    /* 2. Action Buttons Luxury */
    .btn-luxury-action {
        background: #000;
        color: #fff;
        border: 1px solid #000;
        font-weight: 900;
        padding: 12px 25px;
        border-radius: 0px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.7rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-luxury-action:hover {
        background: #fff;
        color: #000;
    }

    .btn-back-link {
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        text-decoration: none;
        border-bottom: 2px solid #000;
        padding-bottom: 2px;
        margin-left: 20px;
    }

    /* 3. Image Display */
    .primary-image-wrap {
        background: #fcfcfc;
        border: 1px solid #f2f2f2;
        padding: 10px;
    }
    .primary-image-actual {
        width: 100%;
        height: 500px;
        object-fit: cover;
        filter: grayscale(100%);
        transition: 0.5s;
    }
    .primary-image-wrap:hover .primary-image-actual {
        filter: grayscale(0%);
    }

    .thumb-gallery-wrap {
        filter: grayscale(100%);
        transition: 0.3s;
        border: 1px solid #f2f2f2;
        cursor: crosshair;
    }
    .thumb-gallery-wrap:hover {
        filter: grayscale(0%);
        border-color: #000;
    }

    /* 4. Text & Info Styling */
    .section-divider {
        border-bottom: 2px solid #000;
        color: #000;
        font-weight: 900;
        padding-bottom: 8px;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        display: block;
    }

    .product-category {
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #999;
        font-size: 0.7rem;
    }

    .price-tag {
        font-size: 1.8rem;
        font-weight: 900;
        letter-spacing: -1px;
    }

    .meta-label {
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #999;
        display: block;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

    .meta-value {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    /* 5. Status Badge Minimal */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #000;
        color: #fff;
    }
    .featured-badge {
        background: #fff;
        color: #000;
        border: 1px solid #000;
        margin-left: 10px;
    }
</style>

<div class="row justify-content-center pb-5 mt-4">
    <div class="col-lg-12">

        {{-- Header Kontrol --}}
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="page-title mb-0">Detail Produk</h2>
                <p class="text-muted small mb-0 fw-bold mt-2">IDENTIFIKASI MASTER / ID: {{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn-luxury-action">
                    Ubah Data
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn-back-link">
                    Kembali
                </a>
            </div>
        </div>

        <div class="row g-5">

            {{-- BAGIAN VISUAL (KIRI) --}}
            <div class="col-lg-6">
                <div class="primary-image-wrap mb-4">
                    <img src="{{ asset('storage/'.$product->primaryImage?->image_path) }}" 
                         class="primary-image-actual">
                </div>

                <div class="row g-3">
                    @foreach($product->images as $image)
                    <div class="col-3">
                        <div class="thumb-gallery-wrap">
                            <img src="{{ asset('storage/'.$image->image_path) }}" 
                                 class="img-fluid w-100" style="height: 100px; object-fit: cover;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- BAGIAN INFORMASI (KANAN) --}}
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <span class="product-category">{{ $product->category->name }}</span>
                    <h1 class="fw-900 text-uppercase mb-3 mt-1" style="letter-spacing: -1px;">{{ $product->name }}</h1>
                    
                    <div class="mb-4">
                        @if($product->is_active)
                            <span class="status-badge">Produk Aktif</span>
                        @else
                            <span class="status-badge bg-light text-muted border">Arsip Nonaktif</span>
                        @endif

                        @if($product->is_featured)
                            <span class="status-badge featured-badge">Koleksi Unggulan</span>
                        @endif
                    </div>

                    <div class="mb-5">
                        <span class="meta-label">Nilai Komersial</span>
                        <div class="price-tag">
                            IDR {{ number_format($product->discount_price ?: $product->price, 0, ',', '.') }}
                            @if($product->discount_price)
                                <span class="text-muted fs-5 text-decoration-line-through ms-3" style="font-weight: 400;">
                                    IDR {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <span class="section-divider">Deskripsi Koleksi</span>
                    <div class="mb-5 text-dark" style="line-height: 1.8; font-size: 0.95rem;">
                        {!! $product->description ?: '<span class="text-muted">Tidak ada deskripsi tersedia untuk produk ini.</span>' !!}
                    </div>

                    <span class="section-divider">Spesifikasi Inventaris</span>
                    <div class="row mb-5">
                        <div class="col-4">
                            <span class="meta-label">Stok Tersedia</span>
                            <span class="meta-value">{{ $product->stock }} Unit</span>
                        </div>
                        <div class="col-4">
                            <span class="meta-label">Berat Massa</span>
                            <span class="meta-value">{{ $product->weight }} Gram</span>
                        </div>
                        <div class="col-4">
                            <span class="meta-label">Tanggal Masuk</span>
                            <span class="meta-value">{{ $product->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    {{-- Footer Info --}}
                    <div class="pt-4 border-top">
                        <p class="text-muted" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            Sistem Manajemen Inventaris v1.0 — Departemen Logistik
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection