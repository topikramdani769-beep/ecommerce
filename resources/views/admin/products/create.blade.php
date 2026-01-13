@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<style>
    body { background-color: #fffaf5; }
    .page-title { color: #ea580c; font-weight: 800; }
    .card-custom { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(234, 88, 12, 0.05); background: #ffffff; }
    .section-divider { border-left: 4px solid #f97316; padding-left: 15px; color: #9a3412; font-weight: 700; margin-bottom: 20px; margin-top: 30px; }
    .form-control:focus, .form-select:focus { border-color: #fdba74; box-shadow: 0 0 0 0.25rem rgba(251, 146, 60, 0.1); }
    .btn-orange-gradient { background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%); border: none; color: white; font-weight: 700; padding: 12px 25px; border-radius: 12px; transition: all 0.3s; }
    .btn-orange-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(234, 88, 12, 0.3); color: white; }
    .input-group-text { background-color: #fff7ed; color: #9a3412; font-weight: 600; border-color: #dee2e6; }
    .text-orange { color: #ea580c; }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4">
                <div class="fw-bold"><i class="bi bi-exclamation-circle-fill me-2"></i> Mohon perbaiki kesalahan berikut:</div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-0 page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Produk Baru
                </h2>
                <p class="text-muted small mb-0">Input koleksi parfum terbaru ke katalog toko.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning rounded-pill px-4" style="color: #ea580c; border-color: #fdba74;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card card-custom shadow-sm">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- INFORMASI DASAR --}}
                    <div class="section-divider mt-0">
                        <i class="bi bi-info-circle-fill me-2"></i>Informasi Dasar
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Contoh: Midnight Oud Royale" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi Produk</label>
                        <textarea name="description" rows="8" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Gunakan piramida aroma (Top, Mid, Base notes)..." required>{{ old('description') }}</textarea>
                    </div>

                    {{-- HARGA --}}
                    <div class="section-divider">
                        <i class="bi bi-currency-dollar me-2"></i>Informasi Harga
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Harga Jual (Fix)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control form-control-lg @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" placeholder="0" required>
                            </div>
                            <small class="text-muted italic">Harga yang dibayar pembeli.</small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-muted">Harga Diskon / Coret (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="discount_price" class="form-control form-control-lg @error('discount_price') is-invalid @enderror"
                                    value="{{ old('discount_price') }}" placeholder="0">
                            </div>
                            <small class="text-muted">Jika diisi, harga ini akan dicoret di tampilan.</small>
                        </div>
                    </div>

                    {{-- INVENTARIS --}}
                    <div class="section-divider">
                        <i class="bi bi-box-seam me-2"></i>Stok & Berat
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Jumlah Stok</label>
                            <div class="input-group">
                                <input type="number" name="stock" class="form-control form-control-lg @error('stock') is-invalid @enderror"
                                    value="{{ old('stock') }}" placeholder="0" required>
                                <span class="input-group-text">Pcs</span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Berat Pengiriman</label>
                            <div class="input-group">
                                <input type="number" name="weight" class="form-control form-control-lg @error('weight') is-invalid @enderror"
                                    value="{{ old('weight') }}" placeholder="0" required>
                                <span class="input-group-text">Gram</span>
                            </div>
                        </div>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="section-divider">
                        <i class="bi bi-images me-2"></i>Galeri Visual
                    </div>

                    <div class="mb-4">
                        <div class="p-4 border border-2 border-dashed rounded-4 text-center bg-light" style="border-style: dashed !important; border-color: #fdba74 !important;">
                            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple>
                            <p class="mt-2 text-muted small mb-0">Format: JPG, PNG, WEBP. Bisa pilih lebih dari 1 gambar.</p>
                        </div>
                    </div>

                    {{-- STATUS --}}
                    <div class="section-divider">
                        <i class="bi bi-toggle-on me-2"></i>Status Produk
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch p-3 ps-5 rounded-3 border bg-white shadow-sm">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCheck" checked>
                                <label class="form-check-label fw-bold" for="activeCheck">Tampilkan di Toko</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch p-3 ps-5 rounded-3 border bg-white shadow-sm">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featuredCheck">
                                <label class="form-check-label fw-bold" for="featuredCheck">Jadikan Produk Unggulan</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-orange-gradient btn-lg py-3">
                            <i class="bi bi-save me-2"></i>Simpan Produk Sekarang
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection