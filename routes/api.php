<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user/{userId}', [UserController::class, 'show'])->middleware('auth:api');
Route::put('/user/{userId}', [UserController::class, 'update'])->middleware('auth:api');
Route::delete('/user/{userId}', [UserController::class, 'delete'])->middleware('auth:api');
