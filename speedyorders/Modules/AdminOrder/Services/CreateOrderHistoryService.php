<?php

namespace Modules\AdminOrder\Services;

use App\Models\OrderHistory;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateOrderHistoryService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            OrderHistory::create($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
