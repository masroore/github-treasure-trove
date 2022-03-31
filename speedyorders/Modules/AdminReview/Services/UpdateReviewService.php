<?php

namespace Modules\AdminReview\Services;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class UpdateReviewService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            $review = Review::findOrFail($id);
            $review->update($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
