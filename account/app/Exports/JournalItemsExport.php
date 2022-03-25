<?php

namespace App\Exports;

use App\JournalItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class JournalItemsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return JournalItem::all();
    }
}
