<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:200'],
            'comment' => ['required', 'string', 'min:10', 'max:5000'],
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ];
    }
}
