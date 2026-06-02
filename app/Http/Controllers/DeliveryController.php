<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Check if a pincode is serviceable. Used by both the web PDP (AJAX) and
     * the API.
     */
    public function check(Request $request): JsonResponse
    {
        $data = $request->validate([
            'pincode' => ['required', 'string', 'regex:/^[0-9]{4,10}$/'],
        ]);

        $row = Pincode::where('pincode', $data['pincode'])->first();

        if (! $row || ! $row->is_serviceable) {
            return response()->json([
                'serviceable' => false,
                'message' => 'Sorry — we don\'t deliver to this pincode yet.',
                'pincode' => $data['pincode'],
            ]);
        }

        return response()->json([
            'serviceable' => true,
            'pincode' => $row->pincode,
            'city' => $row->city,
            'state' => $row->state,
            'cod_available' => $row->cod_available,
            'delivery_charge' => (float) $row->delivery_charge,
            'expected_delivery_days' => (int) $row->expected_delivery_days,
            'message' => $row->expected_delivery_days <= 1
                ? 'Same-day or next-day delivery available.'
                : "Delivery in {$row->expected_delivery_days} business days.",
        ]);
    }
}
