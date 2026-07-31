<?php

namespace App\Http\Requests\Checkout;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // LEAD-GEN MODE: anyone can submit a lead.
        // Original auth-gated rule (uncomment to re-enable): return $this->user() !== null;
        return true;
    }

    public function rules(): array
    {
        // LEAD-GEN MODE: minimal lead capture form.
        // Full address / payment method is collected by admin over phone.
        return [
            'name'    => ['required', 'string', 'max:120'],
            'phone'   => ['required', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:180'],
            'pincode' => ['required', 'string', 'regex:/^\d{6}$/'],
            'notes'   => ['nullable', 'string', 'max:1000'],
        ];

        /*
        // Original auth-required rules — restore when re-enabling customer accounts.
        return [
            'address_id' => [
                'required',
                'integer',
                Rule::exists('addresses', 'id')->where('user_id', $this->user()->id),
            ],
            'payment_method' => ['required', 'string', Rule::in($this->enabledPaymentMethods())],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
        */
    }

    /** Only payment methods the admin has enabled in Settings. Kept for re-enable path. */
    private function enabledPaymentMethods(): array
    {
        return collect([
            'cod' => Setting::get('cod_enabled', false, 'payment'),
            'upi' => Setting::get('upi_enabled', false, 'payment'),
            'card' => Setting::get('card_enabled', false, 'payment'),
        ])
            ->filter(fn ($enabled) => (bool) $enabled)
            ->keys()
            ->all();
    }
}
