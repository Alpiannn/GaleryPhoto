<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $userid = Auth::user()->id;

        if ($userid != $user->id) {
            return abort(403);
        }

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Authorization - hanya pemilik yang bisa update
        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Rules validasi
        $rules = [
            'name' => 'required|max:255',
            'username' => 'required|alpha_dash|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|file|max:1024'
        ];

        // Jika ada password baru
        if ($request->password) {
            $rules['password'] = 'min:6|max:255';
            $rules['repassword'] = 'same:password';
        }

        // Validasi data
        $validatedData = $request->validate($rules);

        // Handle avatar upload
        if ($request->file('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Generate nama file
            $fileName = 'user-' . $user->id . '-' . time() . '.' . $request->avatar->extension();

            // Upload ke storage
            $avatarPath = $request->file('avatar')->storeAs('avatar', $fileName, 'public');

            // Simpan path ke validated data
            $validatedData['avatar'] = $avatarPath; // "avatar/user-1-1736254321.jpg"
        }

        // Handle password update
        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }

        // Update data user
        $user->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('users.edit', $user->username)
            ->with('berhasil', 'Profil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
