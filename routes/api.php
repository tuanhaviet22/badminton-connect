<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CourtBookingController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Branches
Route::get('/branches', [BranchController::class, 'index']);
Route::get('/branches/{branch}', [BranchController::class, 'show']);

// Courts
Route::get('/courts', [CourtController::class, 'index']);
Route::get('/courts/{court}', [CourtController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/user', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Users
    Route::apiResource('/users', UserController::class);

    // Branches
    Route::post('/branches', [BranchController::class, 'store']);
    Route::put('/branches/{branch}', [BranchController::class, 'update']);
    Route::delete('/branches/{branch}', [BranchController::class, 'destroy']);

    // Courts
    Route::post('/courts', [CourtController::class, 'store']);
    Route::put('/courts/{court}', [CourtController::class, 'update']);
    Route::delete('/courts/{court}', [CourtController::class, 'destroy']);

    // Bookings
    Route::apiResource('/bookings', CourtBookingController::class);
    Route::get('/branches/{branch}/bookings', [CourtBookingController::class, 'byBranch']);
    Route::get('/courts/{court}/bookings', [CourtBookingController::class, 'byCourt']);
    Route::get('/my-bookings', [CourtBookingController::class, 'myBookings']);
});