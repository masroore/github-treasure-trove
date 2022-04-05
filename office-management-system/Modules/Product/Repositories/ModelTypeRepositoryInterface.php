<?php

namespace Modules\Product\Repositories;

interface ModelTypeRepositoryInterface
{
    public function all();

    public function serachBased($search_keyword);

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function csv_upload_model_type($data);

    public function csv_download();
}
