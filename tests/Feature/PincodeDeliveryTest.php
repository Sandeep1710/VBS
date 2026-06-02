<?php

namespace Tests\Feature;

use App\Models\Pincode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PincodeDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_serviceable_pincode_returns_full_info(): void
    {
        Pincode::create([
            'pincode' => '400001', 'city' => 'Mumbai', 'state' => 'MH',
            'is_serviceable' => true, 'cod_available' => true,
            'delivery_charge' => 0, 'expected_delivery_days' => 1,
        ]);

        $this->getJson('/delivery/check?pincode=400001')
            ->assertOk()
            ->assertJsonPath('serviceable', true)
            ->assertJsonPath('city', 'Mumbai')
            ->assertJsonPath('cod_available', true)
            ->assertJsonPath('expected_delivery_days', 1);
    }

    public function test_unknown_pincode_returns_not_serviceable(): void
    {
        $this->getJson('/delivery/check?pincode=999999')
            ->assertOk()
            ->assertJsonPath('serviceable', false);
    }

    public function test_invalid_pincode_format_rejected(): void
    {
        $this->getJson('/delivery/check?pincode=ab123')
            ->assertStatus(422);
    }

    public function test_api_endpoint_works_too(): void
    {
        Pincode::create([
            'pincode' => '110001', 'city' => 'Delhi', 'state' => 'DL',
            'is_serviceable' => true,
            'expected_delivery_days' => 2,
        ]);

        $this->getJson('/api/v1/delivery/check?pincode=110001')
            ->assertOk()
            ->assertJsonPath('serviceable', true)
            ->assertJsonPath('city', 'Delhi');
    }
}
