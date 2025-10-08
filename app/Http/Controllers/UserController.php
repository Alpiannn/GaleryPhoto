<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function update(Request $request, user $user)
    {
        // Authorization - hanya pemilik yang bisa update
        if (Auth::id() !== $user->id) {
            abort(403);
        }

        // Rules validasi
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|alpha_dash|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|file|max:1024'
        ]);

        // Jika ada password baru
        if ($request->password) {
            $validated['password'] = 'min:6|max:255';
            $validated['repassword'] = 'same:password';
        }

        if ($request->hasFile('avatar')) {
            // if (public_path($user->avatar)) {
            //     unlink(public_path($user->avatar));
            // }
            $newAvatar = time() . '.' . $request->avatar->extension();
            $upload = $request->avatar->move(public_path('avatar'), $newAvatar);
            $path = 'avatar/' . $newAvatar;
            $validated['avatar'] = $path;
        }

        // Handle password update
        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        // Update data user
        $user->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('photos.index')
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
