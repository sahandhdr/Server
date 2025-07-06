<?php

namespace App\Services\Pivot;

use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use App\Traits\v1\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PivotService implements PivotServiceInterfaces
{
    use ApiResponser;
    public function attach(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, int $value2)
    {
        if (!DB::table($table)->where('id', $value1)->exists()) {
            return $this->errorResponse(Str::singular($table) . '-notFound', 404);
        }

        if (!DB::table($relatedTable)->where('id', $value2)->exists()) {
            return $this->errorResponse(Str::singular($relatedTable) . '-notFound', 404);
        }

        if (DB::table($pivotTable)->where([$foreignPivotKey => $value1, $relatedPivotKey => $value2])->exists()) {
            return $this->errorResponse(Str::singular($table) . '-has-' . Str::singular($relatedTable), 400);
        }

        if (DB::table($pivotTable)->insert([$foreignPivotKey => $value1, $relatedPivotKey => $value2])) {
            return $this->successResponse(null, 200, 'successfully-attached');
        }

        return $this->errorResponse('attach-failed', 500);
    }

    public function detach(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, int $value2)
    {
        if (!DB::table($table)->where('id', $value1)->exists()) {
            return $this->errorResponse(Str::singular($table) . '-notFound', 404);
        }

        if (!DB::table($relatedTable)->where('id', $value2)->exists()) {
            return $this->errorResponse(Str::singular($relatedTable) . '-notFound', 404);
        }

        if (!DB::table($pivotTable)->where([$foreignPivotKey => $value1, $relatedPivotKey => $value2])->exists()) {
            return $this->errorResponse(Str::singular($table) . '-' . Str::singular($relatedTable) . '-notFound', 404);
        }

        if (DB::table($pivotTable)->where([$foreignPivotKey => $value1, $relatedPivotKey => $value2])->delete() > 0) {
            return $this->successResponse(null, 200, 'successfully-detached');
        }

        return $this->errorResponse('detach-failed', 500);
    }

    public function sync(string $table, string $relatedTable, string $pivotTable, string $foreignPivotKey, string $relatedPivotKey, int $value1, array $values2)
    {
        if (!DB::table($table)->where('id', $value1)->exists()) {
            return $this->errorResponse(Str::singular($table) . '-notFound', 404);
        }

        DB::beginTransaction();

        DB::table($pivotTable)->where($foreignPivotKey, $value1)->delete();

        $counter = 0;

        foreach ($values2 as $value2) {
            if (!DB::table($relatedTable)->where('id', $value2)->exists()) {
                DB::rollBack();
                return $this->errorResponse(Str::singular($relatedTable) . '-notFound', 404);
            }

            if (!DB::table($pivotTable)->insert([$foreignPivotKey => $value1, $relatedPivotKey => $value2])) {
                DB::rollBack();
                return $this->errorResponse('insert-' . Str::singular($relatedTable) . '-failed', 500);
            }

            $counter++;
        }

        if ($counter === count($values2)) {
            DB::commit();
            return $this->successResponse(null, 200, 'successfully-sync');
        }

        DB::rollBack();
        return $this->errorResponse('sync-failed', 500);
    }
}
