<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Demos;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para el análisis de los archivos .dem que se carguen en la aplicación web.
 * 
 * Su función sera mostrar los partidos subidos, los partidos analizados, y los partidos pendientes de análisis,
 * mostrar la información de cada partido, como el nombre del archivo, la fecha de subida, el estado del análisis, etc.
 * 
 * @author Alejandro De la Huerga
 * @since 16/03/2026
 * @version 1.0.0
 */

class AnalisisController extends Controller
{
    /**
     * seleccionarPartidosUsuario() permite seleccionar en la base de datos los partidos subidos por el usuario logueado.
     * 
     * Dicha información se mostrará en la vista analisis.blade.php, que es donde se encuentra el componente Livewire 
     * que hemos creado para mostrar los partidos subidos por el usuario logueado.
     * 
     * @return \Illuminate\View\View
     */
    
    public function seleccionarPartidosUsuario()
    {
        // Seleccionamos los partidos subidos por el usuario logueado.
        $partidosSubidosUsuario = Demos::where('usuario_id', Auth::id())->get();

        /** 
         * Devolvemos la vista analisis.blade.php con la información de los partidos subidos por el usuario logueado.
         * El compact es para pasar la variable $partidosSubidosUsuario a la vista analisis.blade.php, y poder mostrar 
         * la información de los partidos subidos por el usuario logueado.
         * 
         * Esto nos permite utilizar la variable $partidosSubidosUsuario en la vista analisis.blade.php, y mostrar la información.
         */
        return view('analisis', compact('partidosSubidosUsuario')); 
    }
}
