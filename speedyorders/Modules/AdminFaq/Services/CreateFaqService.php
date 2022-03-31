<?php

namespace Modules\AdminFaq\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class CreateFaqService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Faq::create($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
