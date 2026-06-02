<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_via_api(): void
    {
        $user = $this->makeCustomer();
        $token = $user->createToken('t')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson('/api/v1/profile', ['name' => 'New Name'])
            ->assertOk()
            ->assertJsonPath('data.name', 'New Name');

        $this->assertEquals('New Name', $user->fresh()->name);
    }

    public function test_user_can_create_and_list_addresses(): void
    {
        $user = $this->makeCustomer();
        $token = $user->createToken('t')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/addresses', [
                'label' => 'Home',
                'name' => 'API Address',
                'phone' => '9000000099',
                'line1' => 'Flat 1',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400001',
                'is_default' => true,
            ])
            ->assertCreated()
            ->assertJsonPath('data.is_default', true);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/addresses')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_user_cannot_view_anothers_address(): void
    {
        $user1 = $this->makeCustomer();
        $user2 = $this->makeCustomer();

        $address = \App\Models\Address::create([
            'user_id' => $user1->id, 'label' => 'X', 'name' => 'X',
            'phone' => '1', 'line1' => '1', 'city' => 'X',
            'state' => 'X', 'pincode' => '111111',
        ]);

        $token = $user2->createToken('t')->plainTextToken;
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/addresses/' . $address->id)
            ->assertStatus(403);
    }
}
