<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PaymentActionsController extends Controller
{
    public function bulkDelete(Request $request)
    {
        Payment::find($request->payments)
            ->each(function ($payment) {
                $payment->update(['status' => 'deleted', 'deleted_by' => auth()->id()]);
                $payment->delete();
            });
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PaymentsExport($request->payments), 'payments.xlsx');
    }
}
