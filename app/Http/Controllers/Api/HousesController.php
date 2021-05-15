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
        $houses = House::query()
            ->withSum('approvedPayments', 'amount')
            ->when(request()->filled('building'), fn($query) => $query->where('building_id', request()->get('building')))
            ->paginate(request()->get('per_page'));

        return response(new HousesCollection($houses));
    }

    public function store(StoreHouseRequest $request)
    {
        $house = House::create(array_merge(
            $request->only('name', 'rent', 'deposit', 'note'),
            [
                'building_id' => $request->building
            ]
        ));

        return response(new HouseResource($house));
    }

    public function show(int $id)
    {
        $house = House::with('building', 'approvedPayments', 'tenant')->findOrFail($id);

        return response(new HouseResource($house));
    }

    public function update(UpdateHouseRequest $request, int $id)
    {
        $house = House::findOrFail($id);

        $house->update(array_merge(
            $request->only('name', 'rent', 'deposit', 'note'),
            [
                'building_id' => $request->building,
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
