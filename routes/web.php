<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('Home.home');
    })->name('home');

    Route::get('/create', function() {
        return view('Albums.create-album');
    })->name('create');

    Route::get('/edit', function() {
        return view('Albums.edit-album');
    })->name('edit');
    //create album
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    //get all albums
    Route::get('/', [AlbumController::class, 'index'])->name('albums.index');
    //edit album
    Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');

    //delete album
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    Route::get('/albums/{album}/delete-all', [AlbumController::class, 'deleteAll'])->name('albums.delete.all');
    Route::post('/albums/{album}/move', [AlbumController::class, 'movePictures'])->name('albums.move-pictures');
});
