<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class cDepartamento extends Controller{

    // Nos traemos todos los departamentos de la base de datos.
    public function index()
    {
        $departamentos = Departamento::all(); // Trae todos los departamentos
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Función para mostrar los datos de un departamento.
     * @param String $id recibe el código de departamento como parametro
     */
    public function mostrarDepartamento($codDepartamento){
        $departamento = Departamento::findOrFail($codDepartamento);
        return view('mostrarDepartamento', compact('departamento'));
    }
}
