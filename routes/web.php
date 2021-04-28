<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('auth.login'));

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('buildings', [\App\Http\Controllers\BuildingController::class, 'index'])->name('building.index');
    Route::get('buildings/{id}', [\App\Http\Controllers\BuildingController::class, 'show'])->name('building.show');

    Route::get('houses/{id}', [\App\Http\Controllers\HouseController::class, 'show'])->name('house.show');

    Route::get('payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
    Route::get('payments/{id}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

    //Api
    Route::apiResource('api/buildings', \App\Http\Controllers\Api\BuildingsController::class);
    Route::apiResource('api/houses', \App\Http\Controllers\Api\HousesController::class);
    Route::apiResource('api/payments', \App\Http\Controllers\Api\PaymentsController::class);

    Route::post('api/payments-reverse', [\App\Http\Controllers\Api\PaymentActionsController::class, 'reverse']);
    Route::post('api/payments-export-excel', [\App\Http\Controllers\Api\PaymentActionsController::class, 'exportExcel']);

});

require __DIR__ . '/auth.php';
