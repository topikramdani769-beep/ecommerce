{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Komponen kartu produk yang reusable (Sunset Theme)
     ================================================ --}}

<style>
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px !important;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(227, 52, 47, 0.12) !important;
    }

    .badge-discount {
        background: linear-gradient(135deg, #ff8c00 0%, #e3342f 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(227, 52, 47, 0.3);
    }

    .btn-wishlist-custom {
        background: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        color: #444;
        transition: 0.3s;
        z-index: 2;
    }

    .btn-wishlist-custom:hover {
        background: #fff1f0;
        color: #e3342f;
        transform: scale(1.1);
    }

    .product-price {
        background: linear-gradient(135deg, #e3342f 0%, #ff8c00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        font-size: 1.1rem;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #ff8c00 0%, #e3342f 100%) !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: 700;
        transition: 0.3s;
        color: white !important;
    }

    .btn-add-cart:hover:not(:disabled) {
        filter: brightness(1.1);
        box-shadow: 0 5px 15px rgba(227, 52, 47, 0.3);
    }

    .btn-add-cart:disabled {
        background: #e0e0e0 !important;
        color: #999 !important;
    }
</style>

<div class="card product-card h-100 border-0 shadow-sm">
    {{-- Product Image --}}
    <div class="position-relative overflow-hidden">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 230px; object-fit: cover; transition: 0.5s;">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
            <span class="badge-discount">
                <i class="ti ti-percentage fs-6 me-1"></i>{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- Wishlist Button --}}
        @auth
            <button type="button"
                    onclick="toggleWishlist({{ $product->id }})"
                    class="btn btn-wishlist-custom btn-sm position-absolute top-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center wishlist-btn-{{ $product->id }}"
                    style="width: 35px; height: 35px;">
                <i class="ti {{ auth()->user()->hasInWishlist($product) ? 'ti-heart-filled text-danger' : 'ti-heart' }} fs-5"></i>
            </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column p-4">
        {{-- Category --}}
        <div class="d-flex align-items-center mb-2">
            <span class="badge bg-light text-dark fw-normal rounded-pill px-3 border" style="font-size: 0.7rem;">
                {{ $product->category->name }}
            </span>
        </div>

        {{-- Product Name --}}
        <h6 class="card-title mb-2">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="text-decoration-none text-dark fw-bold stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Price --}}
        <div class="mt-auto pt-2">
            @if($product->has_discount)
                <div class="text-muted text-decoration-line-through small mb-1" style="font-size: 0.8rem;">
                    {{ $product->formatted_original_price }}
                </div>
            @endif
            <div class="product-price">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info --}}
        <div class="mt-3">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="d-flex align-items-center text-warning" style="font-size: 0.8rem;">
                    <i class="ti ti-alert-triangle me-1 fs-5"></i>
                    Stok tinggal {{ $product->stock }}
                </div>
            @elseif($product->stock == 0)
                <div class="d-flex align-items-center text-danger" style="font-size: 0.8rem;">
                    <i class="ti ti-circle-x me-1 fs-5"></i> Stok Habis
                </div>
            @else
                <div class="d-flex align-items-center text-success" style="font-size: 0.8rem;">
                    <i class="ti ti-check me-1 fs-5"></i> Stok Tersedia
                </div>
            @endif
        </div>
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-white border-0 p-4 pt-0">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    class="btn btn-add-cart w-100 py-2 d-flex align-items-center justify-content-center"
                    @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    <i class="ti ti-shopping-cart-x me-2 fs-5"></i> Stok Habis
                @else
                    <i class="ti ti-shopping-cart-plus me-2 fs-5"></i> Tambahkan
                @endif
            </button>
        </form>
    </div>
</div>