<?php

namespace App\Http\Controllers;
use App\Models\Demos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
/**
 * Controlador del archivo .dem que se cargue en la aplicación web.
 * Este controlador se encarga de recibir el archivo .dem que se cargue en la aplicación web.
 * 
 * @author Alejandro De la Huerga
 * @since 18/03/2026
 * @version 1.0.0
 */

class DemoController extends Controller
{
    /**
     * Función para guardar el archivo .dem que se cargue en la aplicación web.
     * Validamos la subida del archivo .dem que tenga la extensión .dem y que su peso máximo sea de 500MB, y si el archivo es válido, 
     * lo guardamos en la carpeta storage/app/demos, y guardamos la información del archivo en la base de datos, 
     * y redirigimos a la ruta dashboard con un mensaje de éxito.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function guardarArchivo(Request $request)
    {
        // Verificamos que sea un archivo.
        $request -> validate([
            'file' => 'required|file|max:512000',
        ]);

        try{

            // 1. Guardamos con nombre único y extensión .dem
            $filename = \Illuminate\Support\Str::random(40) . '.dem';
            $path = $request->file('file')->storeAs('demos', $filename);
            $fullPath = Storage::path($path);
            $fullPathFixed = str_replace('\\', '/', $fullPath);

            // 2. Ejecutamos el parser (apuntando a .cjs)
            $result = Process::path(storage_path('scripts/demoparser'))->timeout(120)->run("node parse.cjs " . escapeshellarg($fullPathFixed));

            // 3. ¡BORRAMOS EL ARCHIVO .DEM! Ya no lo necesitamos, tenemos los datos en $result
            // Así liberamos espacio.
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            // Devolvemos mensaje en caso de error en el parseo.
            if (!$result->successful()) {
                return back()->with('error', "Error en el parseo técnico.");
            }

            // 4. Convertimos el JSON string en un Array de PHP
            $stats = json_decode($result->output(), true);

            if (empty($stats)) {
                return back()->with('error', 'La demo no contenía datos válidos.');
            }

            // 5. Enviamos SOLO el array a la vista
            return back()->with('success', 'Análisis completado y archivo temporal eliminado.')->with('stats', $stats);
        }catch(\Exception $ex){
            return back()->with('error', 'Error crítico: ' . $ex->getMessage());
        }

        
    }
}

