<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'photos' => Photo::where('publish', true)
                ->latest()
                ->filter(request(['cari', 'album', 'arsip']))
                ->paginate(12)
                ->withQueryString(),
        ]);
    }
}
