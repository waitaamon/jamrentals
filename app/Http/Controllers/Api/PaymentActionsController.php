<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UpdateInvoiceAfterPayment;

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

                UpdateInvoiceAfterPayment::dispatchSync($payment);

            });
    }

    public function printReceipt(int $id)
    {
        $payment = Payment::findOrFail($id);

        abort_if($payment->status == 'reversed', 406, 'Reversed payment is locked and cannot be printed.');

        //calculate tenant balance
        $payment['balance'] = ($payment->tenant->invoices()->sum('amount') - $payment->tenant->payments()->approved()->sum('amount'));

        $pdf = app('dompdf.wrapper')->setOptions(['defaultMediaType' => 'print'])->loadView('print.payment-receipt', ['payment' => $payment])->output();

        $name = 'exports/'. Str::slug($payment->code) . '.pdf';

        // Get our disk to store the PDF in.
        $disk = Storage::disk('public');

        // Save the file with the PDF output.
        $disk->put($name, $pdf);

        return response(chunk_split(base64_encode(file_get_contents($disk->path($name)))));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PaymentsExport($request->get('payments')), 'payments.xlsx');
    }
}
