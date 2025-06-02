<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller {
    public function showGameImage($filename) {
        $path = 'games/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            Log::warning('Image not found', [
                'path_checked' => $path,
                'exists' => Storage::disk('public')->exists($path),
                'files' => Storage::disk('public')->files('games')
            ]);
            return response()->json([
                'error' => 'File not found.',
                'path_checked' => $path,
                'exists' => Storage::disk('public')->exists($path),
                'files' => Storage::disk('public')->files('games')
            ], 404);
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);

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
