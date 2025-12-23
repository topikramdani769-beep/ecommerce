@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Daftar Produk</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary px-4 py-2" style="background-color: #5d87ff; border-color: #5d87ff; border-radius: 8px;">
        Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control border-light-subtle" placeholder="Cari produk..." 
                       value="{{ request('search') }}" style="background-color: #f8fafc;">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select border-light-subtle" style="background-color: #f8fafc;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-primary w-100" style="color: #5d87ff; border-color: #5d87ff;">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: #fff;">
                <tr>
                    <th class="ps-4 text-muted fw-semibold">Gambar</th>
                    <th class="text-muted fw-semibold">Nama</th>
                    <th class="text-muted fw-semibold">Kategori</th>
                    <th class="text-muted fw-semibold">Harga</th>
                    <th class="text-muted fw-semibold">Stok</th>
                    <th class="text-muted fw-semibold">Status</th>
                    <th class="text-muted fw-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="ps-4">
                        <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                             class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $product->name }}</span>
                    </td>
                    <td class="text-muted">{{ $product->category->name }}</td>
                    <td class="text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-muted">{{ $product->stock }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge" style="background-color: #13deb9; color: white; padding: 6px 12px; border-radius: 6px;">Aktif</span>
                        @else
                            <span class="badge" style="background-color: #49beff; color: white; padding: 6px 12px; border-radius: 6px;">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm text-white" style="background-color: #5d87ff; border-radius: 4px;">Detail</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm text-white" style="background-color: #ffae1f; border-radius: 4px;">Edit</a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" style="border-radius: 4px;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Data produk tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection