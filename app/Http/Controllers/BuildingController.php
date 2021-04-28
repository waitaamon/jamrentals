<?php

namespace App\Http\Controllers;

use App\Models\Building;

class BuildingController extends Controller
{
    public function index()
    {
        return view('buildings.index');
    }

    public function show(int $id)
    {
        $building = Building::query()
            ->with('houses')
            ->withCount(['houses', 'OccupiedHouses', 'vacantHouses'])
            ->findOrFail($id);

        return view('buildings.show', compact('building'));
    }
}
