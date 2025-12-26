{{-- ================================================
     FILE: resources/views/cart/index.blade.php
     STYLE: Modern Glass-Floating UI (Option 4)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bolder tracking-tight">
                Keranjang <span class="text-primary">Belanja</span>
            </h2>
            <p class="text-muted small">Kelola item pilihanmu sebelum melakukan pembayaran.</p>
        </div>

        @if($cart && $cart->items->count())
            {{-- List Produk --}}
            <div class="col-lg-8">
                <div class="list-group list-group-flush border-top border-bottom mb-4">
                    @foreach($cart->items as $item)
                        <div class="list-group-item border-0 py-4 px-0 bg-transparent">
                            <div class="row align-items-center">
                                {{-- Thumbnail --}}
                                <div class="col-3 col-md-2">
                                    <div class="ratio ratio-1x1 shadow-sm rounded-4 overflow-hidden border">
                                        <img src="{{ $item->product->image_url }}" 
                                             alt="{{ $item->product->name }}" 
                                             style="object-fit: cover;">
                                    </div>
                                </div>

                                {{-- Detail Produk --}}
                                <div class="col-6 col-md-6 ps-md-4">
                                    <span class="badge bg-light text-dark mb-2 fw-normal border">{{ $item->product->category->name }}</span>
                                    <h5 class="fw-bold mb-1 text-dark">
                                        <a href="{{ route('catalog.show', $item->product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $item->product->name }}
                                        </a>
                                    </h5>
                                    <div class="text-primary fw-bold d-md-none mb-2">
                                        {{ $item->product->formatted_price }}
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-3 mt-md-0">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center bg-white border rounded-pill p-1 shadow-sm">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 border-0" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.form.submit();">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" name="quantity" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1" max="{{ $item->product->stock }}" 
                                                   class="form-control form-control-sm border-0 bg-transparent text-center fw-bold p-0" 
                                                   style="width: 35px; box-shadow: none;"
                                                   onchange="this.form.submit()">
                                            <button type="button" class="btn btn-sm btn-link text-dark p-0 px-2 border-0" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.form.submit();">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ms-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-muted hover-danger border-0 bg-transparent" onclick="return confirm('Hapus?')">
                                                <i class="bi bi-trash3 me-1"></i> <span class="small d-none d-md-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Harga (Desktop) --}}
                                <div class="col-3 col-md-4 text-end">
                                    <div class="small text-muted d-none d-md-block mb-1">Total Item</div>
                                    <div class="h5 fw-bolder mb-0">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                    <div class="small text-muted d-none d-md-block mt-1">
                                        {{ $item->product->formatted_price }} / unit
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Checkout Sticky Panel --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-5 bg-white p-2">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Total Pesanan</h5>
                        
                        <div class="space-y-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Jumlah Barang</span>
                                <span class="fw-bold text-dark">{{ $cart->items->sum('quantity') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Estimasi Pajak</span>
                                <span class="fw-bold text-dark">Total Barang</span>
                            </div>
                            
                            <hr class="my-4 border-light">
                            
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <div>
                                    <span class="text-muted small d-block mb-1">Total Bayar</span>
                                    <span class="h3 fw-bolder text-dark mb-0">
                                        Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 rounded-4 fw-bold mb-3 shadow">
                                Lanjutkan Checkout <i class="bi bi-arrow-right-short ms-1"></i>
                            </a>
                            
                            <a href="{{ route('catalog.index') }}" class="btn btn-light w-100 py-2 rounded-4 text-muted small border-0">
                                Tambah Produk Lain
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 px-4 py-3 bg-light rounded-4 d-flex align-items-center">
                    <div class="flex-shrink-0 bg-white p-2 rounded-3 shadow-sm">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0 fw-bold small">Jaminan Aman</p>
                        <p class="mb-0 text-muted" style="font-size: 11px;">Data & pembayaran Anda terlindungi 100%.</p>
                    </div>
                </div>
            </div>

        @else
            {{-- Empty State --}}
            <div class="col-12 text-center py-5">
                <div class="bg-light d-inline-block p-5 rounded-circle mb-4 border shadow-sm">
                    <i class="bi bi-cart-x display-3 text-muted"></i>
                </div>
                <h3 class="fw-bold">Belum ada barang di keranjang</h3>
                <p class="text-muted mx-auto" style="max-width: 400px;">Keranjangmu masih kosong. Mari temukan produk impianmu sekarang di katalog kami!</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold mt-3 shadow-lg">
                    Cari Produk Sekarang
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { 
        background-color: #fbfbfd; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .rounded-4 { border-radius: 1.2rem !important; }
    .rounded-5 { border-radius: 2rem !important; }
    
    .text-primary { color: #5046e5 !important; }
    .btn-primary { 
        background-color: #5046e5; 
        border-color: #5046e5; 
        transition: all 0.3s ease;
    }
    .btn-primary:hover { 
        background-color: #3f36c9; 
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(80, 70, 229, 0.35) !important;
    }

    .list-group-item {
        transition: background-color 0.2s;
    }

    .hover-danger:hover { 
        color: #ef4444 !important;
        background-color: #fef2f2 !important;
        border-radius: 8px;
    }

    /* Hilangkan panah spinner input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endsection