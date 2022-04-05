<?php

namespace Modules\Quotation\Repositories;

interface QuotationRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function findToConvert($id);

    public function cloneQuotation($id);

    public function statusChange($id);

    public function update(array $data, $id);

    public function delete($id);
}
