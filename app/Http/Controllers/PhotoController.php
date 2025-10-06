<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userid = Auth::user()->id;

        return view('photos.index', [
            'albums' => Album::where('user_id', $userid)->latest()->get(),
            'photos' => Photo::where('user_id', $userid)
                ->latest()
                ->filter(request(['cari', 'album', 'arsip']))
                ->paginate(12)
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.create', [
            'albums' => Album::where('user_id', Auth()->user()->id)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255',
            'album_id' => 'nullable|exists:albums,id',
            'body' => 'nullable|string',
            'publish' => 'boolean'
        ]);

        $photo = time() . '.' . $request->photo->extension();
        $upload = $request->photo->move(public_path('photo'), $photo);
        $filePath = 'photo/' . $photo;
        $validated['photo'] = $filePath;

        $validated['user_id'] = auth()->id();

        // Simpan data ke database
        Photo::create($validated);

        return redirect()->route('photos.index')->with('berhasil', 'Photo berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('photos.show', [
            'photo' => $photo,
            'comments' => Comment::where('photo_id', $photo->id)->get(),
            'likes' => Like::where('photo_id', $photo->id)
                ->where('user_id', Auth()->user()->id)
                ->get(),
            'likecount' => Like::where('photo_id', $photo->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        $albums =  Album::where('user_id', Auth()->user()->id)->get();
        return view('photos.edit', compact('photo', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $aturan = [
            'nama' => 'required|max:255',
            'photo' => 'required|image|file|max:2048',
            'body' => 'max:255',
            'album_id' => 'required'
        ];
        $validasiData = $request->validate($aturan);
        $validasiData['user_id'] = Auth()->user()->id;
        if ($request->publish) {
            $validasiData['publish'] = true;
        } else {
            $validasiData['publish'] = false;
        }
        if ($request->file('photo')) {
            Storage::delete($request->photolama);
            $validasiData['photo'] = $request->file('photo')->store('photo-gallery');
        }
        Photo::where('id', $photo->id)->update($validasiData);
        return redirect()->route('photos.index')->with('berhasil', 'Photo berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        if ($photo->photo) {
        }
    }
    public function download(Photo $photo)
    {
        return Storage::download($photo->photo);
    }
}
