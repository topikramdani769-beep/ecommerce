<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'SanchezDelarache') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- SweetAlert2 untuk Notifikasi Mewah --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')

    <style>
        /* Custom Styling untuk Toast agar tema Hitam Putih (De Larache) */
        .colored-toast.swal2-icon-success { background-color: #000000 !important; }
        .swal2-popup.swal2-toast {
            border: 2px solid #000 !important;
            border-radius: 0 !important;
            box-shadow: 5px 5px 0px 0px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGES (Untuk request non-AJAX) --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- MAIN CONTENT --}}
    <main class="min-vh-100">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- JAVASCRIPT LOGIC --}}
    <script>
        /**
         * 1. Fungsi showToast
         * Didefinisikan agar bisa dipanggil oleh fungsi toggleWishlist
         */
        function showToast(message, type = "success") {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: `<span style="font-weight:700; font-family:'Inter'; text-transform: uppercase; font-size: 0.8rem;">${message}</span>`,
                background: '#ffffff',
                iconColor: type === 'success' ? '#000000' : '#ff0000',
            });
        }

        /**
         * 2. Fungsi AJAX untuk Toggle Wishlist
         */
        async function toggleWishlist(productId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                });

                if (response.status === 401) {
                    window.location.href = "/login";
                    return;
                }

                const data = await response.json();

                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    
                    // Memanggil fungsi notifikasi yang baru dibuat
                    showToast(data.message); 
                }
            } catch (error) {
                console.error("Error:", error);
                showToast("Terjadi kesalahan sistem.", "error");
            }
        }

        function updateWishlistUI(productId, isAdded) {
            const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);
            buttons.forEach((btn) => {
                const icon = btn.querySelector("i");
                if (isAdded) {
                    icon.classList.remove("bi-heart", "text-secondary");
                    icon.classList.add("bi-heart-fill", "text-danger");
                } else {
                    icon.classList.remove("bi-heart-fill", "text-danger");
                    icon.classList.add("bi-heart", "text-secondary");
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? "inline-block" : "none";
            }
        }

        /**
         * 3. Handle Flash Messages dari Session (jika ada)
         * Agar notifikasi dari redirect juga otomatis menggunakan SweetAlert
         */
        @if(session('success'))
            showToast("{{ session('success') }}");
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}", "error");
        @endif
    </script>

    {{-- Stack untuk JS tambahan per halaman --}}
    @stack('scripts')
</body>
</html>