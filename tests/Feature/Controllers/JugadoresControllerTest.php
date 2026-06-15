<?php

namespace Tests\Feature\Controllers;

use App\Models\Jugador;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JugadoresControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_jugadores_route_requires_authentication(): void
    {
        $response = $this->get('/jugadores');
        $response->assertRedirect('/login');
    }

    public function test_jugadores_show_displays_player_stats(): void
    {
        $user = Usuario::create([
            'nombre' => 'JugadorViewer',
            'correo' => 'viewer@test.com',
            'password' => bcrypt('password'),
        ]);

        $jugador = Jugador::create([
            'nombreJugador' => 'donk',
            'nombreEquipo' => 'Spirit',
            'bajas_totales' => 3000,
            'headshot_porcentaje' => 60.0,
            'muertes_totales' => 2000,
            'KD_ratio' => 1.50,
            'damage_por_ronda' => 90.0,
            'mapas_jugados' => 100,
            'bajas_por_ronda' => 0.90,
            'asistencias_por_ronda' => 0.15,
            'muertes_por_ronda' => 0.55,
            'rating_de_impacto' => 1.40,
        ]);

        $response = $this->actingAs($user)->get("/jugadores/{$jugador->id}");
        $response->assertStatus(200);
        $response->assertViewIs('estadisticas_jugador');
        $response->assertViewHas('info');
        $response->assertViewHas('grafica');
    }

    public function test_jugadores_show_returns_404_for_nonexistent_player(): void
    {
        $response = $this->get('/jugadores/99999');
        $response->assertStatus(404);
    }
}
