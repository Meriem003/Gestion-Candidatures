<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfilControllers;

Route::get('/user', function (Request $request) {return $request->user();});
Route::post('register', [AuthControllers::class, 'register']);
Route::post('login', [AuthControllers::class, 'login']);
Route::post('logout', [AuthControllers::class, 'logout'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::apiResource('offers', OfferController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::apiResource('competences', CompetenceController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::apiResource('applications', ApplicationController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::get('showResume/{id}', [ApplicationController::class, 'showResume'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::get('profile', [ProfilControllers::class, 'show'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::put('profile', [ProfilControllers::class, 'update'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur',]);
