<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ImageController extends Controller {
    public function uploadImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:10000',
        ]);

        $path = $request->file('image')->store('games', 'public');

        return response()->json(['path' => $path]);
    }
}
