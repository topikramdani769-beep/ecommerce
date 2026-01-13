{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     FUNGSI: BAPE Style Footer (Minimalist & Dark/White)
     ================================================ --}}

<footer class="bape-footer mt-5">
    <div class="container-fluid px-5">
        <div class="row pt-5 pb-4">
            {{-- Brand Section --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h4 class="bape-brand mb-3">SANCHÉZ DÉ LARACHÉ®</h4>
                <p class="bape-text-small">
                    © {{ date('Y') }} NOWHERE Co., Ltd. All rights reserved. <br>
                    Authentic Streetwear Experience.
                </p>
                {{-- Social Media (Minimalist Text Style) --}}
                <div class="d-flex gap-3 mt-4 bape-social">
                    <a href="#">INSTAGRAM</a>
                    <a href="#">FACEBOOK</a>
                    <a href="#">X</a>
                </div>
            </div>

            {{-- Links --}}
            <div class="col-6 col-lg-2">
                <h6 class="bape-heading">SHOP</h6>
                <ul class="list-unstyled bape-links">
                    <li><a href="{{ route('catalog.index') }}">ALL ITEMS</a></li>
                    <li><a href="#">NEW ARRIVALS</a></li>
                    <li><a href="#">CATEGORIES</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="bape-heading">HELP</h6>
                <ul class="list-unstyled bape-links">
                    <li><a href="#">CONTACT</a></li>
                    <li><a href="#">SHIPPING</a></li>
                    <li><a href="#">RETURNS</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h6 class="bape-heading">NEWSLETTER</h6>
                <p class="bape-text-small mb-3">SUBSCRIBE TO RECEIVE UPDATES ON NEW RELEASES.</p>
                <div class="input-group bape-newsletter">
                    <input type="text" class="form-control" placeholder="ENTER EMAIL ADDRESS">
                    <button class="btn btn-dark rounded-0" type="button">SIGN UP</button>
                </div>
            </div>
        </div>

        <div class="bape-bottom-bar border-top py-4">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div class="bape-legal-links">
                    <a href="#" class="me-3">PRIVACY POLICY</a>
                    <a href="#" class="me-3">TERMS & CONDITIONS</a>
                    <a href="#">LEGAL NOTICE</a>
                </div>
                <div class="bape-location">
                    <span class="small fw-bold"><i class="bi bi-globe me-1"></i> INDONESIA / IDR</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* --- BAPE MINIMALIST FOOTER STYLING --- */
    .bape-footer {
        background-color: #ffffff;
        border-top: 2px solid #000;
        font-family: "Helvetica Neue", Arial, sans-serif;
        color: #000;
        letter-spacing: 0.5px;
    }

    .bape-brand {
        font-weight: 900;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }

    .bape-heading {
        font-weight: 800;
        font-size: 0.85rem;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .bape-links li {
        margin-bottom: 8px;
    }

    .bape-links a {
        color: #666;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        transition: color 0.2s ease;
    }

    .bape-links a:hover {
        color: #000;
    }

    .bape-text-small {
        font-size: 0.7rem;
        color: #888;
        line-height: 1.6;
        text-transform: uppercase;
    }

    .bape-social a {
        color: #000;
        font-weight: 800;
        font-size: 0.75rem;
        text-decoration: none;
        border-bottom: 1px solid transparent;
    }

    .bape-social a:hover {
        border-bottom: 1px solid #000;
    }

    /* Newsletter Box ala BAPE */
    .bape-newsletter .form-control {
        border: 1px solid #000;
        border-radius: 0;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 12px;
    }

    .bape-newsletter .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }

    .bape-newsletter .btn {
        border-radius: 0;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0 25px;
    }

    .bape-legal-links a {
        font-size: 0.65rem;
        color: #999;
        text-decoration: none;
        font-weight: 700;
    }

    .bape-bottom-bar {
        border-color: #eee !important;
    }

    /* Menghilangkan garis dekorasi dari versi sebelumnya */
    h6::after {
        display: none !important;
    }
</style>