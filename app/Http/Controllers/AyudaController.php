<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    /**
     * Devuelve la vista ayuda y se la muestra al usuario.
     */
    public function index()
    {
        // Devuelve la vista ayuda con todos los archivos y manuales.
        return view('ayuda');
    }
}
