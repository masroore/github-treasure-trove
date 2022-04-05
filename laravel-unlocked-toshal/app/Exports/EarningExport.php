<?php

namespace App\Exports;

use App\Traits\CommonTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EarningExport implements FromCollection, WithHeadings
{
    use CommonTrait;

    public function headings(): array
    {
        return [
            'Id', 'Venue Name', 'Venue Price', 'Created', 'Booking Date', 'Amount($)',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->getEarnings());
    }
}
