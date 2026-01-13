<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&display=swap" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light bape-nav sticky-top">
    <div class="container-fluid px-lg-5 position-relative">
        
        <div id="nav-content-wrapper" class="d-flex w-100 align-items-center">
            <a class="navbar-brand bape-logo" href="{{ route('home') }}">
                DE LARACHE
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">SEMUA PRODUK</a>
                    </li>
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalog.index', ['category' => $category->slug]) }}">
                                {{ strtoupper($category->name) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    {{-- TOMBOL CARI --}}
                    <li class="nav-item me-3">
                        <a href="javascript:void(0)" class="nav-link p-0" onclick="toggleSearch()">
                            <i class="ti ti-search fs-4"></i>
                        </a>
                    </li>

                    @auth
                        {{-- WISHLIST --}}
                        <li class="nav-item me-3">
                            <a class="nav-link p-0 position-relative" href="{{ route('wishlist.index') }}">
                                <i class="ti ti-heart fs-4"></i>
                                @php $wishlistCount = auth()->user()->wishlists()->count() ?? 0; @endphp
                                @if($wishlistCount > 0)
                                    <span class="bape-badge">{{ $wishlistCount }}</span>
                                @endif
                            </a>
                        </li>

                        {{-- KERANJANG --}}
                        <li class="nav-item me-3">
                            <a class="nav-link p-0 position-relative" href="{{ route('cart.index') }}">
                                <i class="ti ti-shopping-cart fs-4"></i>
                                @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                                @if($cartCount > 0)
                                    <span class="bape-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>

                        {{-- USER DROPDOWN --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link p-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                                <i class="ti ti-user fs-4"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bape-dropdown">
                                {{-- MENU PESANAN SAYA (BARU) --}}
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('orders.index') }}">
                                        <i class="ti ti-package me-2 fs-5"></i> PESANAN SAYA
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                        <i class="ti ti-settings me-2 fs-5"></i> PROFILE
                                    </a>
                                </li>

                                @if(auth()->user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item fw-bold text-primary" href="{{ route('admin.dashboard') }}">
                                            <i class="ti ti-layout-dashboard me-2 fs-5"></i> ADMIN PANEL
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                            <i class="ti ti-logout me-2 fs-5"></i> LOGOUT
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- TAMPILAN JIKA BELUM LOGIN --}}
                        <li class="nav-item">
                            <a class="nav-link p-0 fw-black" href="{{ route('login') }}" style="font-size: 0.75rem;">LOGIN</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>

        {{-- SEARCH OVERLAY --}}
        <div id="search-overlay" class="search-overlay d-none">
            <div class="container d-flex align-items-center h-100">
                <form action="{{ route('catalog.index') }}" method="GET" class="w-100 d-flex align-items-center">
                    <input type="text" name="search" class="overlay-input" placeholder="CARI PARFUM..." autocomplete="off" id="search-input" value="{{ request('search') }}">
                    <button type="submit" class="bg-transparent border-0 ms-2 p-0">
                        <i class="ti ti-search fs-3 text-dark"></i>
                    </button>
                    <button type="button" class="bg-transparent border-0 ms-3 p-0" onclick="toggleSearch()">
                        <i class="ti ti-x fs-3 text-muted"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
<style>
    .bape-nav {
        background-color: #ffffff !important;
        border-bottom: 2px solid #000000 !important;
        padding: 10px 0 !important;
        text-transform: uppercase;
        min-height: 70px;
    }

    .bape-logo {
        font-family: 'Inter', sans-serif;
        font-weight: 900 !important;
        font-size: 1.4rem !important;
        color: #000 !important;
        letter-spacing: -1px !important;
        text-decoration: none;
    }

    .nav-link {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem !important;
        font-weight: 900 !important;
        color: #000 !important;
        padding: 0 15px !important;
    }

    .bape-badge {
        position: absolute;
        top: -6px;
        right: -8px;
        background: #000;
        color: #fff;
        font-size: 0.55rem;
        width: 16px;
        height: 16px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        font-weight: 900;
    }

    .search-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        z-index: 1050;
    }

    .overlay-input {
        width: 100%;
        border: none;
        border-bottom: 2px solid #000;
        font-size: 1.1rem;
        font-weight: 900;
        outline: none;
        text-transform: uppercase;
        padding: 5px 0;
        font-family: 'Inter', sans-serif;
    }

    .bape-dropdown {
        border: 2px solid #000 !important;
        border-radius: 0 !important;
        margin-top: 10px !important;
        padding: 0 !important;
    }
    .bape-dropdown .dropdown-item {
        font-size: 0.7rem;
        font-weight: 900;
    }

    .invisible { visibility: hidden; opacity: 0; }
</style>

<script>
    function toggleSearch() {
        const overlay = document.getElementById('search-overlay');
        const navWrapper = document.getElementById('nav-content-wrapper');
        const input = document.getElementById('search-input');

        if (overlay.classList.contains('d-none')) {
            overlay.classList.remove('d-none');
            navWrapper.classList.add('invisible');
            setTimeout(() => { input.focus(); }, 50);
        } else {
            overlay.classList.add('d-none');
            navWrapper.classList.remove('invisible');
        }
    }
</script>