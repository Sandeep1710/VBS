<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use RuntimeException;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
        private readonly CheckoutService $checkout,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->latest()
            ->paginate((int) $request->integer('per_page', 10));

        return OrderResource::collection($orders);
    }

    public function show(Request $request, Order $order): OrderResource
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load(['items', 'statusLogs.changedBy', 'latestPayment']);
        return new OrderResource($order);
    }

    public function store(Request $request): JsonResponse
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Please verify your email before placing orders.'], 403);
        }

        $data = $request->validate([
            'address_id' => [
                'required', 'integer',
                Rule::exists('addresses', 'id')->where('user_id', $request->user()->id),
            ],
            'payment_method' => ['required', 'string', Rule::in(['cod', 'upi', 'card'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $this->cart->find();
        if (! $cart || $cart->items()->count() === 0) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        try {
            $order = $this->checkout->placeOrder($request->user(), $cart, $data);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        Notification::send($order->user, new OrderPlacedNotification($order));

        $order->load(['items']);
        return response()->json(['data' => new OrderResource($order)], 201);
    }

    public function cancel(Request $request, Order $order): JsonResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if (! $order->isCancellable()) {
            return response()->json(['message' => 'This order can no longer be cancelled.'], 422);
        }

        $reason = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ])['reason'] ?? null;

        DB::transaction(function () use ($order, $request, $reason) {
            $previous = $order->status;

            $order->forceFill([
                'status' => Order::STATUS_CANCELLED,
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ])->save();

            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->update(['stock_quantity' => DB::raw('stock_quantity + ' . (int) $item->quantity)]);
                }
            }

            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => $previous,
                'to_status' => Order::STATUS_CANCELLED,
                'comment' => $reason ?: 'Cancelled by customer.',
                'changed_by' => $request->user()->id,
                'source' => 'customer',
            ]);
        });

        $order->load(['items']);
        return response()->json(['data' => new OrderResource($order)]);
    }
}
