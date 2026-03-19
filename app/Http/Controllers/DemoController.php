<?php

namespace App\Http\Controllers;
use App\Models\Demos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Validamos que el archivo sea un archivo y que tenga la extensión .dem y que su peso máximo sea de 500MB.
        $request->validate([
            'file' => 'required|file|mimes:dem|max:512000', 
        ]);

        // Guardamos el archivo en la carpeta storage/app/demos.
        if($request->file('file')->isValid()) {
            /**
             * Vamos a recoger los datos para insertar el archivo en la base de datos. 
             * Tabla demos tiene los campos: id, usuario_id, nombre_archivo,nombre_original, ruta, estado, fecha_subida,fecha_creacion.
             * 
             * Teniendo en cuenta estos datos vamos a recoger el nombre del archivo, la ruta del archivo, el estado del archivo (pendiente de análisis), 
             * la fecha de subida y la fecha de creación.
             */

            // name del input file del formulario.
            $file = $request->file('file');
            // Generamos un nombre único para el archivo, utilizando el nombre de usuario y el nombre original del archivo. (nombre_archivo).
            $nombre_archivo = Auth::user()->nombre . '_' .  $file->getClientOriginalName();
            $path = $file->storeAs('demos', $nombre_archivo); // Guardamos el archivo en la carpeta storage/app/demos.
            $usuario_id = Auth::id(); // Obtenemos el id del usuario que ha subido el archivo.
            $ruta = 'demos/' . $nombre_archivo; // Ruta del archivo guardado.

            /**
             * Guardamos la información del archivo en la base de datos, utilizando el modelo Demos y el método create 
             * para insertar un nuevo registro en la tabla demos.
             */
            Demos::create([
                'usuario_id' => $usuario_id,
                'nombre_archivo' => $nombre_archivo,
                'nombre_original' => $file->getClientOriginalName(),
                'ruta' => 'demos/' . $nombre_archivo,
                'estado' => 'pendiente de análisis',
                'fecha_subida' => now(),
                'fecha_creacion' => now(),
            ]);

            return redirect()->route('dashboard')->with('success', 'Archivo subido correctamente.');
            
        } else {
            return redirect()->route('dashboard')->with('error', 'Archivo no válido.');
        }
    }
}
