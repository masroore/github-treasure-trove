<?php

namespace Modules\AdminPage\Services;

use App\Models\Page;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePageService
{
    public function handle(array $validatedData, $id)
    {
        try {
            DB::beginTransaction();
            $page = Page::find($id);
            $page->update($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
