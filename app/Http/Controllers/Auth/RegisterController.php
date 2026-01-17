<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // <-- TAMBAHKAN INI

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirect setelah registrasi berhasil.
     */
    protected $redirectTo = '/login'; // <-- UBAH KE /login

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi data registrasi.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar. Gunakan email lain.',
            'password.min'       => 'Password minimal 8 karakter agar aman.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Buat user baru setelah validasi berhasil.
     */
    protected function create(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'customer',
        ]);
    }

    /**
     * OVERRIDE: Method ini dijalankan SETELAH user berhasil dibuat.
     * Kita paksa logout agar user harus login manual.
     */
    protected function registered(Request $request, $user)
    {
        // Logout otomatis karena Laravel defaultnya langsung login
        $this->guard()->logout();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'REGISTRASI BERHASIL. SILAKAN MASUK KE AKUN ANDA.');
    }
}