<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
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
            'user' =>  User::find($userid),
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
        $validated = $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255',
            'album_id' => 'nullable|exists:albums,id',
            'body' => 'nullable|string',
            'publish' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            if (file_exists(public_path($photo->photo))) {
                unlink(public_path($photo->photo));
            }
            $newPhoto = time() . '.' . $request->photo->extension();
            $upload = $request->photo->move(public_path('photo'), $newPhoto);
            $filePath = 'photo/' . $newPhoto;
            $validated['photo'] = $filePath;
        } else {
            $validated['photo'] = $photo->photo;
        }
        $validated['publish'] = $request->has('publish') ? true : false;
        $validated['user_id'] = auth()->id();

        $photo->update($validated);

        return redirect()->route('photos.index')->with('berhasil', 'Photo berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        if (file_exists(public_path($photo->photo))) {
            unlink(public_path($photo->photo));
        }
        $photo->delete();

        return redirect()->route('photos.index')->with('berhasil', 'Photo berhasil dihapus');
    }
    public function download(Photo $photo)
    {
        // Pastikan file ada
        if (!file_exists(public_path($photo->photo))) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = public_path($photo->photo);
        $fileName = $photo->name . '.' . pathinfo($photo->photo, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }
}
