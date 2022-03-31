<?php

namespace App\Imports;

use App\Models\Back\Custom\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $i => $item) {
            $search = substr($item['vrijednost_projekta'], 0, strpos($item['vrijednost_projekta'], ' '));
            $amount = str_replace('.', '', $search);
            $amount = str_replace(',', '.', $amount);

            Project::create([
                'name'    => (!empty($item['naziv_projekta'])) ? $item['naziv_projekta'] : 'No Name...',
                'project' => $item['naziv_programa'],
                'carrier' => $item['nositeljpartnerizradivac'],
                'year'    => $item['godina'],
                'value'   => $item['vrijednost_projekta'],
                'amount'  => $amount,
            ]);
        }
    }
}
