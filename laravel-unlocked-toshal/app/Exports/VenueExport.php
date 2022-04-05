<?php

namespace App\Exports;

use App\Traits\CommonTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VenueExport implements FromCollection, WithHeadings
{
    use CommonTrait;

    public function headings(): array
    {
        return [
            'Id', 'Owner Name', 'Name', 'Location', 'Contact', 'Building Type', 'Amenities Detail', 'Other Information', 'Total Room', 'Booking Price', 'Status', 'Is Featured', 'Created',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->getVenues());
    }
}
