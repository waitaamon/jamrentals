<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PaymentActionsController extends Controller
{
    public function reverse(Request $request)
    {
        Payment::find($request->payments)
            ->each(fn($payment) => $payment->update(['status' => 'reversed', 'reversed_by' => auth()->id()]));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PaymentsExport($request->payments), 'payments.xlsx');
    }
}
