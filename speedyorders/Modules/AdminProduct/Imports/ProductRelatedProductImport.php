<?php

namespace Modules\AdminProduct\Imports;

use App\Models\ProductRelatedProduct;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductRelatedProductImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function model(array $row): void
    {
        try {
            ProductRelatedProduct::create([
                'product_id' => $row['product_id'],
                'related_product_id' => $row['related_id'],
            ]);
        } catch (Exception $e) {
            Log::info('Product Related Product File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
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
