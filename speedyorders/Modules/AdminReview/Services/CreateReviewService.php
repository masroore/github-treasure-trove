<?php

namespace Modules\AdminReview\Services;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class CreateReviewService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Review::create($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
