<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateInvoiceAfterPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        $invoice = Invoice::query()->whereDate('month', $this->payment->month)->firstOrFail();

        if ($this->payment->status == 'reversed') {

            $invoice->update([
                'paid' => $invoice->paid - $this->payment->amount,
                'balance' => $invoice->amount + $this->payment->amount,
            ]);

            return;
        }


        $invoice->update([
            'paid' => $this->payment->amount,
            'balance' => $invoice->amount - $this->payment->amount,
        ]);
    }
}
