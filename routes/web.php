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
    Route::put('/password', [ProfileController::class, 'update'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/gastos/{gasto}', [GastoController::class, 'update'])->name('gastos.update');

    Route::get('/salario', function () {
        return view('salario');
    })->name('salario');

    Route::get('/ahorro', [PlanAhorroController::class, 'index'])->name('ahorro');
    Route::post('/ahorro', [PlanAhorroController::class, 'store'])->name('ahorro.store');
    Route::delete('/ahorro/{id}', [PlanAhorroController::class, 'destroy'])->name('ahorro.destroy');

    Route::get('/gastos',            [GastoController::class, 'index'])->name('gastos');
    Route::post('/gastos',           [GastoController::class, 'store'])->name('gastos.store');
    Route::delete('/gastos/{gasto}', [GastoController::class, 'destroy'])->name('gastos.destroy');
});

require __DIR__.'/auth.php';