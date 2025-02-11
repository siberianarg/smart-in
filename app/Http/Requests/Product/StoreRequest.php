<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest

{
    public function rules(): array
    {
        return [
            'description'  => 'required|string|max:255',
            'is_completed' => 'nullable|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
