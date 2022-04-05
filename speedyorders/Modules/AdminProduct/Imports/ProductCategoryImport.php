<?php

namespace Modules\AdminProduct\Imports;

use App\Models\ProductCategory;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCategoryImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function model(array $row): void
    {
        try {
            ProductCategory::create([
                'product_id' => $row['product_id'],
                'category_id' => $row['category_id'],
            ]);
        } catch (Exception $e) {
            Log::info('Product Category File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
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
