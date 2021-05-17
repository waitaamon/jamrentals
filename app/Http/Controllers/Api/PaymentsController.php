<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\{House, Building, Payment};
use App\Http\Requests\{StorePaymentRequest, UpdatePaymentRequest};
use App\Http\Resources\{BuildingResource, PaymentCollection, PaymentResource};

class PaymentsController extends Controller
{

    public function prerequisites()
    {
        $buildings = Building::with(['houses' => fn($query) => $query->where('is_occupied', true)])->get();

        return response()->json([
            'buildings' => BuildingResource::collection($buildings)
        ]);
    }

    public function index()
    {

        $payments = Payment::query()
            ->when(request()->filled('building'), fn($query) => $query->whereHas('house', fn($query) => $query->where('building_id', request()->get('building'))))
            ->when(request()->filled('house'), fn($query) => $query->where('house_id', request()->get('house')))
            ->when(request()->filled('tenant'), fn($query) => $query->where('tenant_id', request()->get('tenant')))
            ->when(request()->filled('status'), fn($query) => $query->where('status', request()->get('status')))
            ->when(request()->filled('start'), fn($query) => $query->whereDate('month', '>=', Carbon::parse(request()->get('start'))))
            ->when(request()->filled('end'), fn($query) => $query->whereDate('month', '<=', Carbon::parse(request()->get('end'))))
            ->paginate(request()->get('per_page'));

        return response(new PaymentCollection($payments));
    }

    public function store(StorePaymentRequest $request)
    {
        $house = House::find($request->get('house'));

        $payment = $house->payments()->create(array_merge(
            $request->only('amount', 'note'),
            [
                'tenant_id' => $house->tenant->id,
                'user_id' => auth()->id(),
                'month' => Carbon::parse($request->get('month')),
                'date_paid' => Carbon::parse($request->get('date_paid')),
            ]
        ));

        return response(new PaymentResource($payment));
    }

    public function show(int $id)
    {
        $payment = Payment::with('house', 'user', 'reversedBy')->findOrFail($id);

        return response(new PaymentResource($payment));
    }

    public function update(UpdatePaymentRequest $request, int $id)
    {
        abort('403', 'You are not authorized to perform this action');
    }

    public function destroy(int $id)
    {
        abort('403', 'You are not authorized to perform this action');
    }
}
