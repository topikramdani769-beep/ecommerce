{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<style>
    /* Estetika DE LARACHE - Minimalis Hitam & Putih */
    body { background-color: #ffffff; color: #000; }
    .wishlist-container { max-width: 1100px; margin-top: 50px; }

    .bape-header {
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        text-transform: uppercase;
    }

    .bape-title { font-weight: 900; font-size: 2.5rem; margin: 0; }

    /* Card Item dengan ID unik untuk manipulasi DOM */
    .wishlist-item-wrapper { transition: opacity 0.4s ease, transform 0.4s ease; }

    .wishlist-item-card {
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .wishlist-item-card:hover { border-color: #000; }

    /* Tombol X Minimalis (Menggantikan Trash) */
    .remove-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: #000;
        color: #fff;
        border: none;
        width: 35px;
        height: 35px;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        font-size: 1rem;
    }

    .remove-btn:hover { 
        background: #000; 
        color: #fff;
        transform: rotate(90deg); /* Efek putar mewah */
    }

    .btn-bape {
        background: #000; color: #fff; border-radius: 0;
        padding: 12px 30px; font-weight: 900;
        text-transform: uppercase; text-decoration: none;
    }

    .count-badge { font-weight: 900; background: #000; color: #fff; padding: 8px 20px; }
</style>

<div class="container wishlist-container mb-5">
    <div class="bape-header">
        <div>
            <h1 class="bape-title">WISHLIST</h1>
            <p class="text-muted small mb-0 mt-2">PRODUK PILIHAN YANG ANDA SIMPAN</p>
        </div>
        <div class="d-none d-md-block">
            <span class="count-badge" id="page-wishlist-count">{{ $products->total() }} ITEM</span>
        </div>
    </div>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4" id="wishlist-grid">
            @foreach($products as $product)
                <div class="col wishlist-item-wrapper" id="product-row-{{ $product->id }}">
                    <div class="wishlist-item-card h-100">
                        
                        {{-- TOMBOL X MINIMALIS --}}
                        <button class="remove-btn" onclick="removeFromWishlist({{ $product->id }})" title="Hapus">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        
                        <div class="bg-white p-2 h-100">
                            <x-product-card :product="$product" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state text-center py-5">
            <h2 style="font-weight: 900;">WISHLIST KOSONG</h2>
            <p class="text-muted">Jelajahi koleksi kami dan temukan aroma favorit Anda.</p>
            <a href="{{ route('catalog.index') }}" class="btn-bape mt-3 d-inline-block">MULAI BELANJA</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    async function removeFromWishlist(productId) {
        const element = document.getElementById(`product-row-${productId}`);
        if (!element) return;

        // Visual Feedback
        element.style.opacity = '0.5';

        try {
            // Memanggil fungsi global dari app.blade.php
            await toggleWishlist(productId);

            // Animasi keluar
            element.style.transform = 'scale(0.9)';
            
            setTimeout(() => {
                element.remove();
                
                // Update counter lokal
                const countBadge = document.getElementById('page-wishlist-count');
                const remainingItems = document.querySelectorAll('.wishlist-item-wrapper').length;
                
                if(countBadge) {
                    countBadge.innerText = `${remainingItems} ITEM`;
                }

                // Jika sudah tidak ada item, munculkan empty state
                if(remainingItems === 0) {
                    location.reload();
                }
            }, 300);

        } catch (error) {
            element.style.opacity = '1';
            console.error(error);
        }
    }
</script>
@endpush