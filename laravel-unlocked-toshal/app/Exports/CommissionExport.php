<?php

namespace App\Exports;

use App\Traits\CommonTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommissionExport implements FromCollection, WithHeadings
{
    use CommonTrait;

    public function headings(): array
    {
        return [
            'Id', 'Venue Name', 'Venue Price', 'Created', 'Booking Date', 'Commission($)',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->getCommissions());
    }
}
