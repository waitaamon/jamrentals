<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('auth.login'));

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

require __DIR__ . '/auth.php';
