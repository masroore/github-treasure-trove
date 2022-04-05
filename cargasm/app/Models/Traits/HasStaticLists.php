<?php

namespace App\Models\Traits;

trait HasStaticLists
{
    protected static function staticListBuild(
        array $records = [],
        ?string $columnKey = null,
        ?string $indexKey = null
    ): array {
        if ($indexKey && $columnKey) {
            return array_column($records, $columnKey, $indexKey);
        } elseif ($columnKey) {
            return array_column($records, $columnKey);
        }

        return $records;
    }
}
