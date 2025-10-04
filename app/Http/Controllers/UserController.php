<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        // Ambil data user 
        $userid = Auth()->user()->id;

        if ($userid != $user->id) {
            return abort(403);
        }

        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $aturan = [
            'name' => 'required|max:255',
            'avatar' => 'image|file|max:1024'
        ];

        if ($request->password) {
            $aturan['password'] = 'min:6|max:255';
            $aturan['repassword'] = 'same:password';
        }
        if ($request->email != $user->email) {
            $aturan['email'] = 'required|email|unique:users';
        }

        // Jalankan validasi data
        $validasiData = $request->validate($aturan);

        // Jika user mengupload photo profil
        if ($request->file('avatar')) {
            // jika sebelumnya user sudah punya photo profil
            if ($user->avatar) {
                // photo profil yang lama harus dihapus
                Storage::delete($user->avatar);
            }

            // Simpan photo profil yang baru
            $validasiData['avatar'] = $request->file('avatar')->store('avatar');
        }

        // update data user
        User::where('id', $user->id)->update($validasiData);

        // jika berhasil arahkan kembali ke halaman edit user sambil kirim session 'berhasil'
        return redirect(route('users.edit', $request->username))
            ->with('berhasil', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
