<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Services\DemoParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    public function __construct(
        protected DemoParserService $parser
    ) {}

    /**
     * Muestra la vista principal con los análisis del usuario.
     */
    public function index()
    {
        $analisisSubidos = Analisis::where('user_id', Auth::id())->latest()->get();
        return view('analisis', compact('analisisSubidos'));
    }

    /**
     * Recibe el archivo .dem, lo parsea con Node y guarda el JSON en la DB.
     */
    public function store(Request $request)
    {
        $request->validate([
            'demo_file' => 'required|file|max:100000',
        ]);

        try {
            $path = $request->file('demo_file')->store('temp_demos');
            $fullPath = storage_path('app/' . $path);

            $estadisticas = $this->parser->parseStats($fullPath);

            if ($estadisticas === null) {
                $this->parser->cleanupFile($fullPath);
                return back()->with('error', 'El parser devolvió un JSON vacío.');
            }

            $mapName = $this->parser->parseMapName($fullPath);

            $this->parser->cleanupFile($fullPath);

            $this->parser->saveAnalisis(Auth::id(), $mapName, $estadisticas);

            return redirect()->route('analisis')->with('success', '¡Análisis completado y guardado!');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $analisis = Analisis::findOrFail($id);
        $stats = collect($analisis->stats)->sortByDesc('score')->values();
        return view('analisis.show', compact('analisis', 'stats'));
    }
}
