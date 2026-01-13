@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
    body {
        background-color: #ffffff;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #000;
    }

    .cart-container {
        max-width: 900px;
        margin-top: 50px;
    }

    .cart-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: 1px;
    }

    .close-cart {
        font-size: 1.5rem;
        cursor: pointer;
        color: #000;
        text-decoration: none;
    }

    .cart-item {
        border-bottom: 1px solid #eee;
        padding: 20px 0;
        display: flex;
        position: relative;
    }

    .item-image {
        width: 120px;
        height: 120px;
        background-color: #f8f8f8;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .item-details {
        flex-grow: 1;
        padding-left: 20px;
    }

    .item-name {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .item-meta {
        font-size: 0.85rem;
        color: #000;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .item-price {
        font-weight: 900;
        margin-top: 10px;
    }

    .btn-remove-item {
        position: absolute;
        right: 0;
        top: 20px;
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #000;
    }

    .bape-qty {
        display: flex;
        border: 1px solid #ddd;
        width: fit-content;
        height: 40px;
        position: absolute;
        right: 0;
        bottom: 20px;
    }

    .bape-qty button {
        border: none;
        background: white;
        width: 35px;
        font-weight: bold;
        transition: 0.2s;
    }

    .bape-qty button:hover {
        background: #000;
        color: #fff;
    }

    .bape-qty input {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-top: none;
        border-bottom: none;
        width: 45px;
        text-align: center;
        font-weight: bold;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .summary-total {
        border-top: 1px solid #000;
        margin-top: 20px;
        padding-top: 20px;
        font-size: 1.2rem;
        font-weight: 900;
    }

    .btn-bape {
        display: block;
        width: 100%;
        background: #000;
        color: #fff;
        border: 1px solid #000;
        border-radius: 0;
        padding: 15px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-bape:hover {
        background: #fff;
        color: #000;
    }
</style>

<div class="container cart-container mb-5">
    <div class="cart-header">
        <a href="{{ route('catalog.index') }}" class="close-cart"><i class="ti ti-x"></i></a>
        <div class="fs-4">Keranjang</div>
        <div class="small">{{ $cart ? $cart->items->sum('quantity') : 0 }} Produk</div>
    </div>

    @if($cart && $cart->items->count())
        @foreach($cart->items as $item)
            <div class="cart-item">
                <div class="item-image">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                </div>
                
                <div class="item-details">
                    <div class="item-name">{{ $item->product->name }}</div>
                    <div class="item-meta">Warna: {{ $item->product->color ?? 'Hitam' }}</div>
                    <div class="item-meta">Ukuran: {{ $item->product->size ?? '-' }}</div>
                    
                    <div class="item-price">
                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                    </div>
                    
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-remove-item"><i class="ti ti-x"></i></button>
                    </form>

                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="bape-qty">
                        @csrf @method('PATCH')
                        <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit();">-</button>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" readonly>
                        <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit();">+</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-5">
            <div class="summary-row summary-total">
                <span>Total</span>
                <span>Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('checkout.index') }}" class="btn-bape">Bayar Sekarang</a>
            <a href="{{ route('catalog.index') }}" class="btn-bape" style="background: #fff; color: #000;">Kembali Belanja</a>
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="fw-bold">KERANJANG ANDA KOSONG</h4>
            <a href="{{ route('catalog.index') }}" class="btn-bape d-inline-block px-5 mt-3">BELANJA SEKARANG</a>
        </div>
    @endif
</div>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endsection