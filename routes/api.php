<?php

use App\Http\Controllers\Account\AvatarController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Assignment\GuardToWardController;
use App\Http\Controllers\Assignment\PrisonerToJailController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Spaces\JailController;
use App\Http\Controllers\Spaces\WardController;
use App\Http\Controllers\Users\DirectorController;
use App\Http\Controllers\Users\GuardController;
use App\Http\Controllers\Users\PrisonerController;
use Illuminate\Support\Facades\Route;

// Se hace uso de grupo de rutas
// https://laravel.com/docs/9.x/routing#route-groups
// https://laravel.com/docs/9.x/routing#route-group-prefixes

Route::prefix('v1')->group(function ()
{
    // Hacer uso del archivo auth.php
    require __DIR__ . '/auth.php';

    // Se hace uso de grupo de rutas y que pasen por el proceso de auth con sanctum
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        // Se hace uso de grupo de rutas
        Route::prefix('profile')->group(function ()
        {
            Route::controller(ProfileController::class)->group(function ()
            {
                Route::get('/', 'show')->name('profile');
                Route::post('/', 'store')->name('profile.store');
            });
            Route::post('/avatar', [AvatarController::class, 'store'])->name('profile.avatar');
        });


        Route::prefix("director")->group(function ()
        {
            Route::controller(DirectorController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });

        Route::prefix("guard")->group(function ()
        {
            Route::controller(GuardController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });

        Route::prefix("prisoner")->group(function ()
        {
            Route::controller(PrisonerController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });

        Route::prefix("prisoner")->group(function ()
        {
            Route::controller(PrisonerController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{user}', 'show');
                Route::post('/{user}/update', 'update');
                Route::get('/{user}/destroy', 'destroy');
            });
        });


        Route::prefix('ward')->group(function () {
            Route::controller(WardController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{ward}', 'show');
                Route::post('/{ward}/update', 'update');
                Route::get('/{ward}/destroy', 'destroy');
            });
        });


        Route::prefix('jail')->group(function () {
            Route::controller(JailController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{jail}', 'show');
                Route::post('/{jail}/update', 'update');
                Route::get('/{jail}/destroy', 'destroy');
            });
        });



        Route::prefix('assignment')->group(function () {
            Route::controller(GuardToWardController::class)->group(function () {
                Route::get('/guards-and-wards', 'index');
                Route::get('/guard-to-ward/{user}/{ward}', 'assign');
            });
            Route::controller(PrisonerToJailController::class)->group(function () {
                Route::get('/prisoners-and-jails', 'index');
                Route::get('/prisoner-to-jail/{user}/{jail}', 'assign');
            });
        });


        Route::prefix('report')->group(function ()
        {
            Route::controller(ReportController::class)->group(function ()
            {
                Route::get('/', 'index');
                Route::post('/create', 'store');
                Route::get('/{report}', 'show');
                Route::post('/{report}/update', 'update');
                Route::get('/{report}/destroy', 'destroy');
            });
        });



    });
});
