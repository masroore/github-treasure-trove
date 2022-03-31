<?php

namespace Modules\AdminProductOption\Imports;

use App\Models\AttributeValue;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OptionValueImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        try {
            if (1 == $row['language_id']) {
                AttributeValue::create([
                    'id'     => $row['attribute_value_id'],
                    'attributes_id'    => $row['attributes_id'],
                    'name' => $row['name'],
                 ]);
            }
        } catch (Exception $e) {
            Log::info('Attribute Value Description File Import data:' . json_encode($row) . ' error:' . json_encode($e->getMessage()));
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
