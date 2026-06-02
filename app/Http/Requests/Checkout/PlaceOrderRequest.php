<?php

namespace App\Http\Requests\Checkout;

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
            'payment_method' => ['required', 'string', Rule::in(['cod', 'upi', 'card'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
