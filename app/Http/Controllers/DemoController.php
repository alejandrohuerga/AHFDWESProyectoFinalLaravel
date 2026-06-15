<?php

namespace App\Http\Controllers;

use App\Services\DemoParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function __construct(
        protected DemoParserService $parser
    ) {}

    public function guardarArchivo(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:900000',
        ]);

        $rutaRelativa = null;

        try {
            $nombreArchivo = Str::random(40) . '.dem';
            $rutaRelativa = $request->file('file')->storeAs('demos', $nombreArchivo);
            $rutaAbsoluta = str_replace('\\', '/', Storage::path($rutaRelativa));

            $estadisticas = $this->parser->parseStats($rutaAbsoluta);
            if ($estadisticas === null) {
                $this->parser->cleanupStorageFile($rutaRelativa);
                return back()->with('error', 'La demo no contenía datos válidos o no se detectó el final de la partida.');
            }

            $mapName = $this->parser->parseMapName($rutaAbsoluta);

            $this->parser->cleanupStorageFile($rutaRelativa);

            $this->parser->saveAnalisis(Auth::id(), $mapName, $estadisticas);

            return back()->with('success', 'Análisis completado y archivo temporal eliminado.')
                         ->with('stats', $estadisticas);

        } catch (\Exception $ex) {
            if ($rutaRelativa) {
                $this->parser->cleanupStorageFile($rutaRelativa);
            }
            return back()->with('error', 'Error crítico en el servidor: ' . $ex->getMessage());
        }
    }
}
