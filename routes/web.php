<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanAhorroController;
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
});
 
Route::middleware('auth')->group(function () {
    Route::get('/salario', function () {
        return view('salario');
    })->name('salario');
 
    Route::get('/ahorro',              [PlanAhorroController::class, 'index'])->name('ahorro');
    Route::post('/ahorro',             [PlanAhorroController::class, 'store'])->name('ahorro.store');
    Route::patch('/ahorro/{id}',       [PlanAhorroController::class, 'update'])->name('ahorro.update');
    Route::delete('/ahorro/{id}',      [PlanAhorroController::class, 'destroy'])->name('ahorro.destroy');
 
    Route::get('/gastos', function () {
        return view('gastos');
    })->name('gastos');
});
 
require __DIR__.'/auth.php';