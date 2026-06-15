<?php

namespace App\Http\Requests\Checkout;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'address_id' => [
                'required',
                'integer',
                Rule::exists('addresses', 'id')->where('user_id', $this->user()->id),
            ],
            'payment_method' => ['required', 'string', Rule::in($this->enabledPaymentMethods())],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** Only payment methods the admin has enabled in Settings. */
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
