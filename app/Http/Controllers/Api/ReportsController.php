<?php

namespace App\Http\Controllers\Api;

use App\Exports\InvoicesExport;
use Carbon\Carbon;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingReportResource;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function __invoke(Request $request)
    {
        $building = Building::with([
            'houses',
            'payments' => fn($query) => $query->approved()->whereDate('month', Carbon::parse($request->month)->startOfMonth()),
            'invoices' => fn($query) => $query->where('month', Carbon::parse($request->month)->startOfMonth()),
        ])
            ->findOrFail($request->building);

        $vacantHousesIds = $building->houses->pluck('id')->diff($building->invoices->pluck('house_id'));

        $building['unpaid_invoices'] = $building->invoices->filter(fn($invoice) => !$invoice->is_paid);

        $building['vacant_houses'] = $building->houses->whereIn('id', $vacantHousesIds);


        return response(new BuildingReportResource($building));
    }

    public function exportUnpaidInvoiceToExcel(Request $request)
    {
        return Excel::download(new InvoicesExport($request->get('invoices')), 'invoices.xlsx');
    }
}
