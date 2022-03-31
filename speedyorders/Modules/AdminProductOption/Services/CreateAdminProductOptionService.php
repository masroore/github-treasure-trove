<?php

namespace Modules\AdminProductOption\Services;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Support\Facades\DB;
use Log;

class CreateAdminProductOptionService
{
    public function handle(array $data)
    {
        try {
            DB::beginTransaction();

            $option = Option::create($data);

            if (isset($data['option_value']['name'])) {
                $inserData = [];
                $time = now();
                foreach ($data['option_value']['name'] as $key=>$optionValue) {
                    $inserData[] = [
                        'option_id'=>$option->id,
                        'name'=>$optionValue,
                        'image'=>$data['option_value']['image'][$key] ?? null,
                        'sort_order'=>$data['option_value']['sort_order'][$key],
                        'created_at'=>$time,
                        'updated_at'=>$time,
                    ];

                    Log::info('Data : ' . json_encode($inserData));
                }

                OptionValue::insert($inserData);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
