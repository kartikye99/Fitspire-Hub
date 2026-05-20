<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WaterLogController;
use App\Http\Controllers\FitnessIdeaController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Workouts
    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');

    // Water Logs
    Route::post('/water-logs', [WaterLogController::class, 'store'])->name('water-logs.store');

    // Fitness & Sports Ideas
    Route::get('/ideas', [FitnessIdeaController::class, 'index'])->name('ideas.index');
    Route::post('/ideas/{idea}/save', [FitnessIdeaController::class, 'save'])->name('ideas.save');
    Route::post('/ideas/{idea}/unsave', [FitnessIdeaController::class, 'unsave'])->name('ideas.unsave');

    // Calculators
    Route::get('/calculators', function () {
        return view('calculators');
    })->name('calculators');
});
