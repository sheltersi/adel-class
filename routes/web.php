<?php

use App\Livewire\Student\Dashboard;
use App\Livewire\Student\PlacementTest;
use App\Livewire\Student\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');

    Route::livewire('profile', Profile::class)->name('profile');

    Route::livewire('placement-test', PlacementTest::class)
        ->middleware('placement.completed')
        ->name('placement-test');
});

require __DIR__.'/settings.php';
