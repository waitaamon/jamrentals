<?php

namespace App\Http\Controllers;

use App\Models\House;

class HouseController extends Controller
{
    public function index()
    {
        return view('houses.index');
    }

    public function show(int $id)
    {
        $house = House::with('building', 'payments', 'tenant')->findOrFail($id);

        return view('houses.show', compact('house'));
    }
}
