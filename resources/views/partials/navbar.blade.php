<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        {{-- Logo & Brand --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-bag-fill me-2"></i>
            Sanchéz Dé Laraché 
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form --}}
            <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 400px; width: 100%;"
                  action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q"
                           class="form-control"
                           placeholder="Cari produk favoritmu..."
                           value="{{ request('q') }}">
                    <button class="btn btn-primary px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid me-1"></i> Katalog
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php
                                $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#" id="userDropdown"
                           data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="rounded-circle me-2 border"
                                 width="35" height="35"
                                 style="object-fit: cover;"
                                 alt="{{ auth()->user()->name }}">
                            <span class="d-none d-lg-inline fw-semibold text-dark">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2"></i> Pesanan Saya
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <a class="dropdown-item text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Guest Links --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-3 rounded-pill px-4" href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


<style>
    
    .navbar {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: rgba(255, 255, 255, 1) !important;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .navbar.scrolled {
        padding-top: 8px;
        padding-bottom: 8px;
        background-color: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05) !important;
    }

    
    .navbar-brand {
        font-weight: 800;
        font-size: 1.4rem;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: transform 0.3s ease;
    }

    
    .input-group .form-control {
        border-radius: 50px 0 0 50px !important;
        background-color: #f1f3f5;
        border: 1px solid transparent;
        padding-left: 20px;
        transition: all 0.3s ease;
    }

    .input-group .form-control:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }

    .input-group .btn {
        border-radius: 0 50px 50px 0 !important;
        padding-right: 20px;
        padding-left: 15px;
    }

    
    .nav-link {
        font-weight: 600;
        color: #495057 !important;
        padding: 0.5rem 1rem !important;
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background: #0d6efd;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-link:hover::after { width: 60%; }
    .nav-link:hover { color: #0d6efd !important; }

    
    .badge {
        font-size: 0.65rem !important;
        padding: 0.4em 0.6em !important;
        border: 2px solid #fff;
        animation: badgePulse 2s infinite;
    }

    @keyframes badgePulse {
        0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
        100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
    }

    
    #userDropdown img {
        padding: 2px;
        border: 2px solid #0d6efd;
        transition: all 0.3s ease;
    }

    
    .dropdown-menu {
        border-radius: 12px;
        padding: 10px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
        transform: translateX(5px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>