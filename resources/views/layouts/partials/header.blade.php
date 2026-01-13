<style>
    /* GLOBAL BAPE BRUTALIST STYLE */
    :root {
        --bape-black: #000000;
        --bape-white: #ffffff;
        --bape-gray: #f0f0f0;
    }

    body {
        background-color: var(--bape-gray) !important;
        font-family: 'Inter', 'Courier New', sans-serif !important;
        color: var(--bape-black);
    }

    /* 1. KARTU DASHBOARD (CARDS) */
    .card, .main-card, .card-luxury {
        background: var(--bape-white) !important;
        border: 4px solid var(--bape-black) !important;
        border-radius: 0px !important; /* Kotak tajam */
        box-shadow: 8px 8px 0px var(--bape-black) !important; /* Shadow solid kaku */
        transition: 0.2s;
        margin-bottom: 25px;
    }

    .card:hover {
        transform: translate(-3px, -3px);
        box-shadow: 12px 12px 0px var(--bape-black) !important;
    }

    /* 2. TABEL (INDEX & LAPORAN) */
    .table-responsive {
        border: 4px solid var(--bape-black);
        background: white;
    }
    
    .table { margin-bottom: 0; }

    .table thead th {
        background: var(--bape-black) !important;
        color: var(--bape-white) !important;
        border: none !important;
        text-transform: uppercase;
        font-weight: 900 !important;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 15px !important;
    }

    .table tbody td {
        border-bottom: 2px solid var(--bape-black) !important;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 15px !important;
    }

    /* 3. FILTER NAV (PADA MANAJEMEN PESANAN) */
    .filter-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border: none !important;
    }

    .filter-link {
        border: 4px solid var(--bape-black) !important;
        border-radius: 0px !important;
        background: var(--bape-white);
        color: var(--bape-black) !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        padding: 10px 20px !important;
        text-decoration: none;
        font-size: 0.7rem;
    }

    .filter-link.active, .filter-link:hover {
        background: var(--bape-black) !important;
        color: var(--bape-white) !important;
    }

    /* 4. BADGE STATUS */
    .status-badge {
        border-radius: 0px !important;
        border: 2px solid var(--bape-black) !important;
        padding: 5px 12px !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        font-size: 0.65rem !important;
    }

    .status-delivered, .status-processing, .status-completed {
        background: var(--bape-black) !important;
        color: var(--bape-white) !important;
    }

    .status-pending {
        background: var(--bape-white) !important;
        color: var(--bape-black) !important;
    }

    /* 5. TOMBOL & FORM */
    .btn-primary, .btn-success, .btn-dark-modern {
        background: var(--bape-black) !important;
        border: none !important;
        border-radius: 0px !important;
        color: var(--bape-white) !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        padding: 12px 25px !important;
        box-shadow: 5px 5px 0px #666;
    }

    .btn-primary:hover {
        box-shadow: 7px 7px 0px var(--bape-black);
        transform: translate(-2px, -2px);
    }

    input.form-control {
        border: 4px solid var(--bape-black) !important;
        border-radius: 0px !important;
        font-weight: 800;
        padding: 10px;
    }

    /* 6. PROGRESS BAR (LAPORAN) */
    .progress {
        height: 15px !important;
        border-radius: 0px !important;
        background: #eee !important;
        border: 3px solid var(--bape-black) !important;
        overflow: hidden;
    }

    .progress-bar {
        background: var(--bape-black) !important;
    }

    /* 7. TYPOGRAPHY */
    .page-title {
        font-weight: 900 !important;
        text-transform: uppercase;
        letter-spacing: -1.5px;
        border-left: 10px solid var(--bape-black);
        padding-left: 15px;
    }
</style>

<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2 fs-7"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover position-relative" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing fs-7"></i>
                    <div class="notification"></div>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                {{-- Tombol Shop Now Monochrome --}}
                <a href="{{ route('catalog.index') }}" class="btn btn-bape-black px-4 fw-black d-none d-md-block me-3">
                    <i class="ti ti-shopping-cart me-1"></i> SHOP NOW
                </a>
                
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover p-0" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../assets/images/profile/user-1.jpg" alt="Profile" width="45" height="45" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">MY PROFILE</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">MY ACCOUNT</p>
                            </a>
                            <div class="p-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-dark w-100 fw-black rounded-0">LOGOUT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>