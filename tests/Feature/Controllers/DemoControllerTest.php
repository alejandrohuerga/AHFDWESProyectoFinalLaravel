<?php

namespace Tests\Feature\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guardar_archivo_requires_authentication(): void
    {
        $response = $this->post('/demo/guardar');
        $response->assertRedirect('/login');
    }

    public function test_guardar_archivo_validates_file_is_required(): void
    {
        $user = Usuario::create([
            'nombre' => 'DemoTester',
            'correo' => 'demotester@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->post('/demo/guardar', []);
        $response->assertSessionHasErrors('file');
    }

    public function test_demo_ejemplo_requires_authentication(): void
    {
        $response = $this->get('/demo/ejemplo');
        $response->assertRedirect('/login');
    }
}
