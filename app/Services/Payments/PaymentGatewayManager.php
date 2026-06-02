<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentGatewayContract;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /** @var array<string, class-string<PaymentGatewayContract>> */
    private array $registry = [];

    public function __construct(private readonly Application $app)
    {
    }

    /**
     * @param  class-string<PaymentGatewayContract>  $class
     */
    public function register(string $name, string $class): void
    {
        $this->registry[$name] = $class;
    }

    public function get(string $name): PaymentGatewayContract
    {
        if (! isset($this->registry[$name])) {
            throw new InvalidArgumentException("Payment gateway [{$name}] is not registered.");
        }
        return $this->app->make($this->registry[$name]);
    }

    /**
     * @return array<string>
     */
    public function available(): array
    {
        return array_keys($this->registry);
    }
}
