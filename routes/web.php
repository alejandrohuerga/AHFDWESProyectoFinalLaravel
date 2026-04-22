
<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Hacemos un redirect a la ruta dashboard, para que cuando accedamos a la raíz de la aplicación, 
 * nos redirija automáticamente a la ruta dashboard, 
 * que es donde se encuentra el componente Livewire que hemos creado.
 */

Route::redirect('/', 'dashboard');

/**
 * Esta ruta dashboard consiste en mostrar la vista dashboard.blade.php, que es donde se encuentra el componente Livewire que hemos creado,
 * y para acceder a esta ruta, es necesario estar autenticado y verificado, por
 * lo que se le asigna el middleware auth y verified, y se le asigna el nombre dashboard para poder acceder a ella desde otras partes de la aplicación.
 */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * La siguiente ruta es para el apartado del nav ANALISIS, que por ahora no hace nada, pero se le asigna el middleware auth y verified, 
 * y se le asigna el nombre analisis para poder acceder a ella desde otras partes de la aplicación.
 * 
 * Vamos a codificarla para que conozca la variable $partidosSubidosUsuario, que es la variable que 
 * contiene la información de los partidos subidos por el usuario logueado.
 * 
 * Solo para usuarios autenticados y verificados.
 */

Route::get('/analisis', [App\Http\Controllers\AnalisisController::class, 'seleccionarPartidosUsuario'])->middleware(['auth', 'verified'])->name('analisis'); 



/**
 * Ruta para guardar el archivo .dem 
 * El post significa que esta ruta solo se puede acceder mediante una solicitud POST, y se le asigna el nombre demo.guardar 
 * para poder acceder a ella desde otras partes de la aplicación.
 * 
 * Llama al controlador DemoController y a la función guardarArchivo, que se encarga de guardar el archivo .dem que se cargue en la aplicación web.
 */

Route::post('/demo/guardar', [DemoController::class, 'guardarArchivo'])->name('demo.guardar')->middleware(['auth', 'verified']); // Solo para usuarios autenticados y verificados, y se le asigna el nombre demo.guardar para poder acceder a ella desde otras partes de la aplicación.

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

