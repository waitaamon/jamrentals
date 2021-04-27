<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:254|unique:buildings',
            'location' => 'nullable|string|max:254',
            'default_rent' => 'nullable|numeric|min:0',
            'default_deposit' => 'nullable|numeric|min:0',
        ];
    }
}
