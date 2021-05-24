<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('auth.login'));

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('buildings', [\App\Http\Controllers\BuildingController::class, 'index'])->name('building.index');
    Route::get('buildings/{id}', [\App\Http\Controllers\BuildingController::class, 'show'])->name('building.show');

    Route::get('houses/{id}', [\App\Http\Controllers\HouseController::class, 'show'])->name('house.show');

    Route::get('tenants/{id}', [\App\Http\Controllers\TenantController::class, 'show'])->name('tenant.show');

    Route::get('payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
    Route::get('payments/{id}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

    Route::get('reports', \App\Http\Controllers\ReportController::class)->name('report.index');

    //Api

    Route::apiResource('api/buildings', \App\Http\Controllers\Api\BuildingsController::class);
    Route::apiResource('api/houses', \App\Http\Controllers\Api\HousesController::class);
    Route::apiResource('api/tenants', \App\Http\Controllers\Api\TenantsController::class);

    Route::post('api/house-mark-vacant', [App\Http\Controllers\Api\HouseActionsController::class, 'markVacant']);


    Route::get('api/payment-prerequisites', [App\Http\Controllers\Api\PaymentsController::class, 'prerequisites']);
    Route::post('api/payment-export-excel', [App\Http\Controllers\Api\PaymentActionsController::class, 'exportExcel']);
    Route::post('api/reverse-payments', [App\Http\Controllers\Api\PaymentActionsController::class, 'reverse']);
    Route::get('api/print-payment-receipt/{id}', [App\Http\Controllers\Api\PaymentActionsController::class, 'printReceipt']);
    Route::apiResource('api/payments', \App\Http\Controllers\Api\PaymentsController::class);

    Route::post('api/payments-reverse', [\App\Http\Controllers\Api\PaymentActionsController::class, 'reverse']);
    Route::post('api/payments-export-excel', [\App\Http\Controllers\Api\PaymentActionsController::class, 'exportExcel']);

    Route::get('api/report', \App\Http\Controllers\Api\ReportsController::class);
    Route::post('api/unpaid-invoices-export-excel', [App\Http\Controllers\Api\ReportsController::class, 'exportUnpaidInvoiceToExcel']);

});

require __DIR__ . '/auth.php';
