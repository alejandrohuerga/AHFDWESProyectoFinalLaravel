<?php

namespace App\Http\Controllers;

use App\Models\Demos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controlador del archivo .dem que se cargue en la aplicación web.
 * Este controlador se encarga de recibir el archivo .dem que se cargue en la aplicación web.
 * * @author Alejandro De la Huerga
 * @since 18/03/2026
 * @version 1.1.0
 */

class DemoController extends Controller
{
    /**
     * Función para guardar el archivo .dem que se cargue en la aplicación web.
     * Validamos la subida del archivo .dem que tenga la extensión .dem y que su peso máximo sea de 500MB, y si el archivo es válido, 
     * lo guardamos en la carpeta storage/app/demos, y guardamos la información del archivo en la base de datos, 
     * y redirigimos a la ruta dashboard con un mensaje de éxito.
     * * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function guardarArchivo(Request $request)
    {
        // Verificamos que sea un archivo y que no supere los 500MB.
        $request->validate([
            'file' => 'required|file|max:900000',
        ]);

        try {
            // 1. Guardamos con nombre único y extensión .dem para evitar colisiones.
            $nombreArchivo = Str::random(40) . '.dem';
            $rutaRelativa = $request->file('file')->storeAs('demos', $nombreArchivo);
            
            // Obtenemos la ruta absoluta y normalizamos los separadores para evitar errores en el parser.
            $rutaAbsoluta = str_replace('\\', '/', Storage::path($rutaRelativa));

            // 2. Ejecutamos el parser (apuntando a .cjs) con un tiempo de espera de 120 segundos.
            // Usamos escapeshellarg para proteger la ruta de caracteres especiales.
            $resultado = Process::path(storage_path('scripts/demoparser'))
                ->timeout(120)
                ->run("node parse.cjs " . escapeshellarg($rutaAbsoluta));

            // 3. Verificamos si el proceso de Node.js terminó correctamente.
            // Si falla, capturamos el error técnico para saber por qué se queda cargando.
            if (!$resultado->successful()) {
                // Si el parseo falla, eliminamos el archivo temporal para no llenar el disco.
                if (Storage::exists($rutaRelativa)) {
                    Storage::delete($rutaRelativa);
                }

                // Capturamos el error específico de la consola (stderr).
                $errorTecnico = $resultado->errorOutput();
                return back()->with('error', "Error en el análisis técnico: " . ($errorTecnico ?: "Tiempo de espera agotado o salida vacía."));
            }

            // 4. Convertimos el JSON string que escupe el script de Node en un Array de PHP.
            $estadisticas = json_decode($resultado->output(), true);

            // 5. ¡BORRAMOS EL ARCHIVO .DEM! Ya no lo necesitamos, tenemos los datos en la variable $estadisticas.
            // Así liberamos espacio de forma inmediata.
            if (Storage::exists($rutaRelativa)) {
                Storage::delete($rutaRelativa);
            }

            // Si el resultado está vacío, es que la demo no tiene eventos de fin de ronda válidos.
            if (empty($estadisticas)) {
                return back()->with('error', 'La demo no contenía datos válidos o no se detectó el final de la partida.');
            }

            // 6. Enviamos SOLO el array de estadísticas a la vista mediante la sesión.
            // Esto permite mostrar la información en el dashboard sin recargar toda la lógica.
            return back()->with('success', 'Análisis completado y archivo temporal eliminado.')
                         ->with('stats', $estadisticas);

        } catch (\Exception $ex) {
            // En caso de error crítico, intentamos limpiar el archivo si existe.
            if (isset($rutaRelativa) && Storage::exists($rutaRelativa)) {
                Storage::delete($rutaRelativa);
            }
            return back()->with('error', 'Error crítico en el servidor: ' . $ex->getMessage());
        }
    }
}

