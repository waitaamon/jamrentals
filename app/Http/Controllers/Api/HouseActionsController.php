<?php

namespace App\Http\Controllers\Api;

use App\Models\House;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HouseActionsController extends Controller
{
    public function markVacant(Request $request)
    {
        House::find($request->houses)
            ->each(function ($house) {

                if (!$house->tenant()->exists()) {
                    return;
                }

                $house->tenant()->update(['house_id' => null, 'status' => 'inactive']);

                $house->update(['is_occupied' => false]);
            });
    }
}
