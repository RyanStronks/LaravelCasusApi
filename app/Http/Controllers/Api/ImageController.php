<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller {
    public function showGameImage($filename) {
        $path = 'public/games/' . $filename;

        if (!Storage::exists($path)) {
            Log::warning('Image not found', [
                'path_checked' => $path,
                'exists' => Storage::exists($path),
                'files' => Storage::files('public/games')
            ]);
            return response()->json([
                'error' => 'File not found.',
                'path_checked' => $path,
                'exists' => Storage::exists($path),
                'files' => Storage::files('public/games')
            ], 404);
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    public function uploadImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:10000',
        ]);

        $path = $request->file('image')->store('games', 'public');

        return response()->json(['path' => $path]);
    }
}
