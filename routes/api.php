<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\API\Auth\PermissionsController;
use App\Http\Controllers\API\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')->group(function () {
    Route::post('login', [LoginController::class, 'login'])
        ->name('login')
        ->middleware('guest:sanctum');

    Route::post('register', [RegisterController::class, 'register'])
        ->middleware('guest:sanctum')
        ->name('register');
});

Route::name('api.v1.')->middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'permissions' => PermissionsController::class,
    ]);
});
