<?php

namespace Modules\AdminFaq\Imports;

use App\Models\FaqCategory;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FaqCategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @return null|User
     */
    public function model(array $row)
    {
        if (\count($row) > 3) {
            return new FaqCategory([
                'name' => $row['name'],
                'meta_tag' => $row['meta_tag'],
                'sort_order' => $row['sort_order'],
                'status' => $row['status'],
            ]);
        }
    }
}
