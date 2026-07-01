<?php

namespace App\Services\Otp;

use App\Contracts\Notifications\SmsGatewayContract;
use App\Models\OtpCode;
use App\Notifications\OtpCodeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class OtpService
{
    public const TTL_MINUTES = 10;
    public const RESEND_COOLDOWN_SECONDS = 60;

    public function __construct(private readonly SmsGatewayContract $sms)
    {
    }

    /**
     * Generate and send a fresh OTP. Invalidates any prior unused OTPs for the same identifier+purpose.
     */
    public function send(string $identifier, string $channel, string $purpose): OtpCode
    {
        $this->throwIfTooSoon($identifier, $purpose);

        // Invalidate prior unused codes
        OtpCode::where('identifier', $identifier)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->update(['consumed_at' => now()]);

        $code = (string) random_int(100000, 999999);
        $otp = OtpCode::create([
            'identifier' => $identifier,
            'channel' => $channel,
            'code_hash' => Hash::make($code),
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes(self::TTL_MINUTES),
            'ip' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 255),
        ]);

        $this->dispatch($otp, $code);

        return $otp;
    }

    public function verify(string $identifier, string $purpose, string $submittedCode): bool
    {
        $otp = OtpCode::where('identifier', $identifier)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->latest()
            ->first();

        if (! $otp || ! $otp->isUsable()) {
            return false;
        }

        $otp->increment('attempts');

        if (! Hash::check($submittedCode, $otp->code_hash)) {
            return false;
        }

        $otp->update(['consumed_at' => now()]);
        return true;
    }

    private function throwIfTooSoon(string $identifier, string $purpose): void
    {
        $last = OtpCode::where('identifier', $identifier)
            ->where('purpose', $purpose)
            ->latest()
            ->first();

        if ($last && $last->created_at->diffInSeconds(now()) < self::RESEND_COOLDOWN_SECONDS) {
            $wait = self::RESEND_COOLDOWN_SECONDS - $last->created_at->diffInSeconds(now());
            throw new \RuntimeException("Please wait {$wait}s before requesting another code.");
        }
    }

    private function dispatch(OtpCode $otp, string $plainCode): void
    {
        $message = "Your Trikuti Battery code is {$plainCode}. Valid for "
            . self::TTL_MINUTES . " minutes. Don't share this code.";

        if ($otp->channel === 'email') {
            // Send via Laravel mail to anonymous notifiable
            Notification::route('mail', $otp->identifier)
                ->notify(new OtpCodeNotification($plainCode, $otp->purpose));
            return;
        }

        // SMS channel uses the configured gateway (log-only by default)
        $this->sms->send($otp->identifier, $message);
    }
}
