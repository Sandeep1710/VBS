<?php

namespace App\Contracts\Notifications;

interface WhatsAppGatewayContract
{
    /**
     * Send a WhatsApp message.
     *
     * @param  string  $phone  E.164 format (e.g. +91XXXXXXXXXX)
     * @param  string  $message
     * @return array{success: bool, id?: string, error?: string}
     */
    public function send(string $phone, string $message): array;
}
