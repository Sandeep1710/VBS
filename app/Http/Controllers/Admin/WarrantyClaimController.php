<?php

namespace App\Http\Controllers\Admin;

use App\Models\WarrantyClaim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WarrantyClaimController extends AdminController
{
    public function index(Request $request): View
    {
        $query = WarrantyClaim::with('order', 'user', 'orderItem')->latest();
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        $claims = $query->paginate(30)->withQueryString();
        return view('admin.warranty-claims.index', [
            'claims' => $claims,
            'statuses' => [WarrantyClaim::STATUS_SUBMITTED, WarrantyClaim::STATUS_UNDER_REVIEW, WarrantyClaim::STATUS_APPROVED, WarrantyClaim::STATUS_REJECTED, WarrantyClaim::STATUS_RESOLVED],
            'resolutions' => WarrantyClaim::RESOLUTIONS,
        ]);
    }

    public function update(Request $request, WarrantyClaim $claim): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([WarrantyClaim::STATUS_SUBMITTED, WarrantyClaim::STATUS_UNDER_REVIEW, WarrantyClaim::STATUS_APPROVED, WarrantyClaim::STATUS_REJECTED, WarrantyClaim::STATUS_RESOLVED])],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'resolution' => ['nullable', Rule::in(array_keys(WarrantyClaim::RESOLUTIONS))],
        ]);

        $updates = [
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? $claim->admin_notes,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ];

        if ($data['status'] === WarrantyClaim::STATUS_RESOLVED) {
            $updates['resolved_at'] = now();
            if (! empty($data['resolution'])) {
                $updates['resolution'] = $data['resolution'];
            }
        }

        $claim->update($updates);
        return back()->with('success', 'Claim updated.');
    }
}
