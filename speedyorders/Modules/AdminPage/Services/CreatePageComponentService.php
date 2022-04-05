<?php

namespace Modules\AdminPage\Services;

use App\Models\PageComponent;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePageComponentService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            PageComponent::create($validatedData);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            dd($e);

            return false;
        }
    }
}
