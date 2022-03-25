<?php

namespace App\Services;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Store;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PublicService
{
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * PublicService constructor.
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get home page stores listing.
     */
    public function homeListing()
    {
        try {
            $user_id = request()->user('sanctum') ? request()->user('sanctum')->id : null;

            $stores = Store::select(
                'id',
                'store_name',
                'business_url',
                'whatsapp_num',
                'store_logo',
                'images',
                'description',
                'delivery_hours',
                'delivery_minutes'
            )->where([
                'is_approved' => 1,
                'status' => 1,
            ])->with([
                'slug' => function ($query) {
                    $query->select('slugable_id', 'slug');
                },
            ])
                ->when($user_id, function ($query) use ($user_id) {
                    return $query->withCount(['favorite as is_favorite' => function ($q) use ($user_id) {
                        $q->where('favorites.user_id', $user_id);
                    }]);
                })
                ->withAvg('comments as rating', 'rating')
                ->paginate(8);

            if ($stores->isEmpty()) {
                throw new InvalidArgumentException('No stores found');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $stores;
    }

    /**
     * search for a store on the base of keyword.
     *
     * @param $keyword
     */
    public function search($keyword)
    {
        try {
            $user_id = request()->user('sanctum') ? request()->user('sanctum')->id : null;

            // search for the keyword in store, categories, products, tags and brands
            $stores = Store::select(
                'stores.id',
                'store_name',
                'business_url',
                'whatsapp_num',
                'store_logo',
                'images',
                'description',
                'delivery_hours',
                'delivery_minutes',
                'store_timings',
                'store_timings as delivery_time'
            )
                ->where([
                    'is_approved' => 1,
                    'stores.status' => 1,
                ])
                ->where(function ($query) use ($keyword) {
                    $query->where('store_name', 'like', '%' . $keyword . '%')
                        ->orWhereHas('categories', function ($categories) use ($keyword) {
                            $categories->select('categories.id')->where('name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('products', function ($products) use ($keyword) {
                            $products->select('id')->where('name', 'like', '%' . $keyword . '%')
                                ->orWhereHas('tags', function ($tags) use ($keyword) {
                                    $tags->select('tags.id')->where('name', 'like', '%' . $keyword . '%');
                                });
                        })
                        ->orWhereHas('brands', function ($brands) use ($keyword) {
                            $brands->select('brands.id')->where('name', 'like', '%' . $keyword . '%');
                        });
                })
                ->when($user_id, function ($query) use ($user_id) {
                    return $query->withCount(['favorite as is_favorite' => function ($q) use ($user_id) {
                        $q->where('favorites.user_id', $user_id);
                    }]);
                })
                ->withAvg('comments as rating', 'rating')
                ->paginate(8);

            if ($stores->isEmpty()) {
                throw new InvalidArgumentException('No stores found');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $stores;
    }

    /**
     * @param $slug
     *
     * @return Collection|null
     */
    public function storesByIndustry($industry)
    {
        try {
            $user_id = request()->user('sanctum') ? request()->user('sanctum')->id : null;

            $store = Store::select(
                'id',
                'store_name',
                'business_url',
                'whatsapp_num',
                'store_logo',
                'images',
                'description',
                'delivery_hours',
                'delivery_minutes',
                'currency'
            )
                ->where([
                    'is_approved' => 1,
                    'status' => 1,
                ])
                ->whereRaw('(`industry_id` = ? or FIND_IN_SET(?, `industry_types`))', [$industry, $industry])
                ->with('comments', function ($query) {
                    $query->select('id', 'commentable_id', 'body', 'likes')->latest();
                })
                ->withMin('products as starting_from', 'price')
                ->when($user_id, function ($query) use ($user_id) {
                    return $query->withCount(['favorite as is_favorite' => function ($q) use ($user_id) {
                        $q->where('favorites.user_id', $user_id);
                    }]);
                })
                ->withAvg('comments as rating', 'rating')
                ->paginate(10);

            if ($store->isEmpty()) {
                throw new InvalidArgumentException('No store in this category.');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    /**
     * @param $slug
     */
    /*public function showStore($slug) {
        try {
            $user_id = request()->user('sanctum') ? request()->user('sanctum')->id : null;

            $store = Store::select(
                'id', 'store_name', 'business_url', 'whatsapp_num', 'store_logo',
                'images', 'description', 'delivery_hours', 'delivery_minutes', 'currency'
            )
                ->where([
                    'is_approved' => 1,
                    'status' => 1
                ])
                ->with('comments', function ($query) {
                    $query->select('id', 'commentable_id', 'body', 'likes')->latest();
                })
                ->withMin('products as starting_from', 'price')
                ->when($user_id, function ($query) use ($user_id) {
                    return $query->withCount(['favorite as is_favorite' => function($q) use ($user_id) {
                        $q->where('favorites.user_id', $user_id);
                    }]);
                })
                ->withAvg('comments as rating', 'rating')
                ->whereHas('slug', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })->first();

        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }*/

    /**
     * Show store data by business url.
     *
     * @param $url
     */
    public function getStore($url)
    {
        try {
            $store = Store::select(
                'id',
                'store_logo',
                'store_name',
                'whatsapp_num',
                'business_url',
                'description',
                'images',
                'email',
                'website',
                'ntn_num',
                'street_address',
                'latitude',
                'longitude',
                'country',
                'is_online',
                'postal_code',
                'area',
                'bank_phone',
                'payment_method',
                'service_options',
                'applicable_range',
                'currency',
                'delivery_hours',
                'cash_on_delivery as payment_method',
                'delivery_minutes',
                'store_timings',
                'shipping_percentage as delivery_fee',
                'store_timings as delivery_time',
                'shipping_percentage_type'
            )
                ->where([
                    'business_url' => $url,
                    'is_approved' => 1,
                    'status' => 1,
                ])
                ->with('comments', function ($query) {
                    $query->select('id', 'commentable_id', 'body', 'rating', 'likes', 'created_at')->latest();
                })
                ->withCount('comments as ratings_count')
                ->withCount('orders')
                ->withAvg('comments as rating', 'rating')
                ->withMin('products as starting_from', 'price')
                ->first();

            if (!$store) {
                throw new InvalidArgumentException('Store not found.', 401);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    /**
     * Show branch data by business url.
     *
     * @param $url
     */
    public function getBranch($url, Request $request)
    {
        try {
            $stores = Store::select('id')->where([
                'business_url' => $url,
            ])->first();

            $branch_url = $stores->id . '::' . $request['branch'];

            $store = Store::select(
                'id',
                'store_logo',
                'store_name',
                'whatsapp_num',
                'business_url',
                'description',
                'images',
                'email',
                'website',
                'ntn_num',
                'street_address',
                'latitude',
                'longitude',
                'country',
                'is_online',
                'postal_code',
                'area',
                'bank_phone',
                'payment_method',
                'service_options',
                'applicable_range',
                'currency',
                'delivery_hours',
                'cash_on_delivery as payment_method',
                'delivery_minutes',
                'store_timings',
                'shipping_percentage as delivery_fee',
                'store_timings as delivery_time',
                'shipping_percentage_type'
            )
                ->where([
                    'business_url' => $branch_url,
                    'is_approved' => 1,
                    'status' => 1,
                ])
                ->with('comments', function ($query) {
                    $query->select('id', 'commentable_id', 'body', 'rating', 'likes', 'created_at')->latest();
                })
                ->withCount('comments as ratings_count')
                ->withCount('orders')
                ->withAvg('comments as rating', 'rating')
                ->withMin('products as starting_from', 'price')
                ->first();

            if (!$store) {
                throw new InvalidArgumentException('Store not found.', 401);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $store;
    }

    /**
     * Get Store Categories.
     *
     * @param $store
     */
    public function storeCategories($store)
    {
        try {
            $categories = Categories::select(
                'id',
                'parent_id',
                'name',
                'icon'
            )
                ->with('subcategories', function ($query) {
                    $query->select(
                        'id',
                        'parent_id',
                        'name',
                        'icon'
                    )
                        ->where('status', 1)->with('products', function ($q) {
                            $q->where('status', 1)->take('5');
                        });
                })
                ->with('products', function ($query) {
                    $query->take(5);
                })
                ->where([
                    'store_id' => $store,
                    'status' => 1,
                    'parent_id' => 0,
                ])
                ->paginate(8);

            if ($categories->isEmpty()) {
                throw new InvalidArgumentException('No categories found');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $categories;
    }

    /**
     * Get store category products.
     *
     * @param $store
     * @param $category
     */
    public function categoryProducts($store, $category)
    {
        try {
            $products = Products::select(
                'id',
                'store_id',
                'name',
                'description',
                'status',
                'images',
                'sku',
                'price',
                'with_storehouse_management',
                'quantity',
                'category_id',
                'brand_id',
                'is_variation',
                'sale_price'
            )
                ->where([
                    'store_id' => $store,
                    'category_id' => $category,
                    'is_variation' => 0,
                ])
                ->with('brand')
                ->paginate(15);

            if ($products->isEmpty()) {
                throw new InvalidArgumentException('No product found in this category');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $products;
    }
}
