
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\cDepartamento;
use App\Models\Departamento; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    // Departamentos de la tabla _t02_Departamento
    $departamentos = Departamento::all(); 
    
    return view('dashboard', compact('departamentos')); 
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/departamentos', [cDepartamento::class, 'index'])->name('departamentos.index');
});

require __DIR__.'/auth.php';

