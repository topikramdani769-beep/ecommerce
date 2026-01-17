@extends('layouts.app')

@section('content')
<style>
    /* BAPE Global Theme Styling */
    body {
        background-color: #ffffff !important;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .catalog-title {
        font-weight: 900;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Filter Card */
    .filter-card {
        border-radius: 0px;
        border: 2px solid #000 !important;
        box-shadow: none !important;
    }

    .filter-header {
        background: #000 !important;
        color: white !important;
        border-radius: 0px;
        font-weight: 900;
        text-transform: uppercase;
    }

    /* Form Elements */
    .form-check-input:checked { background-color: #000; border-color: #000; }
    .form-check-input { border-radius: 0px !important; border: 1px solid #000; }
    .form-control, .form-select {
        border-radius: 0px !important;
        border: 1px solid #000 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Buttons */
    .btn-apply-filter {
        background: #000 !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        font-weight: 900;
        text-transform: uppercase;
        color: white;
        transition: 0.2s;
    }

    .btn-apply-filter:hover {
        background: #fff !important;
        color: #000 !important;
    }

    .btn-outline-secondary {
        border-radius: 0px !important;
        border: 1px solid #000 !important;
        color: #000 !important;
        text-transform: uppercase;
        font-weight: 800;
    }

    /* Pagination */
    .pagination .page-item.active .page-link { background: #000 !important; border-color: #000 !important; }
    .pagination .page-link { color: #000; border-radius: 0px !important; }

    /* Empty State Styling */
    .empty-state-container {
        padding: 80px 20px;
        border: 2px dashed #000;
        text-align: center;
    }
</style>

<div class="container py-5">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card filter-card border-0">
                <div class="card-header filter-header py-3">
                    <i class="ti ti-adjustments-horizontal me-2"></i> FILTER PRODUK
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        {{-- Simpan Query Pencarian Saat Filter Diterapkan --}}
                        @if(request('search')) 
                            <input type="hidden" name="search" value="{{ request('search') }}"> 
                        @endif

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="text-transform: uppercase; letter-spacing: 1px;">
                                KATEGORI
                            </h6>
                            @foreach($categories as $cat)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}"
                                        id="cat-{{ $cat->id }}"
                                        {{ request('category') == $cat->slug ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <label class="form-check-label w-100 d-flex justify-content-between fw-bold" for="cat-{{ $cat->id }}" style="font-size: 0.75rem; text-transform: uppercase;">
                                        {{ $cat->name }} 
                                        <span class="badge bg-black text-white px-2">{{ $cat->products_count }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="text-transform: uppercase; letter-spacing: 1px;">
                                RENTANG HARGA
                            </h6>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bg-white border-dark border-end-0 text-dark fw-bold" style="border-radius: 0;">RP</span>
                                <input type="number" name="min_price" class="form-control border-dark" placeholder="MIN" value="{{ request('min_price') }}">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-dark border-end-0 text-dark fw-bold" style="border-radius: 0;">RP</span>
                                <input type="number" name="max_price" class="form-control border-dark" placeholder="MAX" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-apply-filter w-100 py-2 mb-2">
                            TERAPKAN FILTER
                        </button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 btn-sm py-2">
                            RESET
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h2 class="catalog-title mb-0">
                        @if(request('search'))
                            PENCARIAN: "{{ request('search') }}"
                        @else
                            KATALOG PRODUK
                        @endif
                    </h2>
                    <p class="text-muted mb-0 small text-uppercase fw-bold" style="letter-spacing: 1px;">
                        @if(request('search'))
                            Menampilkan hasil untuk kata kunci yang Anda cari
                        @else
                            High Quality Parfume Essentials
                        @endif
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-dark small text-nowrap fw-bold text-uppercase">Urutkan:</span>
                    <form method="GET" class="d-inline-block">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="form-select form-select-sm px-3" onchange="this.form.submit()" style="min-width: 150px;">
                            <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Terlaris</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state-container">
                            <i class="ti ti-package-off fs-1 mb-3 text-dark"></i>
                            <h4 class="fw-black text-uppercase">Produk Tidak Tersedia</h4>
                            <p class="text-muted text-uppercase small mb-4">
                                Maaf, produk dengan kata kunci <span class="text-dark fw-bold">"{{ request('search') }}"</span> tidak ditemukan.
                            </p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-apply-filter px-5 py-3">
                                LIHAT SEMUA KOLEKSI
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection