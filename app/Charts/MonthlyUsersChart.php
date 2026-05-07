<?php

namespace App\Charts;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Jugador;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    // Añadimos el parámetro Jugador $jugador
    public function build(Jugador $jugador): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setTitle('Bajas vs Muertes por Ronda')
            ->setSubtitle($jugador->nombreJugador)
            // Metemos los datos reales de tu base de datos
            ->addData([
                (float) $jugador->bajas_por_ronda, 
                (float) $jugador->muertes_por_ronda
            ])
            ->setFontColor('#FFFF')
            ->setLabels(['Kills/R', 'Deaths/R'])
            ->setColors(['#06b6d4', '#ef4444']);// Cian para Kills, Rojo para Deaths
    }
}
