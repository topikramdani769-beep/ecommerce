<style>
    /* 1. Sidebar Base - High-End White Gallery */
    .left-sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e5e5e5 !important; /* Garis pemisah sangat halus */
        transition: all 0.3s ease;
    }

    /* 2. Logo Section - Minimalist Spacing */
    .brand-logo {
        padding: 45px 25px !important; 
        background: #ffffff;
        border: none !important;
    }

    /* 3. Label Kecil - Subtle & Wide */
    .nav-small-cap {
        color: #a0a0a0 !important; /* Abu-abu sangat muda */
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 2px;
        font-size: 0.6rem !important;
        margin-top: 25px !important;
        padding: 0 25px !important;
    }

    /* 4. Sidebar Link - Sharp & Bold Typography */
    .sidebar-link {
        color: #000000 !important;
        font-weight: 900 !important; 
        text-transform: uppercase;
        border-radius: 0px !important;
        margin: 0px !important; 
        padding: 16px 25px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        border-left: 4px solid transparent; /* Indikator halus */
    }

    /* 5. Hover State - Subtle Light Grey */
    .sidebar-link:hover {
        background-color: #f9f9f9 !important;
        color: #000000 !important;
        border-left: 4px solid #eeeeee;
    }

    /* 6. Active State - Solid Black Invert */
    .sidebar-item.selected > .sidebar-link,
    .sidebar-link.active {
        background-color: #000000 !important;
        color: #ffffff !important;
        border-left: 4px solid #000000;
        box-shadow: none !important;
    }

    /* Icon Styling */
    .sidebar-link i {
        font-size: 1.1rem;
        margin-right: 12px;
        color: inherit; /* Ikut warna teks (hitam atau putih saat aktif) */
    }

    /* Scrollbar Style - Minimalist */
    .simplebar-track.simplebar-vertical { background: #ffffff; width: 6px; }
    .simplebar-scrollbar:before { 
        background: #e0e0e0 !important; 
        border-radius: 0px !important;
    }
</style>

<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center">
      <a href="{{ route('home') }}" class="text-nowrap logo-img">
        {{-- Typographic Logo: Black on White --}}
        <h2 class="text-black fw-900 m-0" style="letter-spacing: -1.5px; line-height: 0.85; font-family: 'Inter', sans-serif;">
            DE<br>LARACHE
        </h2>
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8 text-black"></i>
      </div>
    </div>
    
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav" class="mt-2">
        <li class="nav-small-cap">
          <span class="hide-menu">Dashboard Admin</span>
        </li>
        
        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <span><i class="ti ti-grid-dots"></i></span>
            <span class="hide-menu">Semua Rincian</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <span><i class="ti ti-archive"></i></span>
            <span class="hide-menu">Produk</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ url('admin/categories') }}">
            <span><i class="ti ti-hash"></i></span>
            <span class="hide-menu">Kategori</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <span><i class="ti ti-shopping-cart"></i></span>
            <span class="hide-menu">Order</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.sales') }}">
            <span><i class="ti ti-chart-pie"></i></span>
            <span class="hide-menu">Laporan Pesanan</span>
          </a>
        </li>

        <li class="nav-small-cap" style="margin-top: 40px !important;">
          <span class="hide-menu">Halaman Utama</span>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('home') }}" target="_blank">
              <span><i class="ti ti-arrow-up-right"></i></span>
              <span class="hide-menu">Halaman Belanja</span>
            </a>
          </li>
      </ul>
    </nav>
  </div>
</aside>