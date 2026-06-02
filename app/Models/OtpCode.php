<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    public const PURPOSE_LOGIN = 'login';
    public const PURPOSE_REGISTER = 'register';
    public const PURPOSE_PASSWORD_RESET = 'password_reset';
    public const PURPOSE_PHONE_VERIFY = 'phone_verify';
    public const PURPOSE_EMAIL_VERIFY = 'email_verify';
    public const PURPOSE_ORDER_INSTALL = 'order_install';

    public const MAX_ATTEMPTS = 5;

    protected $fillable = [
        'identifier', 'channel', 'code_hash', 'purpose',
        'attempts', 'expires_at', 'consumed_at',
        'ip', 'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
        'attempts' => 'integer',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isConsumed(): bool
    {
        return $this->consumed_at !== null;
    }

    public function isUsable(): bool
    {
        return ! $this->isExpired()
            && ! $this->isConsumed()
            && $this->attempts < self::MAX_ATTEMPTS;
    }
}
