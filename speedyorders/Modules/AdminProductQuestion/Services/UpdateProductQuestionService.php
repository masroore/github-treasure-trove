<?php

namespace Modules\AdminProductQuestion\Services;

use App\Models\ProductQuestion;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateProductQuestionService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            $productquestion = ProductQuestion::find($id);
            $productquestion->update($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
