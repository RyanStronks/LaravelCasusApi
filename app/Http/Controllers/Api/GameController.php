<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller {
    public function index() {
        try {
            return response()->json(Game::all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch games.'], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image_path' => 'nullable|string|max:255',
            ]);

            $game = Game::create($validated);

            return response()->json($game, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create game.'], 500);
        }
    }

    public function show($id) {
        try {
            $game = Game::find($id);
            if (!$game) {
                return response()->json(['message' => 'Game not found'], 404);
            }

            return response()->json($game);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch game.'], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update game.'], 500);
        }
    }

    public function destroy($id) {
        try {
            $game = Game::find($id);
            if (!$game) {
                return response()->json(['message' => 'Game not found'], 404);
            }

            $game->delete();

            return response()->json(['message' => 'Game deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete game.'], 500);
        }
    }
}
