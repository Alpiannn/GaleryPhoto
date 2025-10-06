<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $userid = Auth()->user()->id;
        $photoid = $request->photo_id;

        $data = [
            'user_id' => $userid,
            'photo_id' => $photoid
        ];

        Like::create($data);
        return back();
    }

    public function unlike(Like $like)
    {
        Like::destroy('id', $like->id);

        return back();
    }
}
