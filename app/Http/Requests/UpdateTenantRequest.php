<?php

namespace App\Http\Requests;

class UpdateTenantRequest extends StoreTenantRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => 'required|string|max:254',
        ]);
    }
}
