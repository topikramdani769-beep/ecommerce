@extends('layouts.admin')

@section('title', 'Katalog Produk')

@section('content')
<style>
    /* 1. Base Style - White Gallery */
    body { background-color: #ffffff; font-family: 'Inter', -apple-system, sans-serif; color: #000; }
    
    .page-title { 
        color: #000; 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -2px; 
        font-size: 2.5rem;
        line-height: 1;
    }

    /* 2. Tombol Minimalis */
    .btn-luxury {
        background: #000;
        border: 1px solid #000;
        color: #fff;
        font-weight: 900;
        border-radius: 0px;
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1.5px;
        padding: 15px 30px;
    }
    .btn-luxury:hover {
        background: #fff;
        color: #000;
    }

    /* 3. Filter Section */
    .filter-section {
        border-top: 1px solid #000;
        border-bottom: 1px solid #eee;
        padding: 25px 0;
        margin-bottom: 40px;
    }
    .form-control, .form-select {
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 10px 0;
        background: transparent;
    }
    .form-control:focus, .form-select:focus {
        border-color: #000;
        box-shadow: none;
    }

    /* 4. Tabel Minimalis */
    .table thead {
        border-bottom: 2px solid #000;
    }
    .table thead th {
        color: #000 !important;
        text-transform: uppercase;
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 2px;
        padding: 20px 10px;
        border: none;
    }
    .table tbody tr {
        border-bottom: 1px solid #f2f2f2;
        transition: all 0.3s;
    }
    .table tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* 5. Status & Badges */
    .badge-status { 
        background-color: #000; 
        color: #fff; 
        border-radius: 0px;
        font-weight: 900;
        text-transform: uppercase;
        padding: 5px 10px;
        font-size: 0.6rem;
    }
    .badge-offline { 
        background-color: #f2f2f2; 
        color: #999; 
        border-radius: 0px;
        font-weight: 900;
        text-transform: uppercase;
        padding: 5px 10px;
        font-size: 0.6rem;
    }

    /* 6. Action Links */
    .btn-action-link {
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.65rem;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        margin-left: 15px;
        transition: 0.2s;
        letter-spacing: 0.5px;
    }
    .btn-action-link:hover {
        border-bottom: 1px solid #000;
        color: #000;
    }
    .btn-delete { color: #cc0000; }

    /* 7. Image Styling */
    .img-product-wrap {
        background: #fcfcfc;
        overflow: hidden;
        width: 60px;
        height: 80px;
    }
    .img-product {
        filter: grayscale(100%);
        transition: all 0.5s ease;
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    tr:hover .img-product { 
        filter: grayscale(0%);
        transform: scale(1.1);
    }
</style>

<div class="d-flex justify-content-between align-items-end mb-5 mt-4">
    <div>
        <h2 class="page-title mb-0">Inventaris</h2>
        <p class="text-muted small fw-bold mt-2">ARSIP MASTER / {{ date('Y') }}</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-luxury">
        Tambah Produk Baru
    </a>
</div>

{{-- Filter Section --}}
<div class="filter-section">
    <form method="GET" class="row align-items-center g-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan kata kunci" value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ strtoupper($category->name) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 text-end">
            <button class="btn btn-luxury w-100" style="background: transparent; color: #000;">Terapkan Filter</button>
        </div>
    </form>
</div>

{{-- Tabel Utama --}}
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th class="ps-0">Foto</th>
                <th>Informasi Produk</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Stok</th>
                <th>Status</th>
                <th class="text-end pe-0">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td class="ps-0">
                    <div class="img-product-wrap">
                        <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" class="img-product">
                    </div>
                </td>
                <td>
                    <div class="fw-900 text-dark text-uppercase" style="font-size: 0.85rem; letter-spacing: -0.5px;">{{ $product->name }}</div>
                    <span class="text-muted small fw-bold" style="font-size: 0.6rem;">ID: {{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td><span class="fw-bold text-muted" style="font-size: 0.7rem;">{{ strtoupper($product->category->name) }}</span></td>
                <td class="fw-900">IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @if($product->stock <= 5)
                        <span class="text-danger fw-900" style="font-size: 0.7rem;">STOK RENDAH: {{ $product->stock }}</span>
                    @else
                        <span class="fw-bold text-muted" style="font-size: 0.7rem;">{{ $product->stock }} UNIT</span>
                    @endif
                </td>
                <td>
                    @if($product->is_active)
                        <span class="badge-status">Aktif</span>
                    @else
                        <span class="badge-offline">Offline</span>
                    @endif
                </td>
                <td class="text-end pe-0">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn-action-link">Lihat</a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-action-link">Ubah</a>
                    
                    <form action="{{ route('admin.products.destroy', $product->id)}}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-action-link btn-delete border-0 bg-transparent p-0" onclick="return confirm('Arsipkan produk ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">
                    <p class="fw-900 text-uppercase small text-muted">Arsip tidak ditemukan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5 d-flex justify-content-between align-items-center mb-5">
    <p class="fw-900 small text-uppercase" style="font-size: 0.6rem; color: #bbb; letter-spacing: 1px;">Halaman: {{ $products->currentPage() }} dari {{ $products->lastPage() }}</p>
    <div class="pagination-gallery">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection