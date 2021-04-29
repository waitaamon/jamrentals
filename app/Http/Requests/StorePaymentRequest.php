<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'house' => 'required|integer|exists:houses,id',
            'amount' => 'required|numeric|min:0',
            'tenant' => 'required|string|max:254',
            'is_deposit' => 'required|boolean',
            'month' => 'required|date',
            'date_paid' => 'required|date',
            'note' => 'nullable|string|max:500'
        ];
    }
}
