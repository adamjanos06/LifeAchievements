<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompletedAchievementController;
use App\Http\Controllers\AuthController;

// ----------------------
// Public Routes
// ----------------------

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/{achievement}', [AchievementController::class, 'show']);

Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/badges/{badge}', [BadgeController::class, 'show']);

// Completed achievements list by category or global
Route::get('/completed-achievements', [CompletedAchievementController::class, 'index']);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// ----------------------
// Protected Routes (admin/user actions)
// ----------------------

Route::middleware('auth:sanctum')->group(function () {

    // --- Categories ---
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // --- Achievements ---
    Route::post('/achievements', [AchievementController::class, 'store']);
    Route::put('/achievements/{achievement}', [AchievementController::class, 'update']);
    Route::delete('/achievements/{achievement}', [AchievementController::class, 'destroy']);

    // --- Badges ---
    Route::post('/badges', [BadgeController::class, 'store']);
    Route::put('/badges/{badge}', [BadgeController::class, 'update']);
    Route::delete('/badges/{badge}', [BadgeController::class, 'destroy']);

    // --- Completed Achievements ---
    Route::post('/completed-achievements', [CompletedAchievementController::class, 'store'])
    ->middleware('auth:sanctum');
    Route::get('/completed-achievements/user', [CompletedAchievementController::class, 'userCompleted']);
    Route::delete('/completed-achievements/{completedAchievement}', [CompletedAchievementController::class, 'destroy']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
