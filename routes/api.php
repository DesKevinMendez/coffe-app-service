<?php

use App\Http\Controllers\Api\Auth\{
    LoginController,
    PermissionsController,
    RegisterController
};
use App\Http\Controllers\API\Commerce\CommerceController;
use App\Http\Controllers\API\Company\CompanyController;
use App\Http\Controllers\API\Orders\OrderController;
use App\Http\Controllers\API\Roles\{
    RolesController,
    RolesWithPermissionsController
};
use App\Http\Controllers\API\Product\ProductController;
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
        'products' => ProductController::class,
        'companies' => CompanyController::class,
        'commerces' => CommerceController::class,
    ]);
    Route::apiResource('commerces.order', OrderController::class)->except('destroy');
    Route::get('roles/{role}/permissions', RolesWithPermissionsController::class)->name('roles.permissions');

    Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
});
