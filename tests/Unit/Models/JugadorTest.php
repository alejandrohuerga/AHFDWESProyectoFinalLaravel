<?php

namespace Tests\Unit\Models;

use App\Models\Jugador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JugadorTest extends TestCase
{
    use RefreshDatabase;

    public function test_table_name(): void
    {
        $model = new Jugador;
        $this->assertEquals('jugadores', $model->getTable());
    }

    public function test_fillable_attributes(): void
    {
        $model = new Jugador;
        $expected = [
            'nombreJugador',
            'nombreEquipo',
            'bajas_totales',
            'headshot_porcentaje',
            'muertes_totales',
            'KD_ratio',
            'damage_por_ronda',
            'mapas_jugados',
            'bajas_por_ronda',
            'asistencias_por_ronda',
            'muertes_por_ronda',
            'rating_de_impacto',
        ];

        $this->assertEquals($expected, $model->getFillable());
    }

    public function test_can_create_jugador(): void
    {
        $jugador = Jugador::create([
            'nombreJugador' => 's1mple',
            'nombreEquipo' => 'Natus Vincere',
            'bajas_totales' => 5000,
            'headshot_porcentaje' => 55.3,
            'muertes_totales' => 3500,
            'KD_ratio' => 1.43,
            'damage_por_ronda' => 85.2,
            'mapas_jugados' => 200,
            'bajas_por_ronda' => 0.85,
            'asistencias_por_ronda' => 0.12,
            'muertes_por_ronda' => 0.60,
            'rating_de_impacto' => 1.35,
        ]);

        $this->assertDatabaseHas('jugadores', [
            'nombreJugador' => 's1mple',
            'nombreEquipo' => 'Natus Vincere',
        ]);
        $this->assertEquals(5000, $jugador->bajas_totales);
        $this->assertEqualsWithDelta(55.3, $jugador->headshot_porcentaje, 0.01);
    }

    public function test_update_or_create_prevents_duplicates(): void
    {
        Jugador::create([
            'nombreJugador' => 'ZywOo',
            'nombreEquipo' => 'Vitality',
            'bajas_totales' => 4000,
            'headshot_porcentaje' => 50.0,
            'muertes_totales' => 3000,
            'KD_ratio' => 1.33,
            'damage_por_ronda' => 80.0,
            'mapas_jugados' => 150,
            'bajas_por_ronda' => 0.80,
            'asistencias_por_ronda' => 0.10,
            'muertes_por_ronda' => 0.60,
            'rating_de_impacto' => 1.30,
        ]);

        Jugador::updateOrCreate(
            ['nombreJugador' => 'ZywOo'],
            [
                'nombreEquipo' => 'Vitality',
                'bajas_totales' => 4500,
                'headshot_porcentaje' => 51.0,
                'muertes_totales' => 3200,
                'KD_ratio' => 1.40,
                'damage_por_ronda' => 82.0,
                'mapas_jugados' => 160,
                'bajas_por_ronda' => 0.82,
                'asistencias_por_ronda' => 0.11,
                'muertes_por_ronda' => 0.58,
                'rating_de_impacto' => 1.32,
            ]
        );

        $this->assertEquals(1, Jugador::where('nombreJugador', 'ZywOo')->count());
        $this->assertEquals(4500, Jugador::where('nombreJugador', 'ZywOo')->first()->bajas_totales);
    }

    public function test_jugador_has_timestamps(): void
    {
        $model = new Jugador;
        $this->assertTrue($model->usesTimestamps());
    }
}
