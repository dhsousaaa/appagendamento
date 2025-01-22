<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfissionalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('theme/theme');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/profissionais', [ProfissionalController::class, 'index'])->name('profissionais.index');
Route::post('/profissionais', [ProfissionalController::class, 'store'])->name('profissionais.store');
Route::put('/profissionais/{id}', [ProfissionalController::class, 'update'])->name('profissionais.update');
Route::get('/profissionais/{id}/edit', [ProfissionalController::class, 'edit'])->name('profissionais.edit');
Route::delete('/profissionais/{id}', [ProfissionalController::class, 'destroy'])->name('profissionais.destroy');

require __DIR__.'/auth.php';
