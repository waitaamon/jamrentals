<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PaymentActionsController extends Controller
{
    public function reverse(Request $request)
    {
        Payment::find($request->get('payments'))
            ->each(function ($payment) {
                $payment->update([
                    'status' => 'reversed',
                    'reversed_by' => auth()->id(),
                    'reversed_on' => now(),
                    'note' => ''
                ]);
            });
    }

    public function printReceipt(int $id)
    {

    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PaymentsExport($request->get('payments')), 'payments.xlsx');
    }
}
