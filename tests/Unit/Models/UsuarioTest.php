<?php

namespace Tests\Unit\Models;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_table_name(): void
    {
        $model = new Usuario;
        $this->assertEquals('usuarios', $model->getTable());
    }

    public function test_fillable_attributes(): void
    {
        $model = new Usuario;
        $expected = ['nombre', 'correo', 'password'];

        $this->assertEquals($expected, $model->getFillable());
    }

    public function test_hidden_attributes(): void
    {
        $model = new Usuario;
        $hidden = $model->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    public function test_casts_include_password_hashed(): void
    {
        $model = new Usuario;
        $casts = $model->getCasts();

        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    public function test_casts_include_fecha_verificacion_correo(): void
    {
        $model = new Usuario;
        $casts = $model->getCasts();

        $this->assertArrayHasKey('fecha_verificacion_correo', $casts);
        $this->assertEquals('datetime', $casts['fecha_verificacion_correo']);
    }

    public function test_extends_authenticatable(): void
    {
        $model = new Usuario;
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, $model);
    }

    public function test_uses_notifiable_trait(): void
    {
        $this->assertTrue(
            in_array(
                \Illuminate\Notifications\Notifiable::class,
                class_uses_recursive(Usuario::class)
            )
        );
    }

    public function test_can_create_usuario(): void
    {
        $usuario = Usuario::create([
            'nombre' => 'TestPlayer',
            'correo' => 'player@test.com',
            'password' => 'secret123',
        ]);

        $this->assertDatabaseHas('usuarios', [
            'nombre' => 'TestPlayer',
            'correo' => 'player@test.com',
        ]);
        $this->assertNotEquals('secret123', $usuario->fresh()->password);
    }

    public function test_password_is_hidden_in_array(): void
    {
        $usuario = Usuario::create([
            'nombre' => 'HiddenPwd',
            'correo' => 'hidden@test.com',
            'password' => 'secret123',
        ]);

        $array = $usuario->toArray();
        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_nombre_must_be_unique(): void
    {
        Usuario::create([
            'nombre' => 'UniqueUser',
            'correo' => 'first@test.com',
            'password' => 'password',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Usuario::create([
            'nombre' => 'UniqueUser',
            'correo' => 'second@test.com',
            'password' => 'password',
        ]);
    }
}
