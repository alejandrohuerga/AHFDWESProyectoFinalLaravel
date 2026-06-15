<?php

namespace Tests\Unit\Models;

use App\Models\Demos;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemosTest extends TestCase
{
    use RefreshDatabase;

    public function test_table_name_is_demos(): void
    {
        $model = new Demos;
        $this->assertEquals('demos', $model->getTable());
    }

    public function test_created_at_constant(): void
    {
        $this->assertEquals('fecha_creacion', Demos::CREATED_AT);
    }

    public function test_updated_at_constant(): void
    {
        $this->assertEquals('fecha_subida', Demos::UPDATED_AT);
    }

    public function test_fillable_attributes(): void
    {
        $model = new Demos;
        $expected = [
            'usuario_id',
            'nombre_archivo',
            'nombre_original',
            'ruta',
            'estado',
            'fecha_subida',
            'fecha_creacion',
        ];

        $this->assertEquals($expected, $model->getFillable());
    }

    public function test_can_create_demo_record(): void
    {
        $usuario = Usuario::create([
            'nombre' => 'DemoUser',
            'correo' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        $demo = Demos::create([
            'usuario_id' => $usuario->id,
            'nombre_archivo' => 'abc123.dem',
            'nombre_original' => 'match.dem',
            'ruta' => '/storage/demos/abc123.dem',
            'estado' => 'subido',
            'fecha_subida' => now(),
            'fecha_creacion' => now(),
        ]);

        $this->assertDatabaseHas('demos', [
            'nombre_archivo' => 'abc123.dem',
            'nombre_original' => 'match.dem',
            'estado' => 'subido',
        ]);
    }

    public function test_mass_assignment_protection(): void
    {
        $model = new Demos;
        $model->fill([
            'usuario_id' => 1,
            'nombre_archivo' => 'test.dem',
            'nombre_original' => 'original.dem',
            'ruta' => '/path',
            'estado' => 'pendiente',
        ]);

        $this->assertEquals('test.dem', $model->nombre_archivo);
        $this->assertEquals('original.dem', $model->nombre_original);
    }
}
