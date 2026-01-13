{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* 1. Global Minimalist Style (Matching Navbar) */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1.5px; 
        font-size: 2.5rem;
    }

    .section-label {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #000;
        margin-bottom: 20px;
        display: block;
        border-left: 3px solid #000;
        padding-left: 10px;
    }

    /* 2. Form Styling */
    .form-control {
        border-radius: 0px;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 0;
        font-weight: 600;
        background: transparent !important;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }
    .form-floating > label {
        padding-left: 0;
        text-transform: uppercase;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    /* 3. Luxury Receipt Styling */
    .receipt-card {
        background: #ffffff;
        border: 2px solid #000;
        position: relative;
        border-radius: 0px;
    }

    .receipt-title {
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        font-size: 1rem;
    }

    .receipt-item {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .receipt-divider {
        border-top: 1px dashed #000;
        margin: 1.5rem 0;
    }

    /* 4. Luxury Button */
    .btn-luxury-buy {
        background: #000 !important;
        color: #fff !important;
        border-radius: 0px;
        text-transform: uppercase;
        font-weight: 900;
        font-size: 0.8rem;
        letter-spacing: 2px;
        padding: 20px;
        transition: 0.3s;
        border: 1px solid #000;
    }

    .btn-luxury-buy:hover {
        background: #fff !important;
        color: #000 !important;
        transform: none;
    }

    .payment-box {
        border: 1px solid #000;
        padding: 20px;
        border-radius: 0px;
    }
</style>

<div class="py-5">
    <div class="container">
        <div class="row g-5">
            {{-- Form Section --}}
            <div class="col-lg-7">
                <div class="mb-5">
                    <h2 class="page-title mb-0">KONFIRMASI</h2>
                    <h2 class="page-title text-muted" style="font-size: 1.5rem; margin-top: -10px;">CHECKOUT</h2>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" id="form-checkout">
                    @csrf
                    
                    <span class="section-label">Informasi Pengiriman</span>
                    
                    <div class="mb-5 px-2">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control" id="name" value="{{ auth()->user()->name }}" placeholder="NAMA" required>
                                    <label for="name">Nama Lengkap</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="TELEPON" required>
                                    <label for="phone">Nomor Telepon</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="address" class="form-control" id="address" style="height: 100px" placeholder="ALAMAT" required></textarea>
                                    <label for="address">Alamat Lengkap Pengiriman</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="section-label">Metode Pembayaran</span>
                    <div class="px-2 mb-4">
                        <div class="payment-box">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input shadow-none me-3" type="radio" checked style="border-color: #000; background-color: #000;">
                                <label class="form-check-label fw-900 text-uppercase small" style="letter-spacing: 1px;">
                                    Transfer Bank Manual (BCA / MANDIRI)
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tampilan Struk (Order Summary) --}}
            <div class="col-lg-5">
                <div class="receipt-card p-4 p-md-5 position-sticky" style="top: 6rem;">
                    <div class="text-center mb-4">
                        <h5 class="receipt-title">RINGKASAN PESANAN</h5>
                        <div class="fw-bold small mt-2" style="font-size: 0.6rem; letter-spacing: 1px;">
                            DE LARACHE OFFICIAL STORE / {{ date('d.m.Y') }}
                        </div>
                    </div>

                    <div class="receipt-items mb-4">
                        @foreach($cart->items as $item)
                        <div class="receipt-item d-flex justify-content-between mb-3 align-items-start">
                            <div style="max-width: 70%;">
                                <div class="mb-1">{{ $item->product->name }}</div>
                                <div class="text-muted fw-normal" style="font-size: 0.7rem;">
                                    QTY: {{ $item->quantity }} @ Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="fw-900">
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="receipt-divider"></div>

                    <div class="receipt-item d-flex justify-content-between mb-2">
                        <span class="fw-normal">SUBTOTAL</span>
                        <span>{{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-item d-flex justify-content-between mb-2">
                        <span class="fw-normal">BIAYA KIRIM</span>
                        <span class="text-dark">FREE</span>
                    </div>

                    <div class="receipt-divider"></div>

                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <span class="fw-900 h5 mb-0">TOTAL</span>
                        <span class="fw-900 h4 mb-0 text-dark">
                           IDR {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" form="form-checkout" class="btn btn-luxury-buy btn-lg w-100 shadow-none">
                        KONFIRMASI PESANAN
                    </button>

                    <div class="text-center mt-4">
                        <p class="fw-900 text-muted mb-0" style="font-size: 0.6rem; letter-spacing: 2px;">*** DE LARACHE - ELEGANCE IN EVERY DROP ***</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection