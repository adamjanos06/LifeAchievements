<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompletedAchievementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeUserController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\UserController;
use App\Models\User;

// ----------------------
// Public Routes
// ----------------------
Route::get('/avatar/{filename}', function ($filename) {

    $path = storage_path('app/public/pfp/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/{achievement}', [AchievementController::class, 'show']);

Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/badges/{badge}', [BadgeController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/leaderboard', function () {
    return User::orderByDesc('xp')
        ->select('id', 'name', 'xp', 'image')
        ->take(50)
        ->get();
});


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

    // --- Friends stuff
    Route::get('/friends', [FriendController::class, 'index']);
    // the same endpoint now returns both incoming and sent pending requests
    Route::get('/friend-requests', [FriendController::class, 'incoming']);
    Route::post('/friends', [FriendController::class, 'send']);
    Route::post('/friend-requests/{friendRequest}/accept', [FriendController::class, 'accept']);
    // allow cancelling an outgoing request
    Route::delete('/friend-requests/{friendRequest}', [FriendController::class, 'cancel']);

    // --- Goals (user ↔ achievement) ---
    Route::get('/goals', [GoalsController::class, 'index']);
    Route::post('/goals/{achievement}', [GoalsController::class, 'store']);
    Route::delete('/goals/{achievement}', [GoalsController::class, 'destroy']);

    // --- Earned Badges (user ↔ badge) ---
    Route::get('/my-badges', [BadgeUserController::class, 'index']);
    Route::post('/badges/{badge}/earn', [BadgeUserController::class, 'store']);
    Route::post('/badges/dark-side', [BadgeController::class, 'darkSide']);
    
    // get other user's profile
    Route::get('/users/{user}', [UserController::class, 'show']);

    // ----------------------
    // Admin Routes
    // ----------------------
    Route::middleware('is_admin')->prefix('/admin')->group(function () {
        // Table Management (phpMyAdmin-like)
        Route::get('/tables', [AdminController::class, 'getTables']);
        Route::get('/tables/{table}/structure', [AdminController::class, 'getTableStructure']);
        Route::get('/tables/{table}/records', [AdminController::class, 'getTableRecords']);
        Route::get('/tables/{table}/records/{id}', [AdminController::class, 'getRecord']);
        Route::post('/tables/{table}/records', [AdminController::class, 'createRecord']);
        Route::put('/tables/{table}/records/{id}', [AdminController::class, 'updateRecord']);
        Route::delete('/tables/{table}/records/{id}', [AdminController::class, 'deleteRecord']);
    });
});