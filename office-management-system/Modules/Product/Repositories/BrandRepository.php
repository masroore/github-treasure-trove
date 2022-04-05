<?php

namespace Modules\Product\Repositories;

use Importer;
use Modules\Product\Entities\Brand;
use Response;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        return Brand::with('products', 'products.skus')->latest()->get();
    }

    public function serachBased($search_keyword)
    {
        return Brand::whereLike(['name', 'description'], $search_keyword)->get();
    }

    public function create(array $data): void
    {
        $variant = new Brand();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    public function findforReport($id)
    {
        return Brand::where('id', $id)->get();
    }

    public function update(array $data, $id): void
    {
        $variant = Brand::findOrFail($id);
        $variant->update($data);
    }

    public function delete($id)
    {
        return Brand::findOrFail($id)->delete();
    }

    public function csv_upload_brand($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                Brand::create([
                    $column_name[0] => $row[0],
                    $column_name[1] => $row[1],
                    'status' => '1',
                ]);
            }
        }
    }

    public function csv_download()
    {
        $table = Brand::all();
        $filename = 'brands_tbl.csv';
        $handle = fopen($filename, 'w+b');
        fputcsv($handle, ['id', 'name']);

        foreach ($table as $row) {
            fputcsv($handle, [$row['id'], $row['name']]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return Response::download($filename, 'brands_tbl.csv', $headers);
    }
}
