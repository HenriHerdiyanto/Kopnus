<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobNewsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [AuthController::class, 'getAllUsers']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);

    // Employer
    Route::get('/jobs/my', [JobNewsController::class, 'myJobs']);
    Route::post('/jobs', [JobNewsController::class, 'store']);
    Route::get('/jobs', [JobNewsController::class, 'index']);
    Route::get('/jobs/{id}', [JobNewsController::class, 'show']);
    Route::put('/jobs/{id}', [JobNewsController::class, 'update']);
    Route::delete('/jobs/{id}', [JobNewsController::class, 'destroy']);
    // Employer melihat pelamar
    Route::get('/jobs/{jobId}/applicants', [ApplicationController::class, 'getApplicants']);
    // Employer update status
    Route::patch('/applications/{applicationId}/status', [ApplicationController::class, 'updateStatus']);

    // freelance
    Route::post('/jobs/{id}/apply', [ApplicationController::class, 'apply']);
});
