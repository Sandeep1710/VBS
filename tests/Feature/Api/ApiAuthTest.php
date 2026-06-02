<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_customer_and_returns_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'API Customer',
            'email' => 'apicust@example.test',
            'password' => 'secret-pass-1',
            'password_confirmation' => 'secret-pass-1',
            'device_name' => 'pixel-7',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email', 'is_admin']])
            ->assertJsonPath('user.is_admin', false);

        $this->assertDatabaseHas('users', ['email' => 'apicust@example.test']);
    }

    public function test_login_returns_token(): void
    {
        $user = $this->makeCustomer(['email' => 'apilogin@example.test']);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'apilogin@example.test',
            'password' => 'password',
        ]);

        $response->assertOk()->assertJsonStructure(['token', 'user']);
    }

    public function test_login_rejects_wrong_password(): void
    {
        $this->makeCustomer(['email' => 'wrong@example.test']);

        $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong@example.test',
            'password' => 'nope',
        ])->assertStatus(422);
    }

    public function test_me_returns_authenticated_user(): void
    {
        $user = $this->makeCustomer(['email' => 'me@example.test']);
        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('data.email', 'me@example.test');
    }

    public function test_unauthenticated_me_returns_401(): void
    {
        $this->getJson('/api/v1/auth/me')->assertStatus(401);
    }

    public function test_logout_revokes_token(): void
    {
        $user = $this->makeCustomer();
        $token = $user->createToken('test')->plainTextToken;
        $this->assertDatabaseCount('personal_access_tokens', 1);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout')
            ->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
