<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function show(int $id)
    {
        $tenant = Tenant::withSum('approvedPayments', 'amount')->with('payments')->findOrFail($id);

        return view('tenants.show', compact('tenant'));
    }

    public function payments(int $id)
    {
        $tenant = Tenant::with('approvedPayments')->findOrFail($id);

        return response(PaymentResource::collection($tenant->approvedPayments));
    }
}
