<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    /**
     * Redirect setelah login berhasil.
     *
     * Property ini menentukan kemana user diarahkan
     * setelah berhasil login jika tidak ada logic khusus.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    // ↑ Default: arahkan ke /home

    /**
     * Constructor: Method yang dipanggil saat class dibuat.
     *
     * Di sini kita mengatur middleware (filter) untuk controller ini.
     */
    public function __construct()
    {
        // ================================================
        // MIDDLEWARE: guest
        // ================================================
        // Artinya: Hanya user yang BELUM LOGIN (guest)
        // yang bisa mengakses halaman login.
        //
        // Logika: Kalau user sudah login, mereka akan di-redirect
        // ke halaman home jika mencoba buka /login lagi.
        //
        // except('logout'): Method logout DIKECUALIKAN.
        // Logout boleh (dan harus) diakses oleh user yang sudah login.
        // ================================================
        $this->middleware('guest')->except('logout');

        // ================================================
        // MIDDLEWARE: auth (Tambahan untuk Logout)
        // ================================================
        // Kita bisa memastikan hanya user yang login yang bisa logout.
        // ================================================
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override method redirectTo untuk custom redirect.
     *
     * Method ini akan dipanggil otomatis oleh Laravel jika ada,
     * menggantikan property $redirectTo di atas.
     *
     * Gunanya untuk logika redirect dinamis (misal beda role).
     *
     * @return string URL tujuan redirect
     */
    protected function redirectTo(): string
    {
        // ================================================
        // LOGIKA REDIRECT DINAMIS
        // ================================================

        // Ambil user yang sedang login saat ini
        $user = auth()->user();

        // Jika role-nya admin, arahkan ke dashboard admin
        if ($user->role === 'admin') {
            // return route('admin.dashboard');
            
        }

       
        return route('home');
    }

    /**
     * Override untuk custom validation rules.
     *
     * Method ini mengatur aturan validasi input dari form login.
     * Jika validasi gagal, user dikembalikan ke form dengan pesan error.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function validateLogin($request): void
    {
        
        $request->validate([
            
            $this->username() => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid (harus ada @).',
            'password.required' => 'Password wajib diisi.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);
    }
}