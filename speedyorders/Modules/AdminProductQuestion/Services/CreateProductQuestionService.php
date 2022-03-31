<?php

namespace Modules\AdminProductQuestion\Services;

use App\Models\ProductQuestion;
use Illuminate\Support\Facades\DB;

class CreateProductQuestionService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            ProductQuestion::create($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
