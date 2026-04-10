<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Page Login';
        return view('auth.login', compact('title'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required'],  // Menggunakan 'login' sebagai nama input
            'password' => ['required'],
        ]);
        
        try {
        
            // Ambil username atau email
            $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
            $credentials = [
                $loginField => $credentials['login'],
                'password' => $credentials['password'],
            ];
    
            if (!Auth::attempt($credentials)) {
                return back()->withErrors([
                    'login' => 'Username atau email yang anda masukkan tidak valid.',
                ])->onlyInput('login');
            }
    
            $user = Auth::user();
            if ($user ) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            // Tangani kesalahan di sini, bisa log atau kembalikan pesan kesalahan
            return back()->withErrors([
                'login' => 'Terjadi kesalahan, silakan coba lagi.',
            ])->onlyInput('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}
