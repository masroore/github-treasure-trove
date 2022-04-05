<?php

namespace App\Http\Requests\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = null;
        if (in_array($this->getMethod(), ['PATCH', 'PUT'])) {
            $segments = $this->segments();
            $id = end($segments);
        }

        return [
            'name' => 'required|string|max:255',
            //'sku' => 'required|unique:products,sku,' . $id,
            'sku' => [
                'required',
                Rule::unique('products')->where(function ($query) use ($id) {
                    return $query->where('sku', $this->get('sku'))
                        ->where('locale', $this->get('locale'))
                        ->where('id', '<>', $id);
                }),
            ],
            'description' => 'nullable|string',
            'price' => 'nullable|required|numeric',
            'category_id' => 'required|exists:terms,id',
            'availability' => 'nullable|integer|min:0',
            'publish' => 'sometimes|in:0,1',
            'product_group_id' => 'nullable|exists:product_groups,id',

            'terms.*' => 'array',
            'terms.*.*' => 'numeric|exists:terms,id',
            'created_at' => 'nullable|date',
            'locale' => 'required|locale',
        ];
    }
}
