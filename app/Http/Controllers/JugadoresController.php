<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Charts\MonthlyUsersChart;
class JugadoresController extends Controller
{

    public function consumirJSONjugadores()
    {
        $path = storage_path('app/private/JSON/Top50-2026.json');
        if (!File::exists($path)) {
            return "El archivo JSON no existe en la ruta especificada.";
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        foreach($data as $jugador){
            // Esto evita que se dupliquen cada vez que entras a la URL
            Jugador::updateOrCreate(
                ['nombreJugador' => $jugador['playerName']], // Condición para buscar
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
    }

    public function show($id, MonthlyUsersChart $chart) {

        $info = Jugador::findOrFail($id);

        // Construimos la gráfica pasando el jugador específico
        $grafica = $chart->build($info);

        return view('estadisticas_jugador', [
            'info' => $info,
            'grafica' => $grafica
        ]);
    }
}
