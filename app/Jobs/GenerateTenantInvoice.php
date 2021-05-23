<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateTenantInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        $this->tenant->invoices()->create([
            'house_id' => $this->tenant->house->id,
            'amount' => $this->tenant->house->rent,
            'balance' => $this->tenant->house->rent,
            'month' => $this->tenant->invoice_from,
        ]);

        $this->tenant->house()->update(['is_occupied' => true]);
    }
}
