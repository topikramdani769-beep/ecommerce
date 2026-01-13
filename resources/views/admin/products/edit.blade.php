@extends('layouts.admin')

@section('title', 'Edit Produk')

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

    /* 2. Luxury Card (Borderless) */
    .card-luxury {
        border-radius: 0px;
        border: none;
        background: #ffffff;
        margin-bottom: 40px;
    }

    /* 3. Section Divider */
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

    /* 4. Luxury Form Elements */
    .form-label {
        color: #999;
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: none;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0px;
        font-weight: 700;
        padding: 12px 0;
        font-size: 0.9rem;
        transition: all 0.3s;
        background-color: transparent;
    }

    .form-control:focus, .form-select:focus {
        border-color: #000;
        box-shadow: none;
        background-color: transparent;
    }

    .input-group-text {
        background: transparent;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0px;
        font-weight: 900;
        font-size: 0.8rem;
    }

    /* 5. Image Management Style */
    .img-preview-container {
        border: 1px solid #f2f2f2;
        padding: 5px;
        background: #fff;
        transition: all 0.3s;
        position: relative;
    }
    .img-preview-container:hover {
        border-color: #000;
    }
    .img-actual {
        height: 200px;
        width: 100%;
        object-fit: cover;
        filter: grayscale(100%);
        transition: 0.4s;
    }
    .img-preview-container:hover .img-actual {
        filter: grayscale(0%);
    }

    /* 6. Action Elements */
    .btn-luxury-save {
        background: #000;
        color: #fff;
        border: 1px solid #000;
        font-weight: 900;
        padding: 18px;
        border-radius: 0px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-luxury-save:hover {
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
    }

    .form-check-input {
        border-radius: 0px !important;
        border: 1px solid #000;
    }
    .form-check-input:checked {
        background-color: #000;
        border-color: #000;
    }
    .form-check-label {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<div class="row justify-content-center pb-5">
    <div class="col-lg-11">

        {{-- Alert Errors --}}
        @if ($errors->any())
            <div class="alert alert-dark border-0 rounded-0 mb-4">
                <ul class="mb-0 small fw-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ strtoupper($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-end mb-5 mt-4">
            <div>
                <h2 class="page-title mb-0">Ubah Produk</h2>
                <p class="text-muted small mb-0 fw-bold mt-2">MODIFIKASI ARSIP / ID: {{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn-back-link">
                Kembali ke Katalog
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Konten Utama --}}
                <div class="col-md-8">
                    <div class="card card-luxury">
                        <div class="card-body p-0 pe-md-4">
                            <span class="section-divider">Informasi Produk</span>
                            
                            <div class="mb-5">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $product->name) }}" placeholder="Nama koleksi" required>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Deskripsi Koleksi</label>
                                {{-- TEXTAREA BIASA TANPA JS --}}
                                <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror" 
                                    placeholder="Tuliskan detail aroma dan piramida nada parfum di sini..." required>{{ old('description', $product->description) }}</textarea>
                            </div>

                            <span class="section-divider mt-5">Galeri Visual</span>
                            
                            <div class="mb-4">
                                <label class="form-label">Tambahkan Foto Baru</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                                <p class="text-muted small mt-2 fw-bold" style="font-size: 0.6rem;">FORMAT: JPG, PNG, WEBP</p>
                            </div>

                            <div class="row g-4">
                                @foreach($product->images as $image)
                                <div class="col-md-4 col-6">
                                    <div class="img-preview-container">
                                        <img src="{{ asset('storage/'.$image->image_path) }}" class="img-actual">
                                        <div class="p-3 bg-white border-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="primary_image" id="p{{ $image->id }}" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2" for="p{{ $image->id }}">Foto Utama</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_images[]" id="d{{ $image->id }}" value="{{ $image->id }}">
                                                <label class="form-check-label ms-2 text-danger" for="d{{ $image->id }}">Hapus Foto</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Atribut & Simpan --}}
                <div class="col-md-4">
                    <div class="card card-luxury">
                        <div class="card-body p-0 ps-md-2">
                            <span class="section-divider">Harga & Stok</span>
                            
                            <div class="mb-4">
                                <label class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">IDR</span>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Ketersediaan Stok</label>
                                <div class="input-group">
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                                    <span class="input-group-text">UNIT</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Berat Produk</label>
                                <div class="input-group">
                                    <input type="number" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" required>
                                    <span class="input-group-text">GRAM</span>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ strtoupper($category->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <span class="section-divider">Pengaturan Status</span>
                            
                            <div class="form-check form-switch mb-3 mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="sw1" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="sw1">Tampilkan ke Publik</label>
                            </div>

                            <div class="form-check form-switch mb-5">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="sw2" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="sw2">Sorot Sebagai Unggulan</label>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-luxury-save">
                                    Perbarui Koleksi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection