<?php

namespace Modules\AdminProductOption\Services;

use App\Models\Option;
use App\Models\OptionValue;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateAdminProductOptionService
{
    public function handle(array $data, $id)
    {
        try {
            DB::beginTransaction();

            $option = Option::find($id);
            $option->update($data);

            if (isset($data['option_value']['name'])) {
                $option->optionValues()->delete();
                $inserData = [];
                $time = now();
                foreach ($data['option_value']['name'] as $key => $optionValue) {
                    $inserData[] = [
                        'option_id' => $option->id,
                        'name' => $optionValue,
                        'image' => $data['option_value']['image'][$key] ?? null,
                        'sort_order' => $data['option_value']['sort_order'][$key],
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                }

                OptionValue::insert($inserData);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            dd($e);
            DB::rollback();

            return false;
        }
    }
}
