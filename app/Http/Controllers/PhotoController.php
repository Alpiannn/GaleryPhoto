<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userid = Auth()->user()->id;

        return view('photos.index', [
            'album' => Album::where('user_id', $userid)->latest()->get(),
            'photo' => Photo::where('user_id', $userid)
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
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
