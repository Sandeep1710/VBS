<?php

namespace App\Services\Notifications;

use App\Contracts\Notifications\SmsGatewayContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Default no-op SMS gateway: logs the message instead of sending.
 * Replace with a real implementation (Twilio, MSG91, Gupshup, etc.) by
 * binding the contract in a service provider.
 */
class LogSmsGateway implements SmsGatewayContract
{
    public function send(string $phone, string $message): array
    {
        $id = (string) Str::uuid();
        Log::channel(config('logging.default'))->info('[SMS] would send to ' . $phone, [
            'id' => $id,
            'message' => $message,
        ]);
        return ['success' => true, 'id' => $id];
    }
}
