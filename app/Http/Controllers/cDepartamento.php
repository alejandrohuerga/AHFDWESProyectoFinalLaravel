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

}
