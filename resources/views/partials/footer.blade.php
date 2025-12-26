{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     FUNGSI: Footer website (MODERN & ELEGANT VERSION)
     ================================================ --}}

<footer class="custom-footer text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-brand mb-3">
                    <i class="bi bi-bag-fill me-2"></i>Sanchéz Dé Laraché 
                </h5>
                <p class="text-secondary pe-lg-5">
                    Toko online terpercaya dengan berbagai produk pilihan berkualitas tinggi. 
                    Kami hadir untuk memberikan pengalaman belanja yang mudah, aman, dan berkesan bagi setiap pelanggan.
                </p>
                {{-- Social Media Icons --}}
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-bold mb-4">Menu Utama</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}">Katalog Produk</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Tentang Kami</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Promo Terbaru</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Testimoni</a>
                    </li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white fw-bold mb-4">Bantuan</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2">
                        <a href="#">FAQ (Tanya Jawab)</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Cara Belanja</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Kebijakan Privasi</a>
                    </li>
                    <li class="mb-2">
                        <a href="#">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white fw-bold mb-4">Hubungi Kami</h6>
                <ul class="list-unstyled footer-contact">
                    <li class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <span class="text-secondary small">Jl. Cisirung No. 123, Pasawahan, Bandung</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                        <span class="text-secondary small">(022) 123-4567 / +62 812 3456 789</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-envelope-at-fill text-primary me-3 fs-5"></i>
                        <span class="text-secondary small">hello@sanchezdelarache.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        {{-- Bottom Footer --}}
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary mb-0 small">
                    &copy; {{ date('Y') }} <span class="fw-bold">Sanchéz Dé Laraché</span>. Made with <i class="bi bi-heart-fill text-danger mx-1"></i> in Bandung.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="payment-methods">
                    <span class="text-secondary small me-2">Metode Pembayaran Aman:</span>
                    {{-- Jika gambar belum ada, ikon ini sebagai placeholder --}}
                    <i class="bi bi-credit-card-2-back fs-4 text-secondary mx-1"></i>
                    <i class="bi bi-wallet2 fs-4 text-secondary mx-1"></i>
                    <i class="bi bi-bank fs-4 text-secondary mx-1"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* --- CUSTOM FOOTER STYLING --- */
    .custom-footer {
        background-color: #0f1116; /* Darker more premium background */
        font-family: 'Inter', sans-serif;
    }

    /* Logo Brand di Footer */
    .footer-brand {
        font-weight: 800;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #3d8bff 0%, #a873ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Links Styling */
    .footer-links a {
        color: #adb5bd;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .footer-links a:hover {
        color: #3d8bff;
        padding-left: 8px; /* Animasi bergeser sedikit */
    }

    /* Social Icon Circles */
    .social-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #adb5bd;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .social-icon:hover {
        background-color: #3d8bff;
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(61, 139, 255, 0.4);
    }

    /* Contact Info Icons */
    .footer-contact i {
        min-width: 25px;
    }

    /* Smooth underline for footer headings */
    h6::after {
        content: '';
        display: block;
        width: 30px;
        height: 2px;
        background: #3d8bff;
        margin-top: 10px;
        border-radius: 2px;
    }
</style>