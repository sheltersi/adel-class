<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware('placement.required')
        ->name('dashboard');

    Route::view('placement-test', 'placement-test')
        ->middleware('placement.completed')
        ->name('placement-test');
});

require __DIR__.'/settings.php';
