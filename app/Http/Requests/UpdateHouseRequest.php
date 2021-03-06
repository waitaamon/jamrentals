<?php

namespace App\Http\Requests;

class UpdateHouseRequest extends StoreHouseRequest
{

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => 'required|string|max:254',
        ]);
    }
}
