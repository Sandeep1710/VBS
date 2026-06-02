<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;

class CouponService
{
    /**
     * Validate a coupon for a given cart and (optionally) user.
     *
     * @return array{valid: bool, coupon?: Coupon, discount?: float, error?: string}
     */
    public function validate(string $code, Cart $cart, ?User $user = null): array
    {
        $coupon = Coupon::where('code', $code)->first();
        if (! $coupon) {
            return ['valid' => false, 'error' => 'Coupon code not found.'];
        }

        if (! $coupon->isValid()) {
            return ['valid' => false, 'error' => 'This coupon is not active or has expired.'];
        }

        $cart->loadMissing('items');
        $orderAmount = $this->orderableSubtotal($cart);

        if ((float) $coupon->min_order_amount > 0 && $orderAmount < (float) $coupon->min_order_amount) {
            return [
                'valid' => false,
                'error' => 'Minimum order of ₹' . number_format((float) $coupon->min_order_amount, 0) . ' required for this coupon.',
            ];
        }

        if ($coupon->is_first_order_only) {
            if (! $user) {
                return ['valid' => false, 'error' => 'Sign in to use this first-order coupon.'];
            }
            $hasOrder = Order::where('user_id', $user->id)->exists();
            if ($hasOrder) {
                return ['valid' => false, 'error' => 'This coupon is for first orders only.'];
            }
        }

        if ($user) {
            $usedByUser = CouponUsage::where('coupon_id', $coupon->id)
                ->where('user_id', $user->id)
                ->count();
            if ($coupon->per_user_limit !== null && $usedByUser >= $coupon->per_user_limit) {
                return ['valid' => false, 'error' => 'You have already used this coupon.'];
            }
        }

        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $this->calculateDiscount($coupon, $orderAmount),
        ];
    }

    public function discountFor(string $code, float $orderAmount): float
    {
        $coupon = Coupon::where('code', $code)->first();
        if (! $coupon || ! $coupon->isValid()) {
            return 0;
        }
        return $this->calculateDiscount($coupon, $orderAmount);
    }

    private function calculateDiscount(Coupon $coupon, float $orderAmount): float
    {
        $discount = match ($coupon->type) {
            Coupon::TYPE_FLAT => (float) $coupon->value,
            Coupon::TYPE_PERCENTAGE => round($orderAmount * ((float) $coupon->value / 100), 2),
            default => 0,
        };

        if ($coupon->max_discount !== null) {
            $discount = min($discount, (float) $coupon->max_discount);
        }

        return min($discount, $orderAmount);
    }

    private function orderableSubtotal(Cart $cart): float
    {
        $total = 0;
        foreach ($cart->items as $item) {
            $unit = (float) ($item->offer_price ?? $item->price);
            $total += $unit * $item->quantity;
            if ($item->exchange_old_battery) {
                $total -= (float) $item->exchange_discount * $item->quantity;
            }
        }
        return max(0, $total);
    }
}
