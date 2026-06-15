<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            if (!is_string($uploadId) || !preg_match('/^[a-f0-9\-]{36}$/i', $uploadId)) {
                return response()->json(['error' => 'uploadId inválido'], 400);
            }

            if (!is_numeric($chunkIndex) || (int) $chunkIndex < 0) {
                return response()->json(['error' => 'chunkIndex inválido'], 400);
            }

            $dirPath = Storage::path("chunks/{$uploadId}");
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0775, true);
            }

            $chunk->move($dirPath, "chunk_{$chunkIndex}");

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            Log::error('ERROR recibirChunk: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
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

        if (!is_string($uploadId) || !preg_match('/^[a-f0-9\-]{36}$/i', $uploadId)) {
            return response()->json(['error' => 'uploadId inválido'], 400);
        }

        if ($totalChunks <= 0) {
            return response()->json(['error' => 'totalChunks debe ser mayor que 0'], 400);
        }

        $destino = null;

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
            if ($destino === false) {
                throw new \RuntimeException("No se pudo crear el archivo ensamblado: {$rutaAbsoluta}");
            }

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = "{$chunksPath}/chunk_{$i}";
                if (!file_exists($chunkFile)) {
                    throw new \Exception("Chunk {$i} no encontrado en: {$chunkFile}");
                }
                $handle = fopen($chunkFile, 'rb');
                if ($handle === false) {
                    throw new \RuntimeException("No se pudo leer el chunk: {$chunkFile}");
                }
                stream_copy_to_stream($handle, $destino);
                fclose($handle);
            }
            fclose($destino);
            $destino = null;

            Log::info('Archivo ensamblado: ' . $rutaAbsoluta);

            // 3. Borrar chunks
            $this->borrarDirectorio($chunksPath);

            // 4. Parser del mapa
            $mapName = 'Desconocido';
            $resultadoMapa = Process::path(storage_path('scripts/demoparser'))
                ->timeout(30)
                ->run("/var/www/vhosts/alejandrohuefer.ieslossauces.es/.nodenv/shims/node metadate.cjs " . escapeshellarg($rutaAbsoluta));

            if ($resultadoMapa->successful()) {
                $mapaJson = json_decode($resultadoMapa->output(), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning('JSON del parser de mapa inválido (XL): ' . json_last_error_msg());
                } else {
                    $raw      = $mapaJson['map'] ?? '';
                    $mapName  = !empty($raw) ? ucfirst(preg_replace('/^[a-z]+_/', '', $raw)) : 'Desconocido';
                }
            } else {
                Log::warning('Parser de mapa falló (XL): ' . $resultadoMapa->errorOutput());
            }

            // 5. Parser de estadísticas
            $resultado = Process::path(storage_path('scripts/demoparser'))
                ->timeout(300)
                ->run("/var/www/vhosts/alejandrohuefer.ieslossauces.es/.nodenv/shims/node parse.cjs " . escapeshellarg($rutaAbsoluta));

            // 6. Borrar el .dem
            if (file_exists($rutaAbsoluta)) {
                unlink($rutaAbsoluta);
            }

            if (!$resultado->successful()) {
                Log::error('Parser de estadísticas falló (XL): ' . $resultado->errorOutput());
                return response()->json([
                    'error' => 'Error en el parser: ' . $resultado->errorOutput()
                ], 500);
            }

            $estadisticas = json_decode($resultado->output(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON de estadísticas inválido (XL): ' . json_last_error_msg(), [
                    'raw_output_preview' => substr($resultado->output(), 0, 500),
                ]);
                return response()->json(['error' => 'El parser devolvió datos inválidos.'], 500);
            }

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
                'redirect' => route('analisis')
            ]);

        } catch (\Exception $e) {
            if (is_resource($destino)) {
                fclose($destino);
            }
            Log::error('ERROR ensamblarChunks: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
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
