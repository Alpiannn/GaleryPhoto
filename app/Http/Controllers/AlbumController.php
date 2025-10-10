<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
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
        $user_id = Auth::user()->id;

        $validasi = $request->validate([
            'nama' => 'required|max:255'
        ]);

        $validasi['user_id'] = $user_id;

        Album::create($validasi);

        return redirect()->route('photos.index')->with('berhasil', 'Album berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $user_id = Auth::user()->id;

        $validasi = $request->validate([
            'nama' => 'required|max:255'
        ]);

        $validasi['user_id'] = $user_id;

        $album->update($validasi);

        return redirect()->route('photos.index')->with('berhasil', 'Album berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('photos.index')->with('berhasil', 'Album berhasil dihapus');
    }
}
