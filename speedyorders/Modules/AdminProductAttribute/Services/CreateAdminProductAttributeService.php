<?php

namespace Modules\AdminProductAttribute\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use Log;

class CreateAdminProductAttributeService
{
    public function handle(array $data)
    {
        try {
            DB::beginTransaction();

            $attribute = Attribute::create($data);

            if (isset($data['attribute_value']['name'])) {
                $inserData = [];
                $time = now();
                foreach ($data['attribute_value']['name'] as $key=>$attributeValue) {
                    $inserData[] = [
                        'attributes_id'=>$attribute->id,
                        'name'=>$attributeValue,
                        'created_at'=>$time,
                        'updated_at'=>$time,
                    ];

                    Log::info('Attribute Values Data : ' . json_encode($inserData));
                }

                AttributeValue::insert($inserData);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
