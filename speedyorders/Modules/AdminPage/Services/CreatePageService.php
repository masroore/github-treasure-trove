<?php

namespace Modules\AdminPage\Services;

use App\Models\Page;
use Illuminate\Support\Facades\DB;

class CreatePageService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            Page::create($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
