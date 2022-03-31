<?php

namespace Modules\AdminProduct\Imports;

use App\Models\ProductOption;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductOptionImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        try {
            ProductOption::create([
                'id'            => $row['product_option_id'],
                'product_id'    => $row['product_id'],
                'option_id'     => $row['option_id'],
                'required'      => $row['required'],
            ]);
        } catch (Exception $e) {
            Log::info('Product Option File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
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
