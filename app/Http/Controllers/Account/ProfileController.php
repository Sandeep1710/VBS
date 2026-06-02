<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\PasswordUpdateRequest;
use App\Http\Requests\Account\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('account.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile updated.');
    }

    public function passwordEdit(Request $request): View
    {
        return view('account.profile.password');
    }

    public function passwordUpdate(PasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->forceFill([
            'password' => Hash::make($request->string('password')),
        ])->save();

        return back()->with('success', 'Password changed.');
    }
}
