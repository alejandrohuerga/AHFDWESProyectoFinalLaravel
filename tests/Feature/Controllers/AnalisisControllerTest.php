<?php

namespace Tests\Feature\Controllers;

use App\Models\Analisis;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalisisControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthenticatedUser(): Usuario
    {
        return Usuario::create([
            'nombre' => 'TestAnalisis',
            'correo' => 'analisis@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function makeRealisticStats(): array
    {
        return [
            [
                'name' => 'Player1',
                'kills_total' => 25,
                'deaths_total' => 15,
                'score' => 60,
                'mvps' => 3,
                'headshot_kills_total' => 12,
            ],
            [
                'name' => 'Player2',
                'kills_total' => 18,
                'deaths_total' => 20,
                'score' => 40,
                'mvps' => 1,
                'headshot_kills_total' => 8,
            ],
        ];
    }

    public function test_analisis_index_requires_authentication(): void
    {
        $response = $this->get('/analisis');
        $response->assertRedirect('/login');
    }

    public function test_analisis_index_returns_view_for_authenticated_user(): void
    {
        $user = $this->createAuthenticatedUser();

        $response = $this->actingAs($user)->get('/analisis');
        $response->assertStatus(200);
        $response->assertViewIs('analisis');
        $response->assertViewHas('analisisSubidos');
    }

    public function test_analisis_index_shows_only_user_analyses(): void
    {
        $user1 = Usuario::create([
            'nombre' => 'User1',
            'correo' => 'user1@test.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = Usuario::create([
            'nombre' => 'User2',
            'correo' => 'user2@test.com',
            'password' => bcrypt('password'),
        ]);

        $analisis1 = new Analisis;
        $analisis1->user_id = $user1->id;
        $analisis1->map_name = 'Inferno';
        $analisis1->stats = $this->makeRealisticStats();
        $analisis1->save();

        $analisis2 = new Analisis;
        $analisis2->user_id = $user2->id;
        $analisis2->map_name = 'Dust2';
        $analisis2->stats = $this->makeRealisticStats();
        $analisis2->save();

        $response = $this->actingAs($user1)->get('/analisis');
        $response->assertViewHas('analisisSubidos', function ($collection) {
            return $collection->count() === 1
                && $collection->first()->map_name === 'Inferno';
        });
    }

    public function test_analisis_show_displays_analysis(): void
    {
        $user = $this->createAuthenticatedUser();

        $analisis = new Analisis;
        $analisis->user_id = $user->id;
        $analisis->map_name = 'Mirage';
        $analisis->stats = $this->makeRealisticStats();
        $analisis->save();

        $response = $this->actingAs($user)->get("/analisis/{$analisis->id}");
        $response->assertStatus(200);
        $response->assertViewIs('analisis.show');
        $response->assertViewHas('analisis');
        $response->assertViewHas('stats');
    }

    public function test_analisis_show_sorts_stats_by_score_descending(): void
    {
        $user = $this->createAuthenticatedUser();

        $analisis = new Analisis;
        $analisis->user_id = $user->id;
        $analisis->map_name = 'Nuke';
        $analisis->stats = [
            ['name' => 'Low', 'kills_total' => 5, 'deaths_total' => 10, 'score' => 5, 'mvps' => 0, 'headshot_kills_total' => 2],
            ['name' => 'High', 'kills_total' => 30, 'deaths_total' => 10, 'score' => 30, 'mvps' => 5, 'headshot_kills_total' => 15],
            ['name' => 'Mid', 'kills_total' => 15, 'deaths_total' => 12, 'score' => 15, 'mvps' => 2, 'headshot_kills_total' => 7],
        ];
        $analisis->save();

        $response = $this->actingAs($user)->get("/analisis/{$analisis->id}");
        $response->assertViewHas('stats', function ($stats) {
            return $stats[0]['name'] === 'High'
                && $stats[1]['name'] === 'Mid'
                && $stats[2]['name'] === 'Low';
        });
    }

    public function test_analisis_show_returns_404_for_nonexistent_id(): void
    {
        $user = $this->createAuthenticatedUser();

        $response = $this->actingAs($user)->get('/analisis/99999');
        $response->assertStatus(404);
    }

    public function test_store_requires_demo_file(): void
    {
        $user = $this->createAuthenticatedUser();

        $response = $this->actingAs($user)->post('/demo/guardar', []);
        $response->assertSessionHasErrors('file');
    }
}
