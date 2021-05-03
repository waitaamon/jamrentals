<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;

class HouseActionsController extends Controller
{
    public function markVacant(Request $request)
    {
        House::find($request->houses)
            ->each(fn($house) => $house->update([
                'tenant' => '',
                'tenant_phone' => '',
                'tenant_id' => '',
                'is_occupied' => false
            ]));
    }
}
