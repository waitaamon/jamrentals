<?php

namespace App\Http\Controllers\Api;

use App\Models\Building;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingResource;
use App\Http\Requests\{StoreBuildingRequest, UpdateBuildingRequest, UpdateHouseRequest};

class BuildingsController extends Controller
{
    public function index()
    {
        $buildings = Building::withCount('houses')->get();

        return response(BuildingResource::collection($buildings));
    }

    public function store(StoreBuildingRequest $request)
    {
        $building = Building::create($request->only('name', 'location', 'default_rent', 'default_deposit'));

        return response(new BuildingResource($building));
    }

    public function show(int $id)
    {
        $building = Building::with('houses')->findOrFail($id);

        return response(new BuildingResource($building));
    }

    public function update(UpdateBuildingRequest $request, int $id)
    {
        $building = Building::findOrFail($id);

        $building->update($request->only('name', 'location', 'default_rent', 'default_deposit'));

        $building->refresh();

        return response(new BuildingResource($building));
    }

    public function destroy(int $id)
    {
        $building = Building::findOrFail($id);

        abort_if($building->payments()->exists(), 403, 'This action is prohibited!');

        $building->delete();
    }
}
