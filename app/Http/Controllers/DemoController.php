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
        // 1. Guardamos el archivo
        $path = $request->file('file')->store('demos');

        // 2. IMPORTANTE: Usamos storage_path con 'app/private/' 
        // Laravel lo guarda en private por defecto ahora
        $fullPath = storage_path('app/private/' . $path);

        // 3. Normalizamos las barras para que Rust (el parser) no de 'os error 3'
        $fullPathFixed = str_replace('\\', '/', $fullPath);

        // 4. Ejecutamos el script
        $result = \Illuminate\Support\Facades\Process::path(storage_path('scripts/demoparser'))
            ->run("node parse.cjs \"$fullPathFixed\"");

        if ($result->successful()) {
            $stats = json_decode($result->output(), true);
            return back()->with('stats', $stats);
        }

        // Si falla, esto te dirá la ruta exacta que intentó leer para que verifiques
        return back()->with('error', "Error: " . $result->errorOutput() . " | Ruta intentada: " . $fullPathFixed);

        // --- AÑADE ESTO PARA DEPURAR ---
        if (!$result->successful()) {
            dd("Error de Node:", $result->errorOutput());
        }

        $output = $result->output();
        $stats = json_decode($output, true);

        // Si esto sale en pantalla al subir la demo, sabremos que el JSON llegó bien
        // Si sale null o vacío, el problema está en el parse.js
        // dd($stats); 
        // -------------------------------

        if (!empty($stats)) {
            return back()->with('success', '¡Analizada!')
                        ->with('stats', $stats); // Asegúrate de que el nombre sea 'stats'
        }

        return back()->with('error', 'El parser no devolvió datos. Salida: ' . $output);
    }
}

