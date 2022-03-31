<?php

namespace Modules\AdminProduct\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'height' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'breadth' => 'nullable|numeric',
            'description' => 'required|string',
            'base_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'required|numeric',
            'min_quantity' => 'required|numeric',
            'subtract_stock' => 'required|numeric',
            'sort_order' => 'required|numeric',
            'status' => 'required|numeric|in:1,0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'return_policy_days' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'video' => 'nullable|string|max:255',
            'categories.*'=>'required',
            'file.*'=>'nullable|numeric',
            'galleryId'=>'sometimes',
            'related_products.*'=>'nullable|exists:products,id',
            'option'=>'nullable',
            'option_id'=>'nullable',
            'is_featured'=>'required|in:0,1',
            'groups.*'=>'nullable',
            'delivery_time.*'=>'nullable',
            'shipping_zone_groups_id' => 'nullable|numeric',
            'shipping_packages_id' => 'nullable|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
