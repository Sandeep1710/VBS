<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\Otp\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class OtpController extends Controller
{
    public function __construct(private readonly OtpService $otps)
    {
    }

    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:120'],
            'channel' => ['required', 'in:email,sms'],
        ]);

        $isEmail = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL);
        $user = $isEmail
            ? User::where('email', $data['identifier'])->first()
            : User::where('phone', ltrim($data['identifier'], '+'))->first();

        if (! $user) {
            return response()->json(['message' => 'No account matches that identifier.'], 404);
        }

        try {
            $this->otps->send($data['identifier'], $data['channel'], OtpCode::PURPOSE_LOGIN);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 429);
        }

        return response()->json(['message' => 'OTP sent.', 'expires_in' => OtpService::TTL_MINUTES * 60]);
    }

    public function verify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'size:6'],
            'device_name' => ['nullable', 'string', 'max:120'],
        ]);

        if (! $this->otps->verify($data['identifier'], OtpCode::PURPOSE_LOGIN, $data['code'])) {
            return response()->json(['message' => 'Invalid or expired code.'], 422);
        }

        $isEmail = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL);
        $user = $isEmail
            ? User::where('email', $data['identifier'])->first()
            : User::where('phone', ltrim($data['identifier'], '+'))->first();

        if (! $user || $user->status !== 'active') {
            return response()->json(['message' => 'Account not available.'], 403);
        }

        if ($isEmail && ! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        if (! $isEmail && ! $user->phone_verified_at) {
            $user->forceFill(['phone_verified_at' => now()])->save();
        }

        $user->forceFill(['last_login_at' => now()])->save();
        $token = $user->createToken($data['device_name'] ?? 'mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user->load('role')),
        ]);
    }
}
