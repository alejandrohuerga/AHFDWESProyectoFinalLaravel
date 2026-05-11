<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controlador para subida de demos grandes por chunks.
 * @author Alejandro De la Huerga
 * @since 11/05/2026
 * @version 1.0.0
 */
class DemoXLController extends Controller
{
    public function index()
    {
        return view('demo-xl');
    }

    /**
     * Recibe cada chunk y lo guarda en disco.
     */
    public function recibirChunk(Request $request)
    {
        try {
            $chunk      = $request->file('chunk');
            $chunkIndex = $request->input('chunkIndex');
            $uploadId   = $request->input('uploadId');

            if (!$chunk) {
                return response()->json(['error' => 'No se recibió el chunk'], 400);
            }

            // Storage::path() resuelve la ruta correcta en cualquier versión de Laravel
            $dirPath = Storage::path("chunks/{$uploadId}");
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0775, true);
            }

            $chunk->move($dirPath, "chunk_{$chunkIndex}");

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            \Log::error('ERROR recibirChunk: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Ensambla todos los chunks y lanza el parser.
     */
    public function ensamblarChunks(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(600);

        $uploadId    = $request->input('uploadId');
        $totalChunks = (int) $request->input('totalChunks');

        try {
            // 1. Crear carpeta demos si no existe
            $demosPath = Storage::path('demos');
            if (!is_dir($demosPath)) {
                mkdir($demosPath, 0775, true);
            }

            // 2. Ensamblar chunks en un único .dem
            $nombreArchivo = Str::random(40) . '.dem';
            $rutaAbsoluta  = str_replace('\\', '/', Storage::path("demos/{$nombreArchivo}"));
            $rutaRelativa  = "demos/{$nombreArchivo}";
            $chunksPath    = Storage::path("chunks/{$uploadId}");

            $destino = fopen($rutaAbsoluta, 'wb');
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = "{$chunksPath}/chunk_{$i}";
                if (!file_exists($chunkFile)) {
                    throw new \Exception("Chunk {$i} no encontrado en: {$chunkFile}");
                }
                $handle = fopen($chunkFile, 'rb');
                stream_copy_to_stream($handle, $destino);
                fclose($handle);
            }
            fclose($destino);

            \Log::info('✅ Archivo ensamblado: ' . $rutaAbsoluta);

            // 3. Borrar chunks
            $this->borrarDirectorio($chunksPath);

            // 4. Parser del mapa
            $mapName = 'Desconocido';
            $resultadoMapa = Process::path(storage_path('scripts/demoparser'))
                ->timeout(30)
                ->run("node metadate.cjs " . escapeshellarg($rutaAbsoluta));

            if ($resultadoMapa->successful()) {
                $mapaJson = json_decode($resultadoMapa->output(), true);
                $raw      = $mapaJson['map'] ?? '';
                $mapName  = !empty($raw) ? ucfirst(preg_replace('/^[a-z]+_/', '', $raw)) : 'Desconocido';
            }

            // 5. Parser de estadísticas
            $resultado = Process::path(storage_path('scripts/demoparser'))
                ->timeout(300)
                ->run("node parse.cjs " . escapeshellarg($rutaAbsoluta));

            // 6. Borrar el .dem
            if (file_exists($rutaAbsoluta)) {
                unlink($rutaAbsoluta);
            }

            if (!$resultado->successful()) {
                return response()->json([
                    'error' => 'Error en el parser: ' . $resultado->errorOutput()
                ], 500);
            }

            $estadisticas = json_decode($resultado->output(), true);

            if (empty($estadisticas)) {
                return response()->json(['error' => 'La demo no contenía datos válidos.'], 422);
            }

            // 7. Guardar en base de datos
            $analisis           = new \App\Models\Analisis();
            $analisis->user_id  = Auth::id();
            $analisis->map_name = $mapName;
            $analisis->stats    = $estadisticas;
            $analisis->save();

            return response()->json([
                'success'  => true,
                'mensaje'  => '¡Análisis completado!',
                'redirect' => route('analisis.index')
            ]);

        } catch (\Exception $e) {
            \Log::error('ERROR ensamblarChunks: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Borra un directorio y todo su contenido.
     */
    private function borrarDirectorio(string $path): void
    {
        if (!is_dir($path)) return;
        $archivos = glob($path . '/*');
        foreach ($archivos as $archivo) {
            is_dir($archivo) ? $this->borrarDirectorio($archivo) : unlink($archivo);
        }
        rmdir($path);
    }
}