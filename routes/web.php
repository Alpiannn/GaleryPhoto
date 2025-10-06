<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


Route::middleware('guest')->group(function () {
    Route::get('/daftar', [DaftarController::class, 'index'])->name('daftar.index');

    Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.store');

    Route::get('/login', [LoginController::class, 'index'])->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
});
Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('users', UserController::class);
    Route::resource('photos', PhotoController::class);
    Route::resource('/album', AlbumController::class);
    Route::get('/photos/download/{photo}', [PhotoController::class, 'download'])->name('photos.download');
    //like
    Route::post('/like', [LikeController::class, 'like'])->name('like');
    //unlike
    Route::delete('/unlike/{like}', [LikeController::class, 'unlike'])->name('unlike');
    Route::resource('/comments', CommentController::class);
});
//?
