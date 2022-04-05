<?php

namespace App\Services;

use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductTags;
use App\Models\ProductVariationItems;
use App\Repositories\AttributeRepositoryInterface;
use App\Repositories\ProductAddOnsRepositoryInterface;
use App\Repositories\ProductLabelProductsRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductsCustomFieldsRepositoryInterface;
use App\Repositories\ProductTagsRepositoryInterface;
use App\Repositories\ProductVariationItemsRepositoryInterface;
use App\Repositories\ProductVariationsRepositoryInterface;
use App\Repositories\ProductWithAttributeRepositoryInterface;
use App\Repositories\ProductWithAttributeSetRepositoryInterface;
use App\Repositories\VeriationItemsRepositoryInterface;
use App\Repositories\VeriationRepositoryInterface;
use Exception;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductService
{
    public $file_dimensions = [

        'full' => ['width' => 1600, 'height' => 1600, 'ext' => 'webp', 'key' => '-F', 'model' => 'Products'],
        'large' => ['width' => 1200, 'height' => 1200, 'ext' => 'webp', 'key' => '-L', 'model' => 'Products'],
        'medium' => ['width' => 800,  'height' => 800,  'ext' => 'webp', 'key' => '-M', 'model' => 'Products'],
        'small' => ['width' => 450,  'height' => 450,  'ext' => 'webp', 'key' => '-S', 'model' => 'Products'],
        'small-jpg' => ['width' => 450,  'height' => 450,  'ext' => 'jpg', 'key' => '-SJ', 'model' => 'Products'],
        'x-small' => ['width' => 200,  'height' => 200,  'ext' => 'webp', 'key' => '-XS', 'model' => 'Products'],

    ];

    public $product_columns = [
        'id',
        'store_id',
        'name',
        'category_id',
        'description',
        'sku',
        'price',
        'sale_type',
        'sale_price',
        'start_date',
        'end_date',
        'with_storehouse_management',
        'quantity',
    ];

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    protected $veriationRepository;

    protected $veriationitemRepository;

    protected $productwithattributesetRepository;

    protected $productaddonsRepository;

    protected $productscustomfieldsRepository;

    protected $productlabelproductRepository;

    protected $producttagsRepository;

    protected $productvariationsRepository;

    protected $productvariationitemsRepository;

    protected $productwithattributeRepository;

    protected $attributeRepository;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        ProductRepositoryInterface $productRepository,
        VeriationRepositoryInterface $veriationRepository,
        VeriationItemsRepositoryInterface $veriationitemRepository,
        ProductWithAttributeSetRepositoryInterface $productwithattributesetRepository,
        ProductAddOnsRepositoryInterface $productaddonsRepository,
        ProductsCustomFieldsRepositoryInterface $productscustomfieldsRepository,
        ProductLabelProductsRepositoryInterface $productlabelproductRepository,
        ProductTagsRepositoryInterface $producttagsRepository,
        ProductVariationsRepositoryInterface $productvariationsRepository,
        ProductVariationItemsRepositoryInterface $productvariationitemsRepository,
        ProductWithAttributeRepositoryInterface $productwithattributeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->veriationRepository = $veriationRepository;
        $this->veriationitemRepository = $veriationitemRepository;
        $this->productwithattributesetRepository = $productwithattributesetRepository;
        $this->productaddonsRepository = $productaddonsRepository;
        $this->productscustomfieldsRepository = $productscustomfieldsRepository;
        $this->productlabelproductRepository = $productlabelproductRepository;
        $this->producttagsRepository = $producttagsRepository;
        $this->productvariationsRepository = $productvariationsRepository;
        $this->productvariationitemsRepository = $productvariationitemsRepository;
        $this->productwithattributeRepository = $productwithattributeRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {// get store id from token
            //dd($request->all());
            $validator = Validator::make($request->input(), [
                'name' => 'required|string|max:15|',
                // 'sku' => 'required|string|max:15|unique:products',
                'price' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'is_variation' => 'required',
                'store_id' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            // create Parent Product

            $product_parent = $this->productRepository->create([
                'store_id' => $request->store_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'images' => json_encode($request->images),
                'sku' => $request->sku,
                'price' => $request->price,
                'with_storehouse_management' => $request->with_storehouse_management,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'is_featured' => $request->is_featured,
                'is_variation' => 0,
                'sale_type' => $request->sale_type,
                'sale_price' => $request->sale_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'size_chart_id' => $request->size_chart_id,
            ]);
//            create unique Slug

            createSlug($product_parent);

            $parentProductId = $product_parent->id;
            if ($request['attributes'] && null != $request['attributes'][0]) {
                foreach ($request['attributes'] as $key => $attribute) {
                    $this->productwithattributesetRepository->create([
                        'attribute_set_id' => $attribute,
                        'product_id' => $parentProductId,
                        'order' => $key + 1,
                    ]);
                    $pairs = $this->attributeRepository->findAllByColumn(
                        ['attribute_set_id' => $attribute]
                    );
                    foreach ($pairs as $pair) {
                        $this->productwithattributeRepository->create([
                            'attribute_id' => $pair->id,
                            'product_id' => $parentProductId,
                        ]);
                    }
                }
            }
            if ($request['specifications'] && null != $request['specifications'][0]) {
                foreach ($request['specifications'] as $specifications) {
//                        dd($specifications['title']);
                    $this->productscustomfieldsRepository->create([
                        'label' => $specifications['title'],
                        'value' => $specifications['detail'],
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['add_ons'] && null != $request['add_ons'][0]) {
                // dd($request['add_ons']);
                foreach ($request['add_ons'] as $addons) {
                    $this->productaddonsRepository->create([
                        'title' => $addons['title'],
                        'price' => $addons['price'],
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['labels'] && null != $request['labels'][0]) {
                foreach ($request['labels'] as $label) {
                    $this->productlabelproductRepository->create([
                        'product_label_id' => $label,
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['tags'] && null != $request['tags'][0]) {
                foreach ($request['tags'] as $tags) {
                    $this->producttagsRepository->create([
                        'tag_id' => $tags,
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            // Create variant /Child
            if ($request['varients'] && null != $request['varients'][0]) {
                foreach ($request->varients as $key => $varient) {
                    $product_Child = $this->productRepository->create([
                        'store_id' => $request->store_id,
                        'brand_id' => $request->brand_id,
                        'price' => $varient['price'],
                        'sku' => $varient['sku'],
                        'quantity' => $varient['quantity'],
                        'manage_stock' => $varient['manage_stock'],
                        'category_id' => $request->category_id,
                        'description' => $varient['description'],
                        'is_variation' => 1,
                        'size_chart_id' => $varient['size_chart_id'],
                        'images' => json_encode($varient['images'], true),
                    ]);
                    $product_Child_id = $product_Child->id;
                    $productvariations = $this->productvariationsRepository->create([
                        'product_id' => $product_Child_id,
                        'configurable_product_id' => $parentProductId,
                        'is_default' => $varient['is_default'],
                    ]);
                    // dd('ok');
                    if ($varient['attribute'] && null != $varient['attribute'][0]) {
                        // dd($varient['attribute']);
                        foreach ($varient['attribute'] as $attribute_id) {
                            $this->productvariationitemsRepository->create([
                                'attribute_id' => $attribute_id,
                                'variation_id' => $productvariations->id,
                            ]);
                        }
                    }
                }
                // Create variant /Child
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }

        return $product_parent->fresh(
            'defaultProductAttributes',
            'variations.productAttributes',
            'variations.product',
            'comments'
        );
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // get store id from token
            $request['store_id'] = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            $validator = Validator::make($request->input(), [
                'name' => 'required|string|max:15|',
                //                'sku' => 'required|string|max:15|unique:products,sku,'.$id,
                'price' => 'required|integer',
                'category_id' => 'required|integer',
                'brand_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            if ($request->hasFile('images')) {
                $name = onefile($request->images, 'storage/uploads/store/product', $request->name);
                $request['images'] = $name;
            }
            // update data

//            $product = $this->productRepository->updateByColumn(['id' => $id], $request->input());

            $product_parent = $this->productRepository->updateGetModel(
                ['id' => $id],
                [
                    'store_id' => $request->store_id,
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'images' => json_encode($request->images),
                    'sku' => $request->sku,
                    'price' => $request->price,
                    'with_storehouse_management' => $request->with_storehouse_management,
                    'quantity' => $request->quantity,
                    'category_id' => $request->category_id,
                    'is_featured' => $request->is_featured,
                    'size_chart' => $request->size_chart,
                    'is_variation' => 0,
                    'sale_type' => $request->sale_type,
                    'sale_price' => $request->sale_price,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'size_chart_id' => $request->size_chart_id,
                ]
            );
            $parentProductId = $product_parent->id;
            if ($request['attributes'] && null != $request['attributes'][0]) {
                foreach ($request['attributes'] as $key => $attribute) {
                    $this->productwithattributesetRepository->updateGetModel(['product_id', $parentProductId], [
                        'attribute_set_id' => $attribute,
                        'product_id' => $parentProductId,
                        'order' => $key + 1,
                    ]);
                    $pairs = $this->attributeRepository->findAllByColumn(
                        ['attribute_set_id' => $attribute]
                    );
                    foreach ($pairs as $pair) {
                        $this->productwithattributeRepository->create([
                            'attribute_id' => $pair->id,
                            'product_id' => $parentProductId,
                        ]);
                    }
                }
            }
            if ($request['specifications'] && null != $request['specifications'][0]) {
                foreach ($request['specifications'] as $specifications) {
//                        dd($specifications['title']);
                    $this->productscustomfieldsRepository->updateGetModel(['product_id', $id], [
                        'label' => $specifications['title'],
                        'value' => $specifications['detail'],
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['add_ons'] && null != $request['add_ons'][0]) {
//                    dd($request['add_ons']);
                foreach ($request['add_ons'] as $addons) {
                    $this->productaddonsRepository->updateGetModel(['product_id', $id], [
                        'title' => $addons['title'],
                        'price' => $addons['price'],
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['labels'] && null != $request['labels'][0]) {
                foreach ($request['labels'] as $label) {
                    $this->productlabelproductRepository->updateGetModel(['product_id', $id], [
                        'product_label_id' => $label,
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            if ($request['tags'] && null != $request['tags'][0]) {
                foreach ($request['tags'] as $tags) {
                    $this->producttagsRepository->updateGetModel(['product_id', $id], [
                        'tag_id' => $tags,
                        'product_id' => $parentProductId,
                    ]);
                }
            }
            // Create variant /Child
            if ($request['varients'] && null != $request['varients'][0]) {
                foreach ($request->varients as $key => $varient) {
                    $product_Child = $this->productRepository->create([
                        'store_id' => $request->store_id,
                        'brand_id' => $request->brand_id,
                        'price' => $varient['price'],
                        'sku' => $varient['sku'],
                        'quantity' => $varient['quantity'],
                        'manage_stock' => $varient['manage_stock'],
                        'category_id' => $request->category_id,
                        'description' => $varient['description'],
                        'is_variation' => 1,
                        'size_chart_id' => $varient['size_chart_id'],
                        'images' => json_encode($varient['images'], true),
                    ]);
                    $product_Child_id = $product_Child->id;
                    $productvariations = $this->productvariationsRepository->create([
                        'product_id' => $product_Child_id,
                        'configurable_product_id' => $parentProductId,
                        'is_default' => $varient['is_default'],
                    ]);
                    if ($varient['attribute'] && null != $varient['attribute'][0]) {
//                        dd($varient['attribute']);
                        foreach ($varient['attribute'] as $attribute_id) {
                            $this->productvariationitemsRepository->create([
                                'attribute_id' => $attribute_id,
                                'variation_id' => $productvariations->id,
                            ]);
                        }
                    }
                }
                // Create variant /Child
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }

        return $product_parent->fresh(
            'defaultProductAttributes',
            'variations.productAttributes',
            'variations.product',
            'comments'
        );
    }

    public function show($id)
    {
        try {
            $product = $this->productRepository->findByColumn(['id' => $id]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $product->fresh(
            'defaultProductAttributes',
            'variations.productAttributes',
            'variations.product',
            'comments'
        );
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $deleted = $this->productRepository->deleteByColumn(['id' => $id]);
//            $deleted = $this->productwithattributesetRepository->deleteByColumn(['product_id'=>$id]);
//            $deleted = $this->productwithattributeRepository->deleteByColumn(['product_id'=>$id]);
//            $deleted = $this->productwithattributeRepository->deleteByColumn(['product_id'=>$id]);
//            $veriations = $this->productvariationsRepository->findAllByColumn(['configurable_product_id'=>$id],['id']);
//            dd($veriations->toArray());
//            $deleted = $this->productvariationitemsRepository->deleteByColumn(['id',$veriations->toArray()->id]);
//            dd('ok');
//            $deleted = $this->productvariationsRepository->deleteByColumn(['configurable_product_id'=>$id]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    public function deleteImage($request)
    {
        try {
            $deleted = multiImagesDelete($request, $this->file_dimensions);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    public function getSize($request, $attributeid, $product_id, $set_id)
    {
//        dd($request->all(),$attributeid,$product_id,$set_id);
        return $this->productvariationsRepository
            ->findAllByColumn(['configurable_product_id' => $product_id], ['*'], ['productAttributes', 'product']);
//        dd($varients->toArray());
//        foreach ($varients->toArray()  as $arr){
//            $variation_=$this->productvariationsRepository
//                ->findAllByColumn(['configurable_product_id' => $product_id]);
//        }
//        dd($varients->toArray());

//     $data=  ProductVariationItems::Join('product_variations', 'product_variation_items.variation_id',
//         '=','product_variations.id')
//         ->Join('products', 'product_variations.configurable_product_id', '=', 'products.id')
        ////         ->where('product_variation_items.variation_id','=',69)
//         ->with('attributes')
//         ->select(['product_variations.*','product_variation_items.*','products.*','product_variation_items.variation_id as group_id'])
//         ->groupBy('group_id')
//        ->get();

//        $data=  Products::Join('product_variations', 'products.id','=','product_variations.configurable_product_id')
//         ->Join('product_variation_items', 'product_variations.id','=','product_variation_items.variation_id')
//         ->where('product_variation_items.variation_id','=',69)
//         ->with('attributes')
//         ->select(['product_variations.*','product_variation_items.*','products.*','product_variation_items.variation_id as group_id'])
//         ->groupBy('group_id')
//        ->get();
        //dd($data);
    }

    public function filterStores(Request $request)
    {
        try {
            $query = ProductTags::rightJoin('products', 'product_tags.product_id', '=', 'products.id')
                ->leftJoin('tags', 'product_tags.tag_id', '=', 'tags.id')
                ->leftJoin('stores', 'products.store_id', '=', 'stores.id')
                ->leftJoin('industries', 'industries.id', '=', 'stores.industry_id')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id');
            $query->select(
                'products.name As product_name',
                'categories.name As category_name',
                'brands.name As brand_name',
                'stores.store_name As store_name',
                'tags.name As tag_name',
                'industries.name As industry_name',
                'stores.id As store_id',
                'stores.description As store_description',
                'stores.images As store_images',
                'stores.latitude As store_latitude',
                'stores.longitude As store_longitude',
            );
            $query->where('products.name', 'LIKE', '%' . $request->data . '%');
            $query->orWhere('categories.name', 'LIKE', '%' . $request->data . '%');
            $query->orWhere('brands.name', 'LIKE', '%' . $request->data . '%');
            $query->orWhere('stores.store_name', 'LIKE', '%' . $request->data . '%');
            $query->orWhere('industries.name', 'LIKE', '%' . $request->data . '%');
            $query->orWhere('tags.name', 'LIKE', '%' . $request->data . '%');
            $data = $query->groupBy('stores.id')->dd();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $data;
    }

    /**
     * Get all Products of a store.
     */
    public function getAll(Request $request)
    {
        try {
            $store_id = $request['store_id'];

            $categories = Categories::select(
                'id',
                'parent_id',
                'name',
                'icon'
            )
                ->with('subcategories', function ($query): void {
                    $query->select('id', 'parent_id', 'name', 'icon')
                        ->where('status', 1)
                        ->with('products', function ($q): void {
                            $q->select($this->product_columns);
                            $q->where(['status' => 1, 'is_variation' => 0]);
                            $q->take(5);
                        });
                })
                ->with('products', function ($p): void {
                    $p->select($this->product_columns);
                    $p->where(['status' => 1, 'is_variation' => 0]);
                    $p->take(5);
                })
                ->where([
                    'store_id' => $store_id,
                    'status' => 1,
                    'parent_id' => 0,
                ])
                ->paginate(8);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $categories;
    }
}
