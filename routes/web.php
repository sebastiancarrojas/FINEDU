<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/salario', function () {
        return view('salario');
    })->name('salario');

    Route::get('/ahorro', function () {
        return view('ahorro');
    })->name('ahorro');

    Route::get('/gastos', function () {
        return view('gastos');
    })->name('gastos');
});

require __DIR__.'/auth.php';