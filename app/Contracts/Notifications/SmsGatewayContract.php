<?php

namespace App\Contracts\Notifications;

interface SmsGatewayContract
{
    /**
     * Send an SMS message.
     *
     * @param  string  $phone  E.164 format (e.g. +91XXXXXXXXXX)
     * @param  string  $message
     * @return array{success: bool, id?: string, error?: string}
     */
    public function send(string $phone, string $message): array;
}
