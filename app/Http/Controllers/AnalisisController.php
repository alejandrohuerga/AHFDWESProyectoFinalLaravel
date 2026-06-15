<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Demos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AnalisisController extends Controller
{
    /**
     * Muestra la vista principal con los análisis del usuario.
     */
    public function seleccionarPartidosUsuario() 
    {
        $analisisSubidos = Analisis::where('user_id', Auth::id())->latest()->get();
        return view('analisis', compact('analisisSubidos'));
    }

    /**
     * Recibe el archivo .dem, lo parsea con Node y guarda el JSON en la DB.
     */
    public function store(Request $request)
    {
        // 1. Validar la subida del archivo
        $request->validate([
            'demo_file' => 'required|file|max:100000', // ~100MB
        ]);

        try {
            // 2. Guardar el archivo temporalmente
            // Usamos el disco 'local' (storage/app)
            $path = $request->file('demo_file')->store('temp_demos');
            $fullPath = storage_path('app/' . $path);

            // 3. Ejecutar el script de Node.js
            $scriptPath = base_path('scripts/parse_demo.js'); 
            
            // Usamos Process de Laravel para capturar la salida
            $result = Process::run("node \"$scriptPath\" \"$fullPath\"");

            if (!$result->successful()) {
                \Illuminate\Support\Facades\Log::error('Error en el parser: ' . $result->errorOutput());
                return back()->with('error', 'Error al procesar el archivo demo.');
            }

            // 4. Decodificar el JSON que escupe el script de Node
            $datosJson = json_decode($result->output(), true);

            if (empty($datosJson)) {
                return back()->with('error', 'El parser devolvió un JSON vacío.');
            }

            // 5. Guardar en la base de datos
            $nuevoAnalisis = new Analisis();
            $nuevoAnalisis->user_id = Auth::id();
            $nuevoAnalisis->map_name = "Inferno"; // Luego puedes dinamizar esto si el JSON trae el mapa
            $nuevoAnalisis->stats = $datosJson; // IMPORTANTE: El modelo debe tener: protected $casts = ['stats' => 'array'];
            $nuevoAnalisis->save();

            // 6. Limpiar: Borrar el archivo .dem temporal para no llenar el disco
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return redirect()->route('analisis.index')->with('success', '¡Análisis completado y guardado!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error en AnalisisController@store: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al procesar el análisis.');
        }
    }

    public function show($id)
    {
        $analisis = Analisis::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $stats = collect($analisis->stats)->sortByDesc('score')->values();
        return view('analisis.show', compact('analisis', 'stats'));
    }

    // Si usas una ruta tipo index independiente
    public function index()
    {
        $analisisSubidos = Analisis::where('user_id', Auth::id())
                            ->latest()
                            ->get();
        return view('analisis.index', compact('analisisSubidos'));
    }
}