<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        try {
            return response()->json(User::all());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch users.'], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create user.'], 500);
        }
    }

    public function show($id) {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user.'], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:6',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $user->update($validated);

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user.'], 500);
        }
    }

    public function destroy($id) {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }
}
