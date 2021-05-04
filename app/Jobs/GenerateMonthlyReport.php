<?php

namespace App\Jobs;

use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateMonthlyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Building::with('vacantHouses', 'invoices')->get()
            ->each(function ($building) {
                $building->monthlyReports()->create([
                    'month' => new Carbon('first day of this month'),
                    'vacant_houses' => json_encode($building->vacantHouses),
                    'debtors' => json_encode()
                ]);
            });
    }
}
