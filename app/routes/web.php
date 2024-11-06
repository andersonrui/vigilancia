<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Secretaries;
use App\Livewire\CategoriesOcurrences;
use App\Livewire\Buildings;
use App\Livewire\Ocurrences;
use App\Livewire\Map;
use App\Livewire\Roles;
use App\Livewire\Users;

Route::middleware(['auth'])->group( function(){
    Route::view('profile', 'profile')->name('profile');

    Route::get('/', Ocurrences::class)->middleware(['can:view_ocurrence'])->name('ocurrences');

    Route::get('secretaries', Secretaries::class)->middleware(['can:view_secretary'])->name('secretaries');

    Route::get('categoriesOcurrences', CategoriesOcurrences::class)->middleware(['can:view_ocurrence_category'])->name('categoriesOcurrences');

    Route::get('buildings', Buildings::class)->middleware(['can:view_building'])->name('buildings');

    Route::get('map', Map::class)->name('map');

    Route::get('roles', Roles::class)->middleware(['can:view_role'])->name('roles');

    Route::get('users', Users::class)->middleware(['can:view_user'])->name('users');
});

require __DIR__.'/auth.php';
