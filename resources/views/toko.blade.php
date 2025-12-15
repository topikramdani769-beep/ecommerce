{{-- ======================================== FILE:
resources/views/tentang.blade.php FUNGSI: Halaman tentang toko online
======================================== --}}

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    {{-- ↑ Encoding karakter --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- ↑ Responsive untuk mobile --}}

    <title>Tentang Twopick Mart</title>

    <style>
      body {
        font-family: system-ui, -apple-system, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
      }
      h1 {
        color: #e40808; /* Warna indigo */
      }
    </style>
  </head>
  <body>
    <h1>Twopick Mart</h1>
    <p>Selamat datang di toko online kami.</p>
    <p>Dibuat dengan menggunakan Laravel.</p>

    {{-- ================================================ BLADE SYNTAX: {{ }}
    ================================================ Kurung kurawal ganda
    digunakan untuk menampilkan data PHP Data otomatis di-escape untuk mencegah
    XSS attack ================================================ --}}
    <p>Waktu saat ini: {{ now()->format('d M Y, H:i:s') }}</p>
    {{-- ↑ now() = Fungsi Laravel untuk waktu sekarang ↑ ->format() = Format
    tanggal sesuai pattern ↑ d M Y, H:i:s = 11 Dec 2024, 14:30:00 --}}

    <a href="/">← Kembali ke Allah</a>
    {{-- ↑ Link biasa ke halaman utama --}}

    {{-- Di file Blade manapun --}}
<a href="{{ route('produk.detail', ['id' => 1]) }}">Lihat Produk 1</a>
<a href="{{ route('produk.detail', ['id' => 2]) }}">Lihat Produk 2</a>

{{-- Kenapa pakai named route, bukan hardcode URL? --}}
{{-- ✅ Mudah diubah: Jika URL berubah, cukup ubah di routes/web.php --}}
{{-- ✅ Tidak typo: Jika nama salah, Laravel akan error (cepat ketahuan) --}}
{{-- ❌ Hardcode: <a href="/produk/1"> - Jika URL berubah, harus edit semua --}}
  </body>
</html>