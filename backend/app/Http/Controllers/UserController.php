<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompletedAchievementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// ----------------------
// Public Routes
// ----------------------

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/{achievement}', [AchievementController::class, 'show']);

Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/badges/{badge}', [BadgeController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// get other user's profile
Route::get('/users/{user}', [UserController::class, 'show']);

// ----------------------
// Authenticated Routes
// ----------------------

Route::middleware('auth:sanctum')->group(function () {
    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);

    // profile and updating profile
    Route::get('/me', [UserController::class, 'me']);
    Route::put('/me', [UserController::class, 'update']);

    // --- Categories (admin) ---
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // --- Achievements (admin + catalog logic) ---
    Route::post('/achievements', [AchievementController::class, 'store']);
    Route::put('/achievements/{achievement}', [AchievementController::class, 'update']);
    Route::delete('/achievements/{achievement}', [AchievementController::class, 'destroy']);

    // --- Catalog: mark achievement as completed ---
    Route::post(
        '/achievements/{achievement}/complete',
        [CompletedAchievementController::class, 'store']
    );

    // --- My Achievements (only logged-in user) ---
    Route::get(
        '/my-achievements',
        [CompletedAchievementController::class, 'userCompleted']
    );
});