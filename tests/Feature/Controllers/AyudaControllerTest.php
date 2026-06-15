<?php

namespace Tests\Feature\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AyudaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ayuda_page_is_accessible(): void
    {
        $user = Usuario::create([
            'nombre' => 'AyudaUser',
            'correo' => 'ayuda@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/ayuda');
        $response->assertStatus(200);
    }

    public function test_ayuda_returns_correct_view(): void
    {
        $user = Usuario::create([
            'nombre' => 'AyudaUser2',
            'correo' => 'ayuda2@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/ayuda');
        $response->assertViewIs('ayuda');
    }

    public function test_ayuda_route_exists(): void
    {
        $this->assertTrue(
            \Illuminate\Support\Facades\Route::has('ayuda')
        );
    }
}
