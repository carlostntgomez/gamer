<?php

use Illuminate\Support\Facades\Route;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('pages.home.index');
});

Route::group(['middleware' => 'web'], function () {
    Route::post('admin/login', [\Filament\Http\Livewire\Auth\Login::class, 'authenticate'])->name('filament.admin.auth.login.post');
});
