<?php

namespace App\Services\Interfaces\Pivot;

interface PivotServiceInterfaces
{
    public function attach(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, int $value2);
    public function detach(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, int $value2);
    public function sync(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, array $values2);
}
