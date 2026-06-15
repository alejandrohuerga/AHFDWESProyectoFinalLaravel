<?php

namespace App\Services;

use App\Models\Analisis;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class DemoParserService
{
    /**
     * Parse the map name from a .dem file using the metadate.cjs script.
     */
    public function parseMapName(string $demoAbsolutePath, ?string $nodeBinary = null, int $timeout = 30): string
    {
        $node = $nodeBinary ?? 'node';
        $result = Process::path(storage_path('scripts/demoparser'))
            ->timeout($timeout)
            ->run("{$node} metadate.cjs " . escapeshellarg($demoAbsolutePath));

        if (!$result->successful()) {
            return 'Desconocido';
        }

        $mapJson = json_decode($result->output(), true);
        $raw = $mapJson['map'] ?? '';

        return !empty($raw)
            ? ucfirst(preg_replace('/^[a-z]+_/', '', $raw))
            : 'Desconocido';
    }

    /**
     * Parse player statistics from a .dem file using the parse.cjs script.
     *
     * @return array|null Decoded stats array, or null on failure.
     */
    public function parseStats(string $demoAbsolutePath, ?string $nodeBinary = null, int $timeout = 120): ?array
    {
        $node = $nodeBinary ?? 'node';
        $result = Process::path(storage_path('scripts/demoparser'))
            ->timeout($timeout)
            ->run("{$node} parse.cjs " . escapeshellarg($demoAbsolutePath));

        if (!$result->successful()) {
            return null;
        }

        $stats = json_decode($result->output(), true);

        return !empty($stats) ? $stats : null;
    }

    /**
     * Persist an Analisis record for the given user.
     */
    public function saveAnalisis(int $userId, string $mapName, array $stats): Analisis
    {
        $analisis = new Analisis();
        $analisis->user_id = $userId;
        $analisis->map_name = $mapName;
        $analisis->stats = $stats;
        $analisis->save();

        return $analisis;
    }

    /**
     * Safely delete a file from disk.
     */
    public function cleanupFile(string $absolutePath): void
    {
        if (file_exists($absolutePath)) {
            unlink($absolutePath);
        }
    }

    /**
     * Safely delete a file via the Storage facade.
     */
    public function cleanupStorageFile(string $relativePath): void
    {
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
        }
    }
}
