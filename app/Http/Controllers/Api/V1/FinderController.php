<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinderController extends Controller
{
    public function types(): JsonResponse
    {
        return response()->json([
            'data' => VehicleType::where('is_active', true)
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug']),
        ]);
    }

    public function brands(Request $request): JsonResponse
    {
        $request->validate(['type' => ['required', 'integer', 'exists:vehicle_types,id']]);

        $brands = VehicleBrand::where('is_active', true)
            ->whereHas('vehicleModels', fn ($q) => $q->where('vehicle_type_id', $request->integer('type'))->where('is_active', true))
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json(['data' => $brands]);
    }

    public function models(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'integer', 'exists:vehicle_types,id'],
            'brand' => ['required', 'integer', 'exists:vehicle_brands,id'],
        ]);

        $models = VehicleModel::where('is_active', true)
            ->where('vehicle_type_id', $request->integer('type'))
            ->where('vehicle_brand_id', $request->integer('brand'))
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json(['data' => $models]);
    }

    public function variants(Request $request): JsonResponse
    {
        $request->validate(['model' => ['required', 'integer', 'exists:vehicle_models,id']]);

        $variants = VehicleVariant::where('is_active', true)
            ->where('vehicle_model_id', $request->integer('model'))
            ->orderBy('name')
            ->get(['id', 'name', 'fuel_type', 'year_from', 'year_to']);

        return response()->json(['data' => $variants]);
    }
}
