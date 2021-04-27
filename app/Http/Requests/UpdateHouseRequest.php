<?php

namespace App\Http\Requests;

class UpdateHouseRequest extends StoreHouseRequest
{

    public function rules(): array
    {
        return parent::rules();
    }
}
