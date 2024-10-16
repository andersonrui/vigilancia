<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Secretaries;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('secretaries', Secretaries::class)->name('secretaries');

require __DIR__.'/auth.php';
