<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => ['nullable', 'string', 'max:40'],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'line1' => ['required', 'string', 'max:180'],
            'line2' => ['nullable', 'string', 'max:180'],
            'landmark' => ['nullable', 'string', 'max:180'],
            'city' => ['required', 'string', 'max:80'],
            'state' => ['required', 'string', 'max:80'],
            'pincode' => ['required', 'string', 'max:10', 'regex:/^[0-9]{4,10}$/'],
            'country' => ['nullable', 'string', 'max:80'],
            'is_default' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'pincode.regex' => 'Please enter a valid pincode.',
        ];
    }
}
