<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Hanya guest yang bisa akses login, kecuali logout
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Logic Redirect setelah login berhasil
     */
    protected function redirectTo(): string
    {
        $user = auth()->user();

        // 1. Jika role adalah admin, arahkan ke folder /admin
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        }

        // 2. Jika bukan admin (customer), arahkan ke homepage
        // Ini akan mengarah ke Route::get('/', [HomeController::class, 'index'])
        return '/';
    }

    /**
     * Custom Validation Rules (BAPE Style Messages)
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'EMAIL WAJIB DIISI.',
            'email.email'       => 'FORMAT EMAIL TIDAK VALID.',
            'password.required' => 'PASSWORD WAJIB DIISI.',
            'password.min'      => 'PASSWORD MINIMAL 6 KARAKTER.',
        ]);
    }
}