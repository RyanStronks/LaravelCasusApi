<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::get('/games/{id}', [GameController::class, 'show']);
    Route::put('/games/{id}', [GameController::class, 'update']);
    Route::delete('/games/{id}', [GameController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/verification', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/debug/storage-files', function () {
    return response()->json([
        'files' => \Illuminate\Support\Facades\Storage::files('public/games')
    ]);
});

Route::get('/debug/os-files', function () {
    return response()->json([
        'scandir' => scandir(storage_path('app/public/games')),
        'realpath' => realpath(storage_path('app/public/games')),
        'is_dir' => is_dir(storage_path('app/public/games')),
        'can_read' => is_readable(storage_path('app/public/games')),
    ]);
});

Route::middleware('auth:sanctum')->post('/upload-image', [ImageController::class, 'uploadImage']);


Route::get('/storage/games/{filename}', [ImageController::class, 'showGameImage']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
