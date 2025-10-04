<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    public function index()
    {
        return view('auth.daftar');
    }

    public function store(Request $request)
    {
        $aturan = [
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:6|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:255',
            'repassword' => 'required|same:password',
        ];

        $validasiData = $request->validate($aturan);

        User::create($validasiData);

        return redirect(route('login'))->with('berhasil', 'Kamu berhasil daftar, silahkan login!');
    }
}
