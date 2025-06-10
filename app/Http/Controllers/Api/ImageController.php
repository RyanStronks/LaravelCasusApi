<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller {
    public function showGameImage($filename) {
        $path = 'games/' . $filename;

        try {
            $file = Storage::disk('public')->get($path);
            $type = Storage::disk('public')->mimeType($path);
            return response($file, 200)->header('Content-Type', $type);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function uploadImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:10000',
        ]);

        try {
            $path = $request->file('image')->store('games', 'public');
            return response()->json(['path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image upload failed.'], 500);
        }
    }
}
