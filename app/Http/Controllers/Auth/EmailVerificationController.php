<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function notice(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user());
        }
        return view('auth.verify-email');
    }

    /**
     * Mark the user's email as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user())->with('success', 'Your email is already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectAfterVerification($request->user())->with('success', 'Your email has been verified.');
    }

    /**
     * Send a new email verification link.
     */
    public function send(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent. Check your email.');
    }

    private function redirectAfterVerification($user): RedirectResponse
    {
        return redirect()->route('account.dashboard');
    }
}
