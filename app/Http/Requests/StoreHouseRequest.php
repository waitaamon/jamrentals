<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building' => 'required|integer|exists:buildings,id',
            'name' => 'required|string|max:254|unique:houses,name',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
        ];
    }
}
