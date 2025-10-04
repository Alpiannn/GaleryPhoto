<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $aturan = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $datalogin = $request->validate($aturan);

        if (Auth::attempt($datalogin)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }
        return back()->with('gagal', 'Login gagal, periksa Email dan Password Anda!');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect(Route('login'));
    }
}
