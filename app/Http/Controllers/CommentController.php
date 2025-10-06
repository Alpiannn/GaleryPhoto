<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $validasiData = $request->validate([
            'body' => 'required|max:255',
            'photo_id' => 'required'
        ]);

        $validasiData['user_id'] = Auth()->user()->id;

        Comment::create($validasiData);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validasiData = $request->validate([
            'body' => 'required|max:255',
            'photo_id' => 'required'
        ]);

        $validasiData['user_id'] = Auth()->user()->id;

        Comment::where('id', $comment->id)->update($validasiData);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Comment::destroy('id', $comment->id);

        return back();
    }
}
