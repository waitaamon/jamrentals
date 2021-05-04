<?php

namespace App\Jobs;

use App\Models\House;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateMonthlyInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        House::all()
            ->each(function ($house) {

                $month = new Carbon('first day of this month');

                $payment = $house->payments()->whereDate('month', $month)->first();

                $house->invoices()->create([
                    'tenant' => $house->tenant ?: '',
                    'amount' => $house->tenant ? $house->rent : 0,
                    'paid' => $payment ? $payment->amount : 0,
                    'month' => $month,
                ]);
            });
    }
}
