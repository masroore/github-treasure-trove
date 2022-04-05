<?php

namespace Modules\Account\Repositories;

interface AccountCategoryRepositoryInterface
{
    public function all();

    public function create(array $data);
}
