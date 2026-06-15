<?php

namespace Tests\Feature\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DemoXLControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthenticatedUser(): Usuario
    {
        return Usuario::create([
            'nombre' => 'DemoXLUser',
            'correo' => 'demoxl@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_demo_xl_index_requires_authentication(): void
    {
        $response = $this->get('/demo-xl');
        $response->assertRedirect('/login');
    }

    public function test_demo_xl_index_returns_view_for_authenticated_user(): void
    {
        $user = $this->createAuthenticatedUser();

        $response = $this->actingAs($user)->get('/demo-xl');
        $response->assertStatus(200);
        $response->assertViewIs('demo-xl');
    }

    public function test_recibir_chunk_requires_authentication(): void
    {
        $response = $this->post('/demo-xl/chunk');
        $response->assertRedirect('/login');
    }

    public function test_recibir_chunk_returns_error_without_chunk_file(): void
    {
        $user = $this->createAuthenticatedUser();

        $response = $this->actingAs($user)->postJson('/demo-xl/chunk', [
            'chunkIndex' => 0,
            'uploadId' => 'test-upload-123',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'No se recibió el chunk']);
    }

    public function test_recibir_chunk_saves_chunk_file(): void
    {
        Storage::fake('local');
        $user = $this->createAuthenticatedUser();

        $chunk = UploadedFile::fake()->create('chunk_0', 1024);

        $response = $this->actingAs($user)->postJson('/demo-xl/chunk', [
            'chunk' => $chunk,
            'chunkIndex' => 0,
            'uploadId' => 'test-upload-456',
        ]);

        $response->assertJson(['ok' => true]);
    }

    public function test_ensamblar_chunks_requires_authentication(): void
    {
        $response = $this->post('/demo-xl/ensamblar');
        $response->assertRedirect('/login');
    }
}
