<?php

namespace App\Services\Notifications;

use App\Contracts\Notifications\WhatsAppGatewayContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Default no-op WhatsApp gateway: logs the message instead of sending.
 * Replace with a real implementation (Meta Cloud API, Gupshup, etc.) by
 * binding the contract in a service provider.
 */
class LogWhatsAppGateway implements WhatsAppGatewayContract
{
    public function send(string $phone, string $message): array
    {
        $id = (string) Str::uuid();
        Log::channel(config('logging.default'))->info('[WhatsApp] would send to ' . $phone, [
            'id' => $id,
            'message' => $message,
        ]);
        return ['success' => true, 'id' => $id];
    }
}
