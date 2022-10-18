<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')->group(function () {
    Route::post('login', [LoginController::class, 'login'])
        ->name('login')
        ->middleware('guest:sanctum');
});
