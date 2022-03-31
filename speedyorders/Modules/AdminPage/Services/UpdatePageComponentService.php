<?php

namespace Modules\AdminPage\Services;

use App\Models\PageComponent;
use Illuminate\Support\Facades\DB;

class UpdatePageComponentService
{
    public function handle(array $validatedData)
    {
        try {
            DB::beginTransaction();
            $productComponent = PageComponent::find($validatedData['id']);
            $productComponent->update($validatedData);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);

            return false;
        }
    }
}
