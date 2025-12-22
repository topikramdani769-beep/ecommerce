<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #5d87ff; --bg-light: #f4f7fb; }
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Sidebar Style dari gambar */
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #fff; padding: 20px; border-right: 1px solid #e5eaef; }
        .nav-link { color: #2a3547; font-weight: 500; padding: 12px; border-radius: 7px; margin-bottom: 5px; display: block; text-decoration: none; }
        .nav-link.active { background: var(--primary-blue); color: #fff !important; }
        .nav-link:hover:not(.active) { background: #f0f5ff; color: var(--primary-blue); }
        .section-title { font-size: 12px; font-weight: 700; color: #2a3547; margin-top: 20px; text-transform: uppercase; }

        /* Content Area */
        .main-content { margin-left: 260px; padding: 30px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
        .btn-primary { background-color: var(--primary-blue); border: none; padding: 10px 20px; border-radius: 8px; }
        .form-control { border-radius: 8px; border: 1px solid #dfe5ef; padding: 12px; }
        .form-control:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 0.25 margin-left: rgba(93, 135, 255, 0.1); }
    </style>
</head>
<body>

<div class="sidebar d-none d-lg-block">
    <div class="mb-4 ps-3">
        <h4 class="fw-bold text-primary">AdminPanel</h4>
    </div>
    
    <div class="section-title mb-2 ps-3">Home</div>
    <a href="#" class="nav-link"><i class="fas fa-layout me-2"></i> Dashboard</a>

    <div class="section-title mb-2 ps-3">UI Components</div>
    <a href="{{ route('admin.products.index') }}" class="nav-link active"><i class="fas fa-box me-2"></i> Products</a>
    <a href="#" class="nav-link"><i class="fas fa-list me-2"></i> Forms</a>
    <a href="#" class="nav-link"><i class="fas fa-font me-2"></i> Typography</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Add New Product</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4 text-dark">Product Information</h5>
            
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga (IDR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" name="price" class="form-control" placeholder="0" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Sisa Stok</label>
                        <input type="number" name="stock" class="form-control" placeholder="0" required>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="5" class="form-control" placeholder="Describe your product..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>