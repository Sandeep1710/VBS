<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'orders_total' => Order::where('user_id', $user->id)->count(),
            'orders_pending' => Order::where('user_id', $user->id)
                ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_CONFIRMED, Order::STATUS_DISPATCHED])
                ->count(),
            'orders_completed' => Order::where('user_id', $user->id)
                ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
                ->count(),
            'addresses' => $user->addresses()->count(),
        ];

        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->limit(5)
            ->get();

        return view('account.dashboard', compact('stats', 'recentOrders'));
    }
}
