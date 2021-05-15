<?php

namespace App\Http\Controllers\Api;

use App\Models\{House, Tenant};
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Http\Requests\{StoreTenantRequest, UpdateTenantRequest};

class TenantsController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();

        return response(TenantResource::collection($tenants));
    }

    public function store(StoreTenantRequest $request)
    {
        $house = House::find($request->get('house'));

        abort_if($house->is_occupied, 405, 'The selected house is not vacant.');

        $house->tenant()->create($request->only('name', 'id_number', 'phone', 'deposit', 'incurred_cost', 'note'));

    }

    public function show(int $id)
    {
        $tenant = Tenant::with('invoices', 'payments', 'house')->findOrFail($id);

        return response(new TenantResource($tenant));
    }

    public function update(UpdateTenantRequest $request, int $id)
    {
        $tenant = Tenant::findOrFail($id);

        $house = House::find($request->get('house'));

        abort_if( $tenant->house_id != $house->id && $house->is_occupied, 405, 'The selected house is not vacant.');

        $tenant->update(array_merge(
            $request->only('name', 'id_number', 'phone', 'deposit', 'incurred_cost', 'note'),
            [
                'house_id' => $house->id
            ]
        ));
    }

    public function destroy(int $id)
    {
        $tenant = Tenant::findOrFail($id);

        abort_if($tenant->hasBalance(), 405, 'This tenant has balance and cannot be deleted.');

        $tenant->delete();
    }
}
