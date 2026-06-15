<?php

namespace App\Http\Controllers;

use App\Models\Demos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controlador del archivo .dem que se cargue en la aplicación web.
 * @author Alejandro De la Huerga
 * @since 18/03/2026
 * @version 1.2.0
 */

class DemoController extends Controller
{
    public function guardarArchivo(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:900000',
        ]);

        try {
            // 1. Guardamos con nombre único y extensión .dem
            $nombreArchivo = Str::random(40) . '.dem';
            $rutaRelativa = $request->file('file')->storeAs('demos', $nombreArchivo);
            $rutaAbsoluta = str_replace('\\', '/', Storage::path($rutaRelativa));

            // 2. Ejecutamos el parser de estadísticas
            $resultado = Process::path(storage_path('scripts/demoparser'))
                ->timeout(120)
                ->run("node parse.cjs " . escapeshellarg($rutaAbsoluta));

            if (!$resultado->successful()) {
                if (Storage::exists($rutaRelativa)) {
                    Storage::delete($rutaRelativa);
                }
                $errorTecnico = $resultado->errorOutput();
                return back()->with('error', "Error en el análisis técnico: " . ($errorTecnico ?: "Tiempo de espera agotado o salida vacía."));
            }

            // 3. Ejecutamos el parser del mapa (antes de borrar el .dem)
            $resultadoMapa = Process::path(storage_path('scripts/demoparser'))
                ->timeout(30)
                ->run("node metadate.cjs " . escapeshellarg($rutaAbsoluta));

            $mapName = 'Desconocido';
            if ($resultadoMapa->successful()) {
                $mapaJson = json_decode($resultadoMapa->output(), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning('JSON del parser de mapa inválido: ' . json_last_error_msg());
                } else {
                    $raw = $mapaJson['map'] ?? '';
                    $mapName = !empty($raw) ? ucfirst(preg_replace('/^[a-z]+_/', '', $raw)) : 'Desconocido';
                }
            } else {
                Log::warning('Parser de mapa falló: ' . $resultadoMapa->errorOutput());
            }

            // 4. Convertimos las estadísticas
            $estadisticas = json_decode($resultado->output(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON de estadísticas inválido: ' . json_last_error_msg(), [
                    'raw_output_preview' => substr($resultado->output(), 0, 500),
                ]);
                return back()->with('error', 'El parser devolvió datos inválidos.');
            }

            // 5. Borramos el .dem ahora que ya tenemos todo lo que necesitamos
            if (Storage::exists($rutaRelativa)) {
                Storage::delete($rutaRelativa);
            }

            if (empty($estadisticas)) {
                return back()->with('error', 'La demo no contenía datos válidos o no se detectó el final de la partida.');
            }

            // 6. Guardamos en base de datos
            $analisis = new \App\Models\Analisis();
            $analisis->user_id = Auth::id();
            $analisis->map_name = $mapName; // ← ahora dinámico
            $analisis->stats = $estadisticas;
            $analisis->save();

            return back()->with('success', 'Análisis completado y archivo temporal eliminado.')
                         ->with('stats', $estadisticas);

        } catch (\Exception $ex) {
            Log::error('Error crítico en DemoController@guardarArchivo: ' . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString(),
            ]);
            if (isset($rutaRelativa) && Storage::exists($rutaRelativa)) {
                Storage::delete($rutaRelativa);
            }
            return back()->with('error', 'Error crítico en el servidor: ' . $ex->getMessage());
        }
    }


}