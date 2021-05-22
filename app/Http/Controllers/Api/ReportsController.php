<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingReportResource;

class ReportsController extends Controller
{
    public function __invoke(Request $request)
    {
        $building = Building::with([
            'houses',
            'payments' => fn($query) => $query->where('month', Carbon::parse($request->month)),
            'invoices' => fn($query) => $query->where('month', Carbon::parse($request->month)),
        ])
            ->findOrFail($request->building)
            ->map(function ($building) {

                $vacantHousesIds = $building->houses->pluck('id')->diff($building->invoices->pluck('house_id'));

                $building['unpaid_invoices'] = $building->invoices->filter(fn($invoice) => !$invoice->is_paid);

                $building['vacant_houses'] = $building->houses->whereIn('id', $vacantHousesIds);

            return $building;
        });

        return response(new BuildingReportResource($building));
    }
}
