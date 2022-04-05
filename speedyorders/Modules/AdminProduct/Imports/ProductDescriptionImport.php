<?php

namespace Modules\AdminProduct\Imports;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductDescriptionImport implements ShouldQueue, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function model(array $row): void
    {
        try {
            $product = Product::where('id', $row['product_id'])->first();
            if ($product) {
                $product->update([
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                ]);
            }
        } catch (Exception $e) {
            Log::info('Product Description File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
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
