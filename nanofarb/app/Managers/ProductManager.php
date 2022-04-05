<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 04.01.19
 * Time: 9:43.
 */

namespace App\Managers;

use App\Models\Shop\Attribute;
use App\Models\Shop\Product;
use App\Models\Shop\ProductGroup;
use App\Models\Shop\Value;
use App\Models\Taxonomy\Term;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductManager
{
    public function store(array $attributes)
    {
        $data = $this->prepareData($attributes);

        if (empty($attributes['product_group_id'])) {
            $group = ProductGroup::create();
        } else {
            $group = ProductGroup::findOrFail($attributes['product_group_id']);
            if (empty($data['category_id'])) {
                $data['category_id'] = $group->product->category_id;
            }
        }
        $data['product_group_id'] = $group->id;

        $product = Product::create($data);

        $this->syncTerms($product, $attributes['terms'] ?? []);

        if (empty($attributes['product_group_id'])) {
            $group->default_product_id = $product->id;
            $group->save();
        }

        return $product;
    }

    public function update(Model $product, array $attributes)
    {
        $data = $this->prepareData($attributes);

        if ($product->group->default_product_id == $product->id && $product->category_id != $attributes['category_id']) {
            $data['category_id'] = $attributes['category_id'];
            $product->group->products->map(function ($p) use ($attributes): void {
                $p->setAttribute('category_id', $attributes['category_id']);
                $p->save();
            });
        } else {
            if (empty($data['category_id'])) {
                $data['category_id'] = $product->group->product->category_id;
            }
        }

        $product->update($data);

        $this->syncTerms($product, $attributes['terms'] ?? []);

        return $product;
    }

    protected function prepareData(array $attributes)
    {
        return [
            'sku' => $attributes['sku'],
            'name' => $attributes['name'],
            'consumption' => $attributes['consumption'],
            'description' => $attributes['description'],
            'price' => ($attributes['price'] * 100) ?? 0,
            'price_old' => ($attributes['price_old'] * 100) ?? 0,
            'availability' => $attributes['availability'] ?? 1,
            'publish' => $attributes['publish'] ?? 1,
            'category_id' => $attributes['category_id'],
            'created_at' => $attributes['created_at'] ?? \Carbon\Carbon::now(),
            'locale' => $attributes['locale'] ?? config('app.locale'),
            //'product_group_id' => $attributes['product_group_id'],
            'data' => [
                'weight' => $attributes['data']['weight'] ?? 0,
                'length' => $attributes['data']['length'] ?? 0,
                'width' => $attributes['data']['width'] ?? 0,
                'height' => $attributes['data']['height'] ?? 0,

                'applying' => $attributes['data']['applying'] ?? '',
                'instruction' => $attributes['data']['instruction'] ?? '',
                'delivery_info' => $attributes['data']['delivery_info'] ?? '',
            ],
        ];
    }

    protected function syncTerms(Model $product, array $terms = [])
    {
        if (count($terms)) {
            return $product->terms()->sync(array_values_recursive($terms));
        }

        return 0;
    }

    /**
     * Данные для построения Атрибутов-значений
     * на стронице товара.
     *
     * @return array
     */
    public function cardAttributesValuesBuild(Product $product)
    {
        //все продукты групы
        $groupProducts = $product->group->products()->byLocale()->with('values', 'values.attribute')->get();

        $uniqueAttributes = $groupProducts->map(function (Product $product) {
            //вернуть все атрибуты к продукту
            return $product->values->map(function (Value $value) {
                return $value->attribute;
            });
        })->flatten(1)->unique('id')
            ->whereIn('purpose', [Attribute::PURPOSE_CARD, Attribute::PURPOSE_COMBINED])
//            ->whereIn('purpose', [Attribute::PURPOSE_TINTING_FACADE, Attribute::PURPOSE_TINTING_INTERIOR])
            ->mapWithKeys(function (Attribute $attribute) {
                return [$attribute->id => $attribute];
            })->sort(function (Attribute $a, Attribute $b) {
                if (($res = $a->weight <=> $b->weight) !== 0) {
                    return $res;
                }

                return $a->title <=> $b->title;
            });

        $valuesByIds = $product->values->mapWithKeys(function (Value $value) {
            return [$value->attribute_id => $value];
        });
        // TODO: проверить, если нет фасетный значений
        $currentProductKey = $uniqueAttributes->map(function (Attribute $attribute) use ($valuesByIds) {
            return $valuesByIds[$attribute->id]->value;
        });

        $productsByKeys = $groupProducts->mapWithKeys(function (Product $product) use ($uniqueAttributes) {
            $valuesByIds = $product->values->mapWithKeys(function (Value $value) {
                return [$value->attribute_id => $value];
            });

            $productKey = $uniqueAttributes->map(function (Attribute $attribute) use ($valuesByIds) {
                $value = $valuesByIds[$attribute->id] ?? null;

                return $value !== null ? $value->value : null;
            })->implode('*');

            return [$productKey => $product];
        });

        $valuesTree = $groupProducts->map(function (Product $product) {
            return $product->values;
        })->flatten()->mapToGroups(function (Value $value) {
            return [$value->attribute->id => $value];
        })->map(function (Collection $values) use ($uniqueAttributes, $currentProductKey, $productsByKeys) {
            return $values
                ->unique('id')
                ->sort(function (Value $a, Value $b) {
                    if (($res = $a->weight <=> $b->weight) !== 0) {
                        return $res;
                    }

                    return $a->value <=> $b->value;
                })
                ->map(function (Value $value) use ($currentProductKey, $uniqueAttributes, $productsByKeys) {
                    $key = clone $currentProductKey;
                    $key[$uniqueAttributes->search($value->attribute)] = $value->value;

                    return [
                        'value' => $value,
                        'product' => $productsByKeys[$key->implode('*')] ?? null,
                    ];
                });
        });

        return [$uniqueAttributes, $valuesTree];
    }

    /**
     * Данные для построение фасетного фильтра на странице товаров.
     *
     * @return array
     */
    public function facetAttributesValuesBuild(Term $category, array $categoryIds, array $filter = [])
    {
        //$categoryAttributes = $category->attrsDescendantsCategories()->whereIn('purpose', [Attribute::PURPOSE_FACET, Attribute::PURPOSE_COMBINED])

        // Атрибуты выбранной категории.
        $categoryAttributes = $category->attrsAncestorsCategories()->whereIn('purpose', [Attribute::PURPOSE_FACET, Attribute::PURPOSE_COMBINED])
            ->sort(function (Attribute $a, Attribute $b) {
                if (($res = $a->weight <=> $b->weight) !== 0) {
                    return $res;
                }

                return $a->title <=> $b->title;
            });

        // Значения атрибутов из существующих (при фильтрации) товаров.
        $valuesIds = Value::select('values.id')
            ->leftJoin('product_value', 'product_value.value_id', 'values.id')
            ->leftJoin('products', 'products.id', 'product_value.product_id')
            ->whereHas('products', function ($p) use ($categoryIds, $filter): void {
                $p
                    ->isPublish()
                    ->facetFilter($filter)
                    ->byTaxonomies(['product_categories' => $categoryIds]);
            })
            ->groupBy('values.id')
            ->get();

        // Значение атрибутов которые "Не скрывать в фильтре, при отсутствии товаров"
        $forceValues = $categoryAttributes->where('show_if_empty_filter', '1')->pluck('values.*.id')->flatten()->values()->toArray();
        $forceValues = array_merge($valuesIds->pluck('id')->toArray(), $forceValues);

        // ??????
        $attributeValues = Value::select()
            ->whereIn('id', $forceValues)
            ->get()
            ->sort(function (Value $a, Value $b) {
                if (($res = $a->weight <=> $b->weight) !== 0) {
                    return $res;
                }

                return $a->value <=> $b->value;
            });

        return [$categoryAttributes, $attributeValues];
    }
}
