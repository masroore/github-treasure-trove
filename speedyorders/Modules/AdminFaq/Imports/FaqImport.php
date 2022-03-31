<?php

namespace Modules\AdminFaq\Imports;

use App\Models\Faq;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FaqImport implements ToModel, WithHeadingRow
{
    /**
     * @return User|null
     */
    public function model(array $row)
    {
        if (\count($row) > 0) {
            return new Faq([
                'faq_category_id'=> $row['faq_category_id'],
                'question'    => $row['question'],
                'answer' => $row['answer'],
                'sort_order' => $row['sort_order'],
                'status' => $row['status'],
             ]);
        }
    }
}
