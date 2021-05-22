<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'house' => 'required|integer|exists:houses,id',
            'name' => 'required|string|max:254|unique:tenants',
            'id_number' => 'nullable|string|max:254',
            'phone' => 'nullable|string|max:254',
            'deposit' => 'required|numeric|min:0',
            'note' => 'nullable|string|',
            'invoice_from' => 'required|date'
        ];
    }
}
