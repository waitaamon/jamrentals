<?php

namespace App\Http\Controllers\Api;

use App\Models\Building;
use Carbon\Carbon;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Resources\{BuildingResource, PaymentCollection, PaymentResource};
use App\Http\Requests\{StorePaymentRequest, UpdatePaymentRequest};

class PaymentsController extends Controller
{

    public function prerequisites()
    {
        $buildings = Building::with(['houses' => fn($query)=> $query->where('is_occupied', true)])->get();

        return response()->json([
            'buildings' => BuildingResource::collection($buildings)
        ]);
    }

    public function index()
    {

        $paymentQuery = request()->get('status') == 'deleted' ? Payment::onlyTrashed() : Payment::query();

        $payments = $paymentQuery
            ->when((request()->get('status') == 'deposit'), fn($query) => $query->where('is_deposit', true))
            ->when((request()->get('status') == 'rent'), fn($query) => $query->where('is_deposit', false))
            ->when(request()->filled('building'), fn($query) => $query->whereHas('house', fn($query) => $query->where('building_id', request()->get('building'))))
            ->when(request()->filled('house'), fn($query) => $query->where('house_id', request()->get('house')))
            ->when(request()->filled('start'), fn($query) => $query->whereDate('month', '>=', Carbon::parse(request()->get('start'))))
            ->when(request()->filled('end'), fn($query) => $query->whereDate('month', '<=', Carbon::parse(request()->get('end'))))
            ->paginate(request()->get('per_page'));

        return response(new PaymentCollection($payments));
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create(array_merge(
            $request->only('amount', 'is_deposit', 'tenant', 'note'),
            [
                'house_id' => $request->house,
                'user_id' => auth()->id(),
                'month' => Carbon::parse($request->month),
                'date_paid' => Carbon::parse($request->date_paid),
            ]
        ));

        return response(new PaymentResource($payment));
    }

    public function show(int $id)
    {
        $payment = Payment::with('house', 'user', 'deletedBy')->findOrFail($id);

        return response(new PaymentResource($payment));
    }

    public function update(UpdatePaymentRequest $request, int $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update(array_merge(
            $request->only('amount', 'is_deposit', 'tenant'),
            [
                'house_id' => $request->house,
                'month' => Carbon::parse($request->month),
                'date_paid' => Carbon::parse($request->date_paid),
            ]
        ));

        $payment->refresh();

        return response(new PaymentResource($payment));
    }

    public function destroy(int $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();
    }
}
