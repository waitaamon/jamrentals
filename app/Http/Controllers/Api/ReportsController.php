<?php

namespace App\Http\Controllers\Api;

use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function __invoke(Request $request)
    {
        return $building = Building::with(['monthlyReports' => function ($query) use ($request) {
            $query->where('month', $request->month);
        }])->findOrFail($request->building);

    }
}
