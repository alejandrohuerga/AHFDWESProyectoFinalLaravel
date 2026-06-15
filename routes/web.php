
<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AyudaController;
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

Route::get('/analisis', [App\Http\Controllers\AnalisisController::class, 'index'])->middleware(['auth', 'verified'])->name('analisis'); 
Route::get('/jugadores', [JugadoresController::class, 'consumirJSONjugadores']) ->middleware(['auth', 'verified']) ->name('jugadores');
Route::get('/jugadores/{id}', [JugadoresController::class, 'show'])->name('jugadores.show');

Route::get('/analisis/{id}', [App\Http\Controllers\AnalisisController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('analisis.show');

/**
 * Ruta para guardar el archivo .dem 
 * El post significa que esta ruta solo se puede acceder mediante una solicitud POST, y se le asigna el nombre demo.guardar 
 * para poder acceder a ella desde otras partes de la aplicación.
 * 
 * Llama al controlador DemoController y a la función guardarArchivo, que se encarga de guardar el archivo .dem que se cargue en la aplicación web.
 */

Route::post('/demo/guardar', [DemoController::class, 'guardarArchivo'])->name('demo.guardar')->middleware(['auth', 'verified']); // Solo para usuarios autenticados y verificados, y se le asigna el nombre demo.guardar para poder acceder a ella desde otras partes de la aplicación.

Route::get('/demo/ejemplo', function () {
    $path = storage_path('app/private/demos/mi-demo.dem');
    if (file_exists($path)) {
        return response()->download($path, 'demo-ejemplo.dem');
    }
    abort(404);
})->middleware(['auth', 'verified'])->name('demo.ejemplo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';

/**
 * Ruta para redirigir desde el nav a la página de ayuda.
 * En la página de ayuda se encuentra el Manual de Uso del Usuario.
 * 
 * Llama al controlador AyudaController al método index que carga la vista.
 */

Route::get('/ayuda',[App\Http\Controllers\AyudaController::class, 'index']) ->name('ayuda');

/**
 * Esta ruta nos va a permitir la descarga de los archivos de la 
 * vista ayuda.
 * 
 * Nos permite verificar y contar el número de veces que se descargan.
 */
use Illuminate\Support\Facades\Storage;

Route::get('/descargar/{archivo}', function ($archivo) {
    // Verificamos si el archivo existe en la carpeta storage/app/public/documentos
    if (Storage::disk('public')->exists("doc/{$archivo}")) {
        return Storage::disk('public')->download("doc/{$archivo}");
    }
    abort(404);
})->name('doc.descargar');

/**
 * 
 * 
 */

Route::get('/demo-xl', [App\Http\Controllers\DemoXLController::class, 'index'])->middleware(['auth', 'verified'])->name('demo-xl');
Route::post('/demo-xl/chunk', [App\Http\Controllers\DemoXLController::class, 'recibirChunk'])->middleware(['auth', 'verified'])->name('demo-xl.chunk');
Route::post('/demo-xl/ensamblar', [App\Http\Controllers\DemoXLController::class, 'ensamblarChunks'])->middleware(['auth', 'verified'])->name('demo-xl.ensamblar');