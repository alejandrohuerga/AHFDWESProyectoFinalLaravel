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

    public function guardar(Request $request)
    {
        // 1. Validar el archivo
        $request->validate([
            'file' => 'required|file|max:102400', // Máximo 100MB
        ]);

        try {
            // 2. Guardar archivo en storage/app/demos
            $path = $request->file('file')->store('demos');
            $fullPath = storage_path('app/' . $path);

            // 3. Ejecutar el script de Node.js
            $scriptPath = storage_path('scripts/parse.js');

            // Usamos el facade Process de Laravel para llamar a Node
            $result = Process::run("node $scriptPath $fullPath");

            if ($result->successful()) {
                $stats = json_decode($result->output(), true);

                // Borrar archivo después de procesar para no llenar el disco
                Storage::delete($path);

                return back()->with('success', '¡Demo analizada!')->with('stats', $stats);
            }

            return back()->with('error', 'Error al procesar la demo: ' . $result->errorOutput());
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}

