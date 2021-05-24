<?php

namespace App\Exports;

use App\Models\House;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HousesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    protected array $houses;

    public
    function __construct(array $houses)
    {
        $this->houses = $houses;
    }

    public function collection()
    {
        return House::with('building', 'tenant')->find($this->houses);
    }

    public function headings(): array
    {
        return [
            'Building',
            'House',
            'Rent',
            'Deposit',
            'Status',
        ];
    }

    public function map($row): array
    {
        return [
            $row->building->name,
            $row->name,
            $row->rent,
            $row->deposit,
            $row->is_occupied ? 'Occupied' : 'Vacant'
        ];
    }
}
