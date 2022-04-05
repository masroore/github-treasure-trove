<?php

namespace Modules\AdminProductAttribute\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateAdminProductAttributeService
{
    public function handle(array $data, $id)
    {
        try {
            DB::beginTransaction();

            $attribute = Attribute::find($id);
            $attribute->update($data);

            if (isset($data['attribute_value']['name'])) {
                $attribute->attributeValues()->delete();
                $inserData = [];
                $time = now();
                foreach ($data['attribute_value']['name'] as $key => $attributeValue) {
                    $inserData[] = [
                        'attributes_id' => $attribute->id,
                        'name' => $attributeValue,
                        'updated_at' => $time,
                    ];
                }

                AttributeValue::insert($inserData);
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
