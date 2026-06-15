<?php

namespace Tests\Unit\Models;

use App\Models\Analisis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalisisTest extends TestCase
{
    use RefreshDatabase;

    public function test_stats_cast_to_array(): void
    {
        $model = new Analisis;
        $casts = $model->getCasts();

        $this->assertArrayHasKey('stats', $casts);
        $this->assertEquals('array', $casts['stats']);
    }

    public function test_default_table_name(): void
    {
        $model = new Analisis;
        $this->assertEquals('analises', $model->getTable());
    }

    public function test_can_create_and_retrieve_analisis(): void
    {
        $usuario = \App\Models\Usuario::create([
            'nombre' => 'TestUser',
            'correo' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $statsData = [
            ['name' => 'Player1', 'score' => 25, 'kills' => 20],
            ['name' => 'Player2', 'score' => 18, 'kills' => 15],
        ];

        $analisis = new Analisis;
        $analisis->user_id = $usuario->id;
        $analisis->map_name = 'Inferno';
        $analisis->stats = $statsData;
        $analisis->save();

        $retrieved = Analisis::find($analisis->id);
        $this->assertIsArray($retrieved->stats);
        $this->assertCount(2, $retrieved->stats);
        $this->assertEquals('Player1', $retrieved->stats[0]['name']);
        $this->assertEquals('Inferno', $retrieved->map_name);
    }

    public function test_stats_stored_as_json_decoded_as_array(): void
    {
        $usuario = \App\Models\Usuario::create([
            'nombre' => 'JsonUser',
            'correo' => 'json@example.com',
            'password' => bcrypt('password'),
        ]);

        $stats = [['kills' => 10, 'deaths' => 5]];

        $analisis = new Analisis;
        $analisis->user_id = $usuario->id;
        $analisis->map_name = 'Dust2';
        $analisis->stats = $stats;
        $analisis->save();

        $fresh = Analisis::find($analisis->id);
        $this->assertSame(10, $fresh->stats[0]['kills']);
        $this->assertSame(5, $fresh->stats[0]['deaths']);
    }
}
