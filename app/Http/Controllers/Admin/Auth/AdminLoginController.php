<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function __construct(private readonly AuditLogger $audit)
    {
    }

    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (\Throwable $e) {
            $this->audit->log('admin.login.failed', 'Admin login failed', null, [
                'email_attempted' => $request->input('email'),
            ]);
            throw $e;
        }

        $user = Auth::user();

        if (! $user->isAdmin() || $user->status !== 'active') {
            Auth::logout();
            $this->audit->log('admin.login.denied', 'Non-admin tried to sign into admin panel', $user, [
                'email' => $user->email,
                'is_admin' => $user->isAdmin(),
                'status' => $user->status,
            ]);
            return back()->withErrors(['email' => 'Admin access required.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();

        $this->audit->log('admin.login', 'Admin signed in', $user);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $this->audit->log('admin.logout', 'Admin signed out', $user);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
