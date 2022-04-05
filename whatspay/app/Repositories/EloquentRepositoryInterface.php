<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Get all models.
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all trashed models.
     */
    public function allTrashed(): Collection;

    /**
     * Find model by id.
     *
     * @return Model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * Find all by column.
     *
     * @return Collection
     */
    public function findAllByColumn(
        array $where,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Collection;

    /**
     * Search by keyword.
     *
     * @return Collection
     */
    public function findByKeyword(
        string $column,
        string $keyword,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Collection;

    /**
     * Find trashed model by id.
     *
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model;

    /**
     * Create a model.
     *
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     */
    public function update(int $modelId, array $payload): bool;

    /**
     * Update model by column name.
     */
    public function updateByColumn(array $where, array $payload): bool;

    public function updateGetModel(array $where, array $payload): ?Model;

    /**
     * Update multiple row at once.
     *
     * @return null|bool
     */
    public function updateMultiple(string $column, array $where, array $payload): bool;

    /**
     * Delete model by id.
     */
    public function deleteById(int $modelId): bool;

    /**
     * Restore model by id.
     */
    public function restoreById(int $modelId): bool;

    /**
     * Permanently delete model by id.
     */
    public function permanentlyDeleteById(int $modelId): bool;
}
