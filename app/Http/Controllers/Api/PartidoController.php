<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analisis;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    public function index()
    {
        $partidos = Analisis::select('id', 'map_name', 'created_at')
            ->latest()
            ->get();

        return response()->json($partidos);
    }

    public function show(int $id)
    {
        $partido = Analisis::find($id);

        if (!$partido) {
            return response()->json(['error' => 'Partido no encontrado.'], 404);
        }

        return response()->json($partido);
    }
}
