<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'is_admin' => false,
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'phone' => $request->filled('phone') ? $request->string('phone') : null,
            'password' => Hash::make($request->string('password')),
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('account.dashboard')
            ->with('success', 'Welcome to Vehicle Battery Store, ' . $user->name . '!');
    }
}
