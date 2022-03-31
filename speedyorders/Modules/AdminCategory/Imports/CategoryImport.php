<?php

namespace Modules\AdminCategory\Imports;

use App\Models\Category;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        try {
            Category::create([
                'id'             => $row['category_id'],
                'image'          => $row['image'],
                'category_id'    => $row['parent_id'],
                'sort_order'     => $row['sort_order'],
                'status'         => $row['status'],
                ]);
        } catch (Exception $e) {
            Log::info('Category File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
        }
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
