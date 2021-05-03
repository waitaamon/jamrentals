<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PaymentActionsController extends Controller
{
    public function bulkDelete(Request $request)
    {
        Payment::find($request->get('payments'))
            ->each(function ($payment) {
                $payment->update(['status' => 'deleted', 'deleted_by' => auth()->id()]);
                $payment->delete();
            });
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PaymentsExport($request->get('payments')), 'payments.xlsx');
    }
}
