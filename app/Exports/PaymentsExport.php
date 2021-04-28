<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{

    protected array $payments;

    public function __construct(array $payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        return Payment::with('house', 'user', 'house.building')->find($this->payments);
    }

    public function headings(): array
    {
        return [
            'Building',
            'House',
            'Tenant',
            'Amount',
            'Deposit',
            'Month',
            'Date Paid',
            'Status',
            'Posted By',
            'Date Posted',
        ];
    }

    public function map($row): array
    {
        return [
            $row->house->building->name,
            $row->house->name,
            $row->tenant,
            $row->amount,
            (bool)$row->is_deposit,
            $row->month->format('M-Y'),
            $row->date_paid->format('d-M-Y'),
            $row->status,
            $row->user->name,
            $row->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
