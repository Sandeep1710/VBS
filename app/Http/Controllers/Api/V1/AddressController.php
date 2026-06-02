<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        return AddressResource::collection(
            $request->user()->addresses()->latest('is_default')->latest()->get()
        );
    }

    public function store(AddressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['country'] = $data['country'] ?? 'India';
        $data['user_id'] = $request->user()->id;
        $isDefault = (bool) ($data['is_default'] ?? false);

        $address = DB::transaction(function () use ($request, $data, $isDefault) {
            if ($isDefault || $request->user()->addresses()->doesntExist()) {
                $request->user()->addresses()->update(['is_default' => false]);
                $data['is_default'] = true;
            }
            return Address::create($data);
        });

        return response()->json(['data' => new AddressResource($address)], 201);
    }

    public function show(Request $request, Address $address): AddressResource
    {
        abort_unless($address->user_id === $request->user()->id, 403);
        return new AddressResource($address);
    }

    public function update(AddressRequest $request, Address $address): AddressResource
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $data = $request->validated();
        $data['country'] = $data['country'] ?? 'India';
        $isDefault = (bool) ($data['is_default'] ?? false);

        DB::transaction(function () use ($request, $address, $data, $isDefault) {
            if ($isDefault) {
                $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
                $data['is_default'] = true;
            }
            $address->update($data);
        });

        return new AddressResource($address->fresh());
    }

    public function destroy(Request $request, Address $address): JsonResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);
        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $next = $request->user()->addresses()->latest()->first();
            $next?->update(['is_default' => true]);
        }

        return response()->json(['message' => 'Address removed.']);
    }

    public function setDefault(Request $request, Address $address): AddressResource
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        DB::transaction(function () use ($request, $address) {
            $request->user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return new AddressResource($address->fresh());
    }
}
