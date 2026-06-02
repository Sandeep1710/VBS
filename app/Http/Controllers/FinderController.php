<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinderController extends Controller
{
    public function index(): View
    {
        $types = VehicleType::where('is_active', true)->orderBy('sort_order')->get();
        return view('finder.index', compact('types'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vehicle_type_id' => ['nullable', 'integer', 'exists:vehicle_types,id'],
            'vehicle_brand_id' => ['nullable', 'integer', 'exists:vehicle_brands,id'],
            'vehicle_model_id' => ['nullable', 'integer', 'exists:vehicle_models,id'],
            'vehicle_variant_id' => ['required', 'integer', 'exists:vehicle_variants,id'],
            'year' => ['nullable', 'integer'],
        ]);

        return redirect()->route('products.index', [
            'vehicle_variant' => $data['vehicle_variant_id'],
        ])->with('success', 'Showing batteries compatible with your vehicle.');
    }

    public function brands(Request $request): JsonResponse
    {
        $request->validate(['type' => ['required', 'integer', 'exists:vehicle_types,id']]);

        $brands = VehicleBrand::where('is_active', true)
            ->whereHas('vehicleModels', fn ($q) => $q->where('vehicle_type_id', $request->integer('type'))->where('is_active', true))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($brands);
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
            ->get(['id', 'name']);

        return response()->json($models);
    }

    public function variants(Request $request): JsonResponse
    {
        $request->validate(['model' => ['required', 'integer', 'exists:vehicle_models,id']]);

        $variants = VehicleVariant::where('is_active', true)
            ->where('vehicle_model_id', $request->integer('model'))
            ->orderBy('name')
            ->get(['id', 'name', 'fuel_type', 'year_from', 'year_to']);

        return response()->json($variants);
    }
}
