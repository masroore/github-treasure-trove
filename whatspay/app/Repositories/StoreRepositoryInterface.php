<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface StoreRepositoryInterface extends EloquentRepositoryInterface
{
    //public function deleteStores(array $where, int $user_id): ?bool;
    /**
     * Find model by column.
     *
     * @return Collection
     */
    public function findByMultipleColumns(
        string $column,
        array $whereIn,
        array $where,
        array $columns = ['*']
    ): ?Collection;

    /**
     * Delete model by column.
     *
     * @param array $column
     */
    public function deleteMultipleByColumn(string $column, array $where): bool;
}
