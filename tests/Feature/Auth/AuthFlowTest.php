<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_customer_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane Tester',
            'email' => 'jane@example.test',
            'phone' => '9876543210',
            'password' => 'secret-pass-1',
            'password_confirmation' => 'secret-pass-1',
            'terms' => '1',
        ]);

        $response->assertRedirect(route('account.dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'jane@example.test']);
        $this->assertAuthenticated();
    }

    public function test_a_customer_can_log_in(): void
    {
        $user = $this->makeCustomer(['email' => 'login@example.test']);

        $response = $this->post('/login', [
            'email' => 'login@example.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('account.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_customer_redirected_at_checkout(): void
    {
        $customer = $this->makeCustomer(verified: false);

        $this->actingAs($customer)
            ->get('/checkout')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_login_rejects_wrong_password(): void
    {
        $this->makeCustomer(['email' => 'wrongpw@example.test']);

        $this->from('/login')
            ->post('/login', ['email' => 'wrongpw@example.test', 'password' => 'nope'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
