@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* 1. Global Minimalist Style */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1.5px; 
        font-size: 2rem;
    }

    /* 2. Luxury Table Styling */
    .table { border-color: #f2f2f2; }
    .table thead th {
        background-color: #ffffff;
        border-bottom: 2px solid #000;
        color: #000;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 900;
        letter-spacing: 1px;
        padding: 15px 10px;
    }
    .table tbody td {
        padding: 20px 10px;
        border-bottom: 1px solid #f2f2f2;
        vertical-align: middle;
    }

    /* 3. Image & Badge Styling */
    .cat-img-wrap {
        width: 50px;
        height: 50px;
        object-fit: cover;
        filter: grayscale(100%);
        transition: 0.3s;
        border: 1px solid #f2f2f2;
    }
    tr:hover .cat-img-wrap { filter: grayscale(0%); border-color: #000; }

    .badge-minimal {
        border-radius: 0px;
        font-size: 0.6rem;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: 1px;
        padding: 6px 12px;
    }
    .bg-black { background-color: #000 !important; color: #fff; }
    .bg-outline-black { border: 1px solid #000; color: #000; background: transparent; }

    /* 4. Luxury Modal */
    .modal-content {
        border-radius: 0px !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    .modal-header {
        border-bottom: 2px solid #000;
        padding: 2rem;
    }
    .modal-title {
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 1rem;
    }
    .modal-body { padding: 2rem; }
    .form-control {
        border-radius: 0px;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
        font-weight: 600;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }

    /* 5. Buttons */
    .btn-luxury {
        border-radius: 0px;
        text-transform: uppercase;
        font-weight: 900;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 10px 20px;
        transition: 0.3s;
    }
    .btn-black { background: #000; color: #fff; border: 1px solid #000; }
    .btn-black:hover { background: #fff; color: #000; }
    
    .action-link {
        color: #000;
        text-decoration: none;
        font-weight: 900;
        font-size: 0.65rem;
        text-transform: uppercase;
        border-bottom: 1px solid #000;
        margin-left: 15px;
        transition: 0.2s;
    }
    .action-link:hover { opacity: 0.5; }
    .text-delete { color: #dc3545; border-color: #dc3545; }

    .bi { font-family: bootstrap-icons !important; }
</style>
@endpush

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-lg-12">

        {{-- FLASH MESSAGE CUSTOM --}}
        @if(session('success'))
        <div class="alert alert-dark border-0 rounded-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-check-all fs-4 me-3"></i>
            <div class="small fw-bold text-uppercase letter-spacing-1">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- HEADER SECTION --}}
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="page-title mb-0">Manajemen Kategori</h2>
                <p class="text-muted small mb-0 fw-bold mt-2 text-uppercase letter-spacing-1">Pengorganisasian Inventaris / Arsitektur Katalog</p>
            </div>
            <button class="btn btn-luxury btn-black" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
            </button>
        </div>

        {{-- TABLE CARD --}}
        <div class="card border-0 shadow-none">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="ps-0" style="width: 40%">Identitas Kategori</th>
                                <th class="text-center">Volume Produk</th>
                                <th class="text-center">Status Operasional</th>
                                <th class="text-end pe-0">Opsi Modifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ Storage::url($category->image) }}" class="cat-img-wrap me-3">
                                        @else
                                            <div class="cat-img-wrap me-3 d-flex align-items-center justify-content-center bg-light">
                                                <i class="bi bi-archive text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-900 text-uppercase mb-0" style="font-size: 0.9rem; letter-spacing: -0.5px;">{{ $category->name }}</div>
                                            <code class="text-muted" style="font-size: 0.7rem;">/{{ $category->slug }}</code>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="fw-bold" style="font-size: 1.1rem;">{{ $category->products_count }}</span>
                                    <div class="text-muted text-uppercase" style="font-size: 0.6rem; font-weight: 800; letter-spacing: 1px;">Item Terdaftar</div>
                                </td>

                                <td class="text-center">
                                    @if($category->is_active)
                                        <span class="badge badge-minimal bg-black">Aktif</span>
                                    @else
                                        <span class="badge badge-minimal bg-outline-black text-muted border-light">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-end pe-0">
                                    <a href="#" class="action-link" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">Ubah</a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Arsipkan kategori ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-link text-delete bg-transparent border-0 p-0 shadow-none">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <span class="text-muted text-uppercase fw-900 letter-spacing-2">Arsip Kosong</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALS (Create & Edit) --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Modifikasi Kategori</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="small fw-900 text-uppercase letter-spacing-1 text-muted d-block mb-2">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <div class="mb-4">
                    <label class="small fw-900 text-uppercase letter-spacing-1 text-muted d-block mb-2">Citra Kategori (Opsional)</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                    <label class="small fw-900 text-uppercase letter-spacing-1 ms-2">Status Publikasi</label>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-luxury btn-black w-100 py-3">Perbarui Arsip</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Entri Kategori Baru</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="small fw-900 text-uppercase letter-spacing-1 text-muted d-block mb-2">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: ATRIBUT PRIA" required>
                </div>
                <div class="mb-4">
                    <label class="small fw-900 text-uppercase letter-spacing-1 text-muted d-block mb-2">Citra Visual</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="small fw-900 text-uppercase letter-spacing-1 ms-2">Aktivasi Langsung</label>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-luxury btn-black w-100 py-3">Simpan ke Katalog</button>
            </div>
        </form>
    </div>
</div>
@endsection