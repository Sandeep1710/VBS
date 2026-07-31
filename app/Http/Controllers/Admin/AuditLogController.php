<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = AuditLog::query()
            ->with('user:id,name,email,is_admin')
            ->when($request->filled('event'), fn ($q) => $q->where('event', 'like', '%' . $request->input('event') . '%'))
            ->when($request->filled('ip'), fn ($q) => $q->where('ip_address', $request->input('ip')))
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->input('user_id')))
            ->when($request->filled('from'), fn ($q) => $q->where('created_at', '>=', $request->input('from')))
            ->when($request->filled('to'), fn ($q) => $q->where('created_at', '<=', $request->input('to') . ' 23:59:59'))
            ->latest('id')
            ->paginate(50)
            ->withQueryString();

        return view('admin.audit-logs.index', compact('logs'));
    }
}
