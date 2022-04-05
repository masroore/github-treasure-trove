<?php

namespace Modules\Product\Repositories;

use Importer;
use Modules\Product\Entities\ModelType;
use Response;

class ModelTypeRepository implements ModelTypeRepositoryInterface
{
    public function all()
    {
        return ModelType::orderBy('id', 'DESC')->get();
    }

    public function serachBased($search_keyword)
    {
        return ModelType::whereLike(['name', 'description'], $search_keyword)->get();
    }

    public function create(array $data): void
    {
        $variant = new ModelType();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return ModelType::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $variant = ModelType::findOrFail($id);
        $variant->update($data);
    }

    public function delete($id)
    {
        return ModelType::findOrFail($id)->delete();
    }

    public function csv_upload_model_type($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                ModelType::create([
                    $column_name[0] => $row[0],
                    $column_name[1] => $row[1],
                    'status' => '1',
                ]);
            }
        }
    }

    public function csv_download()
    {
        $table = ModelType::all();
        $filename = 'models.csv';
        $handle = fopen($filename, 'w+b');
        fputcsv($handle, ['id', 'name']);

        foreach ($table as $row) {
            fputcsv($handle, [$row['id'], $row['name']]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return Response::download($filename, 'models.csv', $headers);
    }
}
