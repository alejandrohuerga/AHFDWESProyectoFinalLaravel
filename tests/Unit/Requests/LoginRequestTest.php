<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorize_returns_true(): void
    {
        $request = new LoginRequest;
        $this->assertTrue($request->authorize());
    }

    public function test_rules_require_nombre_and_password(): void
    {
        $request = new LoginRequest;
        $rules = $request->rules();

        $this->assertArrayHasKey('nombre', $rules);
        $this->assertArrayHasKey('password', $rules);
        $this->assertContains('required', $rules['nombre']);
        $this->assertContains('string', $rules['nombre']);
        $this->assertContains('required', $rules['password']);
        $this->assertContains('string', $rules['password']);
    }

    public function test_throttle_key_uses_nombre_and_ip(): void
    {
        $request = LoginRequest::create('/login', 'POST', [
            'nombre' => 'TestUser',
        ]);
        $request->server->set('REMOTE_ADDR', '127.0.0.1');

        $key = $request->throttleKey();
        $this->assertStringContainsString('testuser', $key);
        $this->assertStringContainsString('127.0.0.1', $key);
    }

    public function test_authenticate_throws_on_invalid_credentials(): void
    {
        Usuario::create([
            'nombre' => 'ValidUser',
            'correo' => 'valid@test.com',
            'password' => bcrypt('correctpassword'),
        ]);

        $request = LoginRequest::create('/login', 'POST', [
            'nombre' => 'ValidUser',
            'password' => 'wrongpassword',
        ]);
        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        $request->setContainer(app());

        $this->expectException(ValidationException::class);
        $request->authenticate();
    }

    public function test_rate_limiting_after_too_many_attempts(): void
    {
        $request = LoginRequest::create('/login', 'POST', [
            'nombre' => 'RateLimitUser',
            'password' => 'wrong',
        ]);
        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        $request->setContainer(app());

        $key = $request->throttleKey();

        for ($i = 0; $i < 5; $i++) {
            RateLimiter::hit($key);
        }

        $this->expectException(ValidationException::class);
        $request->ensureIsNotRateLimited();
    }
}
