<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\Otp\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class OtpLoginController extends Controller
{
    public function __construct(
        private readonly OtpService $otps,
        private readonly CartService $carts,
    ) {
    }

    public function showRequestForm(): View
    {
        return view('auth.otp-request');
    }

    public function sendCode(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:120'],
            'channel' => ['required', 'in:email,sms'],
        ]);

        $isEmail = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL);
        if ($data['channel'] === 'email' && ! $isEmail) {
            return back()->withErrors(['identifier' => 'Enter a valid email address.'])->withInput();
        }
        if ($data['channel'] === 'sms' && ! preg_match('/^\+?\d{8,15}$/', $data['identifier'])) {
            return back()->withErrors(['identifier' => 'Enter a valid phone number.'])->withInput();
        }

        // Resolve user — must exist for login OTP
        $user = $isEmail
            ? User::where('email', $data['identifier'])->first()
            : User::where('phone', ltrim($data['identifier'], '+'))->first();

        if (! $user) {
            return back()->withErrors(['identifier' => 'No account matches that email or phone.'])->withInput();
        }

        try {
            $this->otps->send($data['identifier'], $data['channel'], OtpCode::PURPOSE_LOGIN);
        } catch (RuntimeException $e) {
            return back()->withErrors(['identifier' => $e->getMessage()])->withInput();
        }

        return redirect()->route('otp.verify', ['identifier' => $data['identifier'], 'channel' => $data['channel']])
            ->with('success', 'Verification code sent.');
    }

    public function showVerifyForm(Request $request): View
    {
        return view('auth.otp-verify', [
            'identifier' => $request->query('identifier'),
            'channel' => $request->query('channel', 'email'),
        ]);
    }

    public function verifyAndLogin(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:120'],
            'channel' => ['required', 'in:email,sms'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        if (! $this->otps->verify($data['identifier'], OtpCode::PURPOSE_LOGIN, $data['code'])) {
            return back()->withErrors(['code' => 'Invalid or expired code.'])->withInput();
        }

        $isEmail = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL);
        $user = $isEmail
            ? User::where('email', $data['identifier'])->first()
            : User::where('phone', ltrim($data['identifier'], '+'))->first();

        if (! $user || $user->status !== 'active') {
            return back()->withErrors(['code' => 'Your account is not available.']);
        }

        // OTP success implicitly verifies the channel
        if ($data['channel'] === 'email' && ! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        if ($data['channel'] === 'sms' && ! $user->phone_verified_at) {
            $user->forceFill(['phone_verified_at' => now()])->save();
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();
        $this->carts->mergeGuestCartIntoUser($user->id);

        return redirect()->intended(route('account.dashboard'));
    }
}
