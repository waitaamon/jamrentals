<?php

namespace App\Http\Controllers\Api;

use App\Models\House;
use App\Http\Controllers\Controller;
use App\Http\Resources\{HouseResource, HousesCollection};
use App\Http\Requests\{StoreHouseRequest, UpdateHouseRequest};

class HousesController extends Controller
{
    public function index()
    {
        $houses = House::withSum('approvedPayments', 'amount')->get();

        return response(new HousesCollection($houses));
    }

    public function store(StoreHouseRequest $request)
    {
        $house = House::create(array_merge(
            $request->only('name', 'rent', 'deposit', 'tenant', 'tenant_phone', 'tenant_id'),
            [
                'building_id' => $request->building,
                'is_occupied' => $request->filled('tenant')
            ]
        ));

        return response(new HouseResource($house));
    }

    public function show(int $id)
    {
        $house = House::with('building', 'approvedPayments')->findOrFail($id);

        return response(new HouseResource($house));
    }

    public function update(UpdateHouseRequest $request, int $id)
    {
        $house = House::findOrFail($id);

        $house->update(array_merge(
            $request->only('name', 'rent', 'deposit', 'tenant', 'tenant_phone', 'tenant_id'),
            [
                'building_id' => $request->building,
                'is_occupied' => $request->filled('tenant')
            ]
        ));

        $house->refresh();

        return response(new HouseResource($house));
    }

    public function destroy(int $id)
    {
        $house = House::findOrFail($id);

        abort_if($house->payments()->exists(), 403, 'This action is prohibited!');

        $house->delete();
    }
}