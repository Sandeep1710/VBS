<?php

namespace Tests\Feature\Api;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiFinderTest extends TestCase
{
    use RefreshDatabase;

    public function test_finder_cascading_dropdowns(): void
    {
        $type = VehicleType::create(['name' => 'Car', 'slug' => 'car', 'is_active' => true]);
        $brand = VehicleBrand::create(['name' => 'Tata', 'slug' => 'tata', 'is_active' => true]);
        $model = VehicleModel::create([
            'vehicle_type_id' => $type->id,
            'vehicle_brand_id' => $brand->id,
            'name' => 'Nexon',
            'slug' => 'nexon',
            'is_active' => true,
        ]);
        $variant = VehicleVariant::create([
            'vehicle_model_id' => $model->id,
            'name' => 'XZ Plus',
            'fuel_type' => 'petrol',
            'year_from' => 2017,
            'is_active' => true,
        ]);

        $this->getJson('/api/v1/finder/types')
            ->assertOk()
            ->assertJsonFragment(['name' => 'Car']);

        $this->getJson("/api/v1/finder/brands?type={$type->id}")
            ->assertOk()
            ->assertJsonFragment(['name' => 'Tata']);

        $this->getJson("/api/v1/finder/models?type={$type->id}&brand={$brand->id}")
            ->assertOk()
            ->assertJsonFragment(['name' => 'Nexon']);

        $this->getJson("/api/v1/finder/variants?model={$model->id}")
            ->assertOk()
            ->assertJsonFragment(['name' => 'XZ Plus']);
    }
}
