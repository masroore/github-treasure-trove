<?php

namespace App\Exports;

use App\Traits\CommonTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    use CommonTrait;

    public function headings(): array
    {
        return [
            'Id', 'Firstname', 'Lastname', 'Email', 'Contact', 'Address', 'Zipcode', 'Status', 'Created',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->getUsers());
    }
}
