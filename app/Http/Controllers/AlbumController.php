<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function index() {
        // get all albums with their picture path
        $albums = Album::with('pictures')->get();
        // print_r($albums); 
        return view('Home.home', compact('albums'));
    }
    public function store(Request $request) {
        try {
            $request->validate([
                'album_name' => 'required',
                'path.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
    
            $album = new Album();
            $album->album_name = $request->album_name;
            $album->save();
    
                // Handle file uploads
        if ($request->hasFile('path')) {
            foreach ($request->file('path') as $picture) {
                // Store the new picture
                $picPath = $picture->store('public/pictures');
                $picName = uniqid().'_'.$picture->getClientOriginalName();
                $newPicture = new Picture();
                $newPicture->pic_name = $picName;
                $newPicture->path = $picPath;
                $newPicture->album_id = $album->id;
                $newPicture->save();
            }
        }
    
            return redirect()->route('albums.index')->with('success', 'Album created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('albums.store')->with('error', $e->getMessage());
        }
    }
    public function edit(Album $album) {
        
        return view('Albums.edit-album', compact('album'));
    }
    public function update(Request $request, Album $album) {
        $request->validate([
            'album_name' => 'string|max:255',
            'path.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $album->album_name = $request->album_name;
        $album->save();
        // Handle file uploads
        if ($request->hasFile('path')) {
            foreach ($request->file('path') as $picture) {
                $picPath = $picture->store('public/pictures');
                $picName = uniqid().'_'.$picture->getClientOriginalName();
                $newPicture = new Picture();
                $newPicture->pic_name = $picName;
                $newPicture->path = $picPath;
                $newPicture->album_id = $album->id;
                $newPicture->save();
            }    
        }
        //delete image
        if ($request->has('delete')) {
            $album->pictures()->whereIn('id', $request->input('delete'))->delete();
            $album->save();
        }
        return redirect()->route('albums.index')->with('success', 'Album updated successfully!');
    }
    //destroy 
    public function destroy(Album $album) {
        if ($album->pictures()->count() > 0) {
            return redirect()->route('albums.index')->with('error', 'Album cannot be deleted because it has pictures!');
        }
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully!');
    }

    public function deleteAll(Album $album) {
        $album->pictures()->delete();
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album and all its pictures deleted successfully!');
    }

    public function movePictures(Request $request, Album $album) {
        $request->validate([
            'target_album_id' => 'required|exists:albums,id',
        ]);

        $targetAlbumId = $request->input('target_album_id');

        foreach ($album->pictures as $picture) {
            $picture->album_id = $targetAlbumId;
            $picture->save();
        }

        $album->delete();

        return response()->json(['success' => true]);
    }
}