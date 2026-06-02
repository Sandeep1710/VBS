<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends AdminController
{
    public function index(Request $request): View
    {
        $query = User::where('is_admin', false)->withCount('orders');

        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%");
            });
        }

        $customers = $query->latest()->paginate(50)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        abort_if($customer->is_admin, 404);

        $customer->load(['addresses', 'orders' => fn ($q) => $q->latest()->limit(20)]);
        $totalSpent = $customer->orders()
            ->whereIn('status', ['delivered', 'completed'])
            ->sum('total');

        return view('admin.customers.show', compact('customer', 'totalSpent'));
    }
}
