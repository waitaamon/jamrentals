<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    protected array $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return Invoice::with('house', 'tenant', 'house.building')->find($this->invoices);
    }

    public function headings(): array
    {
        return [
            'Building',
            'House',
            'Tenant',
            'Amount',
            'Paid',
            'Balance',
            'Month',
        ];
    }

    public function map($row): array
    {
        return [
            $row->house->building->name,
            $row->house->name,
            $row->tenant->name,
            $row->amount,
            $row->paid,
            $row->balance,
            $row->month->format('M-Y'),
        ];
    }
}
