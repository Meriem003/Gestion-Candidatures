<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\offerController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateProfile']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/offers', [OfferController::class, 'index']); 
    Route::post('/offers', [OfferController::class, 'store']); 
    Route::post('/offers/{id}/apply', [OfferController::class, 'apply']); 
    Route::delete('/offers/{id}/detach', [OfferController::class, 'detach']);
    Route::put('/offers/{id}', [OfferController::class, 'update']);
    Route::delete('/offers/{id}', [OfferController::class, 'destroy']);
});
Route::get('/offers/search', [OfferController::class, 'search']);


