<?php

namespace App\Http\Requests;

class UpdateBuildingRequest extends StoreBuildingRequest
{

    public function rules():array
    {
        return array_merge(parent::rules(), [
            'name' => 'required|string|max:254',
        ]);
    }
}
