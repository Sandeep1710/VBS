<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    public function show(): JsonResponse|CartResource
    {
        $cart = $this->cart->find();
        if (! $cart) {
            return response()->json(['data' => null]);
        }

        $cart->load(['items.product.batteryBrand', 'items.product.primaryImage']);
        $this->cart->recalculate($cart);
        $cart->refresh()->load(['items.product.batteryBrand', 'items.product.primaryImage']);

        return new CartResource($cart);
    }

    public function add(Request $request, Product $product): JsonResponse|CartResource
    {
        if (! $product->is_active || $product->stock_quantity <= 0) {
            return response()->json(['message' => 'Product is out of stock.'], 422);
        }

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'exchange_old_battery' => ['nullable', 'boolean'],
        ]);

        $this->cart->add(
            $product,
            (int) ($data['quantity'] ?? 1),
            (bool) ($data['exchange_old_battery'] ?? false),
        );

        return $this->show();
    }

    public function update(Request $request, CartItem $item): JsonResponse|CartResource
    {
        $this->authorizeItem($item);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'exchange_old_battery' => ['nullable', 'boolean'],
        ]);

        if ($request->has('exchange_old_battery')) {
            $this->cart->setExchange($item, $request->boolean('exchange_old_battery'));
            $item = $item->fresh();
        }

        if (array_key_exists('quantity', $data) && $data['quantity'] !== null) {
            $this->cart->updateQuantity($item, (int) $data['quantity']);
        }

        return $this->show();
    }

    public function remove(CartItem $item): JsonResponse|CartResource
    {
        $this->authorizeItem($item);
        $this->cart->removeItem($item);
        return $this->show();
    }

    public function applyCoupon(Request $request): JsonResponse|CartResource
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:40'],
        ]);

        $result = $this->cart->applyCoupon(strtoupper(trim($data['code'])));
        if (! ($result['valid'] ?? false)) {
            return response()->json(['message' => $result['error'] ?? 'Invalid coupon.'], 422);
        }

        return $this->show();
    }

    public function removeCoupon(): JsonResponse|CartResource
    {
        $this->cart->removeCoupon();
        return $this->show();
    }

    private function authorizeItem(CartItem $item): void
    {
        $cart = $item->cart;
        if (! $cart) {
            abort(404);
        }
        if ($cart->user_id) {
            abort_unless($cart->user_id === auth()->id(), 403);
        } else {
            $token = request()->cookie(CartService::SESSION_COOKIE);
            abort_unless($cart->session_token === $token, 403);
        }
    }
}
