<?php

namespace App\Http\Controllers\Api;

use App\Models\House;
use Illuminate\Http\Request;
use App\Exports\HousesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportExcel(Request $request)
    {
        return Excel::download(new HousesExport($request->houses), 'houses.xlsx');
    }
}
