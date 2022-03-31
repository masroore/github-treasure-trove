<?php

namespace Modules\AdminCategory\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CreateCategoryService
{
    public function handle(array $validatedDatas)
    {
        try {
            DB::beginTransaction();

            if (isset($validatedDatas['image'])) {
                $image = $validatedDatas['image'];
                $imageName = uniqid() . time() . $image->getClientOriginalName();
                $image->move(public_path('images/categories'), $imageName);
                $validatedDatas['image'] = $imageName;
            }

            Category::create($validatedDatas);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
