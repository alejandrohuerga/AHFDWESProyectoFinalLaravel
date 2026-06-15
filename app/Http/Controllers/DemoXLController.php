<?php
namespace App\Http\Controllers;

use App\Services\DemoParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    private const XL_NODE_BINARY = '/var/www/vhosts/alejandrohuefer.ieslossauces.es/.nodenv/shims/node';

    public function __construct(
        protected DemoParserService $parser
    ) {}

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

            $dirPath = Storage::path("chunks/{$uploadId}");
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0775, true);
            }

            $chunk->move($dirPath, "chunk_{$chunkIndex}");

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            Log::error('ERROR recibirChunk: ' . $e->getMessage());
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
            $demosPath = Storage::path('demos');
            if (!is_dir($demosPath)) {
                mkdir($demosPath, 0775, true);
            }

            $nombreArchivo = Str::random(40) . '.dem';
            $rutaAbsoluta  = str_replace('\\', '/', Storage::path("demos/{$nombreArchivo}"));
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

            Log::info('Archivo ensamblado: ' . $rutaAbsoluta);

            $this->borrarDirectorio($chunksPath);

            $mapName      = $this->parser->parseMapName($rutaAbsoluta, self::XL_NODE_BINARY);
            $estadisticas = $this->parser->parseStats($rutaAbsoluta, self::XL_NODE_BINARY, 300);

            $this->parser->cleanupFile($rutaAbsoluta);

            if ($estadisticas === null) {
                return response()->json(['error' => 'La demo no contenía datos válidos.'], 422);
            }

            $this->parser->saveAnalisis(Auth::id(), $mapName, $estadisticas);

            return response()->json([
                'success'  => true,
                'mensaje'  => '¡Análisis completado!',
                'redirect' => route('analisis')
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR ensamblarChunks: ' . $e->getMessage());
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
