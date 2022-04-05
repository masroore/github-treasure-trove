<?php
/**
 * Created by PhpStorm.
 * User: wwof1-3
 * Date: 29.05.18
 * Time: 15:35.
 */

namespace App\Models\Traits;

use Carbon\Carbon;
use Exception;
use Log;

/**
 * Updated: 06.02.2019.
 *
 * Trait Filterable
 */
trait Filterable
{
    // FOR EXAMPLE:
    /*
    public $filterable = [
        'title' => 'like',              // http://site.test/post?filter[title]=Some+title
        'price' => 'between'            // http://site.test/post?filter[price_from]=120&filter[price_to]=380
        'category_id' => 'equal',       // http://site.test/post?filter[category_id]=2
        'status' => 'in',               // http://site.test/post?filter[status][]=publish&filter[status][]=active or http://site.test/post?filter[status]=publish|active
        'created_at' => 'between_date', //http://site.test/post?filter[created_at_from]=14.10.2018&filter[created_at_to]=24.11.2018
        'updated_at' => 'equal_date',   //http://site.test/post?filter[updated_at]=14.10.2018

        // Relation model field (for `equal` and `in`)
        'user.name' => 'like',       // http://site.test/post?filter[user.name]=Ева%20Максимовна%20Терентьева
    ];
    */

    /**
     * TODO: added "q",.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeFilterable($query, ?array $filterAttributes = null)
    {
        $filterable = $this->getFilterable();
        $attributes = $this->filterAttributes($filterAttributes);

        if (!empty($attributes)) {
            $query->where(function ($q) use ($attributes, $filterable): void {
                foreach ($filterable as $key => $filterType) {
                    switch ($filterType) {
                        case 'equal':
                            if (array_key_exists($key, $attributes) && $attributes[$key] !== null) {
                                $this->fWhereEqual($q, $key, $attributes);
                            }

                            break;
                        case 'like':
                            if (array_key_exists($key, $attributes) && $attributes[$key] !== null) {
                                $q->where($key, 'LIKE', '%' . $attributes[$key] . '%');
                            }

                            break;
                        case 'in':
                            if (array_key_exists($key, $attributes) && $attributes[$key] !== null) {
                                $this->fWhereIn($q, $key, $attributes);
                            }

                            break;
                        case 'between':
                            $fromVal = $attributes[$key . '_from'] ?? null;
                            $toVal = $attributes[$key . '_to'] ?? null;
                            if ($fromVal != null && $toVal != null) {
                                $q->whereBetween($key, [$fromVal, $toVal]);
                            } elseif ($fromVal != null && $toVal == null) {
                                $q->where($key, '>=', $fromVal);
                            } elseif ($fromVal == null && $toVal != null) {
                                $q->where($key, '<=', $toVal);
                            }

                            break;
                        case 'equal_date':
                            if (array_key_exists($key, $attributes)) {
                                try {
                                    $date = Carbon::parse($attributes[$key])->toDateString();
                                    $q->whereDate($key, $date);
                                } catch (Exception $exception) {
                                    Log::error(__METHOD__ . $exception->getMessage());
                                }
                            }

                            break;
                        case 'between_date':
                            $fromVal = $attributes[$key . '_from'] ?? null;
                            $toVal = $attributes[$key . '_to'] ?? null;

                            try {
                                if ($fromVal != null && $toVal != null) {
                                    $dateFrom = Carbon::parse($fromVal);
                                    $dateTo = Carbon::parse($toVal)->addDay()->addSecond(-1);
                                    $q->whereBetween($key, [$dateFrom, $dateTo]);
                                } elseif ($fromVal != null && $toVal == null) {
                                    $dateFrom = Carbon::parse($fromVal);
                                    $q->where($key, '>=', $dateFrom);
                                } elseif ($fromVal == null && $toVal != null) {
                                    $dateTo = Carbon::parse($toVal)->addDay()->addSecond(-1);
                                    $q->where($key, '<=', $dateTo);
                                }
                            } catch (Exception $exception) {
                                Log::error(__METHOD__ . $exception->getMessage());
                            }

                            break;
                        case 'custom':
                            $method = 'scopeCustomFilterable';
                            if (array_key_exists($key, $attributes) && method_exists(self::class, $method)) {
                                $this->{$method}($q, $key, $attributes[$key]);
                            }

                            break;
                    }
                }
            });
        }

        return $query;
    }

    protected function getFilterable(): array
    {
        return $this->filterable ?? [];
    }

    protected function filterAttributes(?array $attributes = null)
    {
        $requestKeyName = config('model-filterable.use_request_key_name', 'filter'); //TODO make config
        if (!empty($requestKeyName) && !empty(request($requestKeyName)) && is_array(request($requestKeyName))) {
            return request('filter');
        } elseif (!empty($attributes)) {
            return $attributes;
        }

        return [];
    }

    /**
     * https://site.test/post?filter[status]=post_published.
     *
     * @param $q
     * @param $key
     *
     * @return mixed
     */
    protected function fWhereEqual($q, $key, array $attributes)
    {
        $value = $attributes[$key];

        if (preg_match('/\./', $key)) {
            $has = preg_replace('/\\.[a-z_]+$/', '', $key);
            $key = preg_replace('/[a-z_]+\\./', '', $key);

            $q->whereHas($has, function ($qq) use ($key, $value): void {
                $qq->where($key, $value);
            });
        } else {
            $q->where($key, $value);
        }

        return $q;
    }

    /**
     * https://site.test/post?filter[status][]=post_moderation&filter[status][]=post_published
     * or if set $filterSeparator
     * https://site.test/post?filter[status]=post_moderation|post_published
     * or
     * https://site.test/post?filter[status]=post_moderation.
     *
     * @param $q
     * @param $key
     *
     * @return mixed
     */
    protected function fWhereIn($q, $key, array $attributes)
    {
        //$value = is_array($attributes[$key]) ? $attributes[$key] : [$attributes[$key]];

        if (is_array($attributes[$key])) {
            $value = $attributes[$key];
        } elseif ($filterSeparator = '|') {
            $value = explode($filterSeparator, $attributes[$key]);
        } else {
            $value = [$attributes[$key]];
        }

        if (preg_match('/\./', $key)) {
            $has = preg_replace('/\\.[a-z_]+$/', '', $key);
            $key = preg_replace('/[a-z_]+\\./', '', $key);

            $q->whereHas($has, function ($qq) use ($key, $value): void {
                $qq->whereIn($key, $value);
            });
        } else {
            $q->whereIn($key, $value);
        }

        return $q;
    }
}
