<?php
// routes/api.php
use App\Http\Controllers\Api\PartidoController;
use Illuminate\Support\Facades\Route;

// Ruta pública para obtener todos los partidos subidos por el admin.
Route::get('/partidos', [PartidoController::class, 'index']);

// Ruta para obtener el JSON de un partido específico
Route::get('/partidos/{id}', [PartidoController::class, 'show']);