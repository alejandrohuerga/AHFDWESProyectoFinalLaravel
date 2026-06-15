<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Charts\MonthlyUsersChart;

class JugadoresController extends Controller
{
    public function consumirJSONjugadores()
    {
        $path = storage_path('app/private/JSON/Top50-2026.json');
        if (!File::exists($path)) {
            Log::error('Archivo JSON de jugadores no encontrado: ' . $path);
            abort(404, 'El archivo JSON de jugadores no se encontró.');
        }

        try {
            $json = File::get($path);
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error al decodificar JSON de jugadores: ' . json_last_error_msg());
                abort(500, 'El archivo de jugadores contiene JSON inválido.');
            }

            if (!is_array($data) || empty($data)) {
                Log::warning('JSON de jugadores vacío o con formato inesperado: ' . $path);
                abort(500, 'El archivo de jugadores está vacío o tiene un formato inesperado.');
            }

            foreach ($data as $jugador) {
                Jugador::updateOrCreate(
                    ['nombreJugador' => $jugador['playerName']],
                    [
                        'nombreEquipo' => $jugador['teamName'],
                        'bajas_totales' => $jugador['Total kills'],
                        'headshot_porcentaje' => $jugador['Headshot %'],
                        'muertes_totales' => $jugador['Total deaths'],
                        'KD_ratio' => $jugador['K/D Ratio'],
                        'damage_por_ronda' => $jugador['Damage / Round'],
                        'mapas_jugados' => $jugador['Maps played'],
                        'bajas_por_ronda' => $jugador['Kills / round'],
                        'asistencias_por_ronda' => $jugador['Assists / round'],
                        'muertes_por_ronda' => $jugador['Deaths / round'],
                        'rating_de_impacto' => $jugador['Impact rating'],
                    ]
                );
            }

            $jugadores = Jugador::all();
            return view('jugadores', compact('jugadores'));

        } catch (\Exception $e) {
            Log::error('Error al procesar jugadores: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'Error al cargar los datos de jugadores.');
        }
    }

    public function show($id, MonthlyUsersChart $chart)
    {
        $info = Jugador::findOrFail($id);
        $grafica = $chart->build($info);

        return view('estadisticas_jugador', [
            'info' => $info,
            'grafica' => $grafica,
        ]);
    }
}
