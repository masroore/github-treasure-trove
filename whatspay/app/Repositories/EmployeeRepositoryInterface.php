<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByColumnCollection(
        array $where,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Collection;
}
