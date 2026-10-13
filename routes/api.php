<?php

use App\Http\Controllers\Api\AuthTokenController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::post(
    '/login',
    [AuthTokenController::class, 'login']
)->name('api.login');


/*
|--------------------------------------------------------------------------
| Protected Sanctum API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::get(
            '/user',
            [AuthTokenController::class, 'user']
        )->name('api.user');


        Route::post(
            '/logout',
            [AuthTokenController::class, 'logout']
        )->name('api.logout');

    });







