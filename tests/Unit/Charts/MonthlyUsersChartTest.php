<?php

namespace Tests\Unit\Charts;

use App\Charts\MonthlyUsersChart;
use App\Models\Jugador;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonthlyUsersChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_build_returns_donut_chart(): void
    {
        $jugador = Jugador::create([
            'nombreJugador' => 'ChartPlayer',
            'nombreEquipo' => 'TestTeam',
            'bajas_totales' => 1000,
            'headshot_porcentaje' => 50.0,
            'muertes_totales' => 800,
            'KD_ratio' => 1.25,
            'damage_por_ronda' => 75.0,
            'mapas_jugados' => 50,
            'bajas_por_ronda' => 0.75,
            'asistencias_por_ronda' => 0.10,
            'muertes_por_ronda' => 0.60,
            'rating_de_impacto' => 1.10,
        ]);

        $chart = new MonthlyUsersChart(new LarapexChart);
        $result = $chart->build($jugador);

        $this->assertInstanceOf(\ArielMejiaDev\LarapexCharts\DonutChart::class, $result);
    }

    public function test_chart_subtitle_matches_player_name(): void
    {
        $jugador = Jugador::create([
            'nombreJugador' => 'NiKo',
            'nombreEquipo' => 'G2',
            'bajas_totales' => 2000,
            'headshot_porcentaje' => 55.0,
            'muertes_totales' => 1500,
            'KD_ratio' => 1.33,
            'damage_por_ronda' => 82.0,
            'mapas_jugados' => 80,
            'bajas_por_ronda' => 0.85,
            'asistencias_por_ronda' => 0.12,
            'muertes_por_ronda' => 0.55,
            'rating_de_impacto' => 1.25,
        ]);

        $larapexChart = new LarapexChart;
        $chartBuilder = new MonthlyUsersChart($larapexChart);
        $donut = $chartBuilder->build($jugador);

        $this->assertNotNull($donut);
    }
}
