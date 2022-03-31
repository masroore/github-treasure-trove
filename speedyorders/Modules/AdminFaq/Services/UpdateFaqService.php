<?php

namespace Modules\AdminFaq\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class UpdateFaqService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            $faq = Faq::find($id);
            $faq->update($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
