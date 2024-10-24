<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Secretaries;
use App\Livewire\CategoriesOcurrences;
use App\Livewire\Buildings;
use App\Livewire\Ocurrences;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('ocurrences', Ocurrences::class)->name('ocurrences');

Route::get('secretaries', Secretaries::class)->name('secretaries');

Route::get('categoriesOcurrences', CategoriesOcurrences::class)->name('categoriesOcurrences');

Route::get('buildings', Buildings::class)->name('buildings');

// Route::get('ocurrences', Buildings::class)->name('buildings');

require __DIR__.'/auth.php';
