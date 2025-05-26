<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller {
    public function index() {
        return response()->json(Game::all());
    }

    public function showAll() {
        return response()->json(Game::all());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
        ]);
        $game = Game::create($validated);
        return response()->json($game, 201);
    }

    public function show($id) {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        return response()->json($game);
    }

    public function update(Request $request, $id) {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
        ]);
        $game->update($validated);
        return response()->json($game);
    }

    public function destroy($id) {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        $game->delete();
        return response()->json(['message' => 'Game deleted']);
    }
}
