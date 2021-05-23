<?php

namespace App\Http\Controllers;

use App\Models\Tenant;

class TenantController extends Controller
{
    public function show(int $id)
    {
        $tenant = Tenant::withSum('approvedPayments', 'amount')->with('payments')->findOrFail($id);

        return view('tenants.show', compact('tenant'));
    }
}
