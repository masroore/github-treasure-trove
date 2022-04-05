<?php

namespace Modules\Product\Repositories;

use App\Traits\Accounts;
use App\Traits\ImageStore;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Importer;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\JournalRepository;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockReport;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ComboProduct;
use Modules\Product\Entities\ComboProductDetail;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductVariations;
use Modules\Product\Entities\VariantValues;
use stdClass;

class ProductRepository implements ProductRepositoryInterface
{
    use Accounts;
    use ImageStore;

    public function all()
    {
        return ProductSku::with('product', 'product.category', 'product.unit_type', 'product.brand')->whereHas('product', function ($q) {
            return $q->where('product_type', '!=', 'Service');
        })->latest()->get();
    }

    public function service()
    {
        return ProductSku::with('product', 'product.category', 'product.unit_type', 'product.brand')->whereHas('product', function ($q) {
            return $q->where('product_type', 'Service');
        })->latest()->get();
    }

    public function allStockProduct()
    {
        return Product::with('category', 'unit_type', 'brand', 'model')->whereHas('skus', function ($query): void {
            $query->HasStock();
        })->where('product_type', '!=', 'Service')->latest()->get();
    }

    public function allService()
    {
        return Product::with('category', 'unit_type', 'brand', 'model')->where('product_type', 'Service')->latest()->get();
    }

    public function allHouseProduct($id, $type)
    {
        return Product::with('category', 'unit_type', 'brand', 'model', 'skus')->whereHas('skus', function ($query) use ($id, $type): void {
            $query->StockProduct($id, $type);
        })->latest()->get();
    }

    public function houseComboProduct($id, $type)
    {
        return ComboProduct::whereHas('combo_products.productSku', function ($query) use ($id, $type): void {
            $query->StockProduct($id, $type);
        })->latest()->get();
    }

    public function productForPurchase()
    {
        return Product::with('category', 'unit_type', 'brand', 'model', 'skus')->where('product_type', '!=', 'Service')->get();
    }

    public function allComboProduct()
    {
        return ComboProduct::whereHas('combo_products.productSku', function ($query): void {
            $query->HasStock();
        })->latest()->get();
    }

    public function searchCombo($search_keyword)
    {
        return ComboProduct::whereLike(['name', 'barcode_type'], $search_keyword)->get();
    }

    public function allProduct()
    {
        return ProductSku::with('product')->HasStock()->latest()->get();
    }

    public function searchBased($search_keyword)
    {
        return Product::whereLike(['product_name', 'product_type', 'skus.sku'], $search_keyword)->get();
    }

    public function searchProduct($search_keyword)
    {
        return Product::where('product_name', $search_keyword)->orWhereHas('skus', function ($query) use ($search_keyword): void {
            $query->where('sku', $search_keyword);
        })->get();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        if ($data['product_type'] == 'Combo') {
            $comboProduct = new ComboProduct();
            $comboProduct->name = $data['product_name'];
            $comboProduct->showroom_id = session()->get('showroom_id');
            $comboProduct->barcode_id = '2000-' . Str::random(12);
            $comboProduct->barcode_type = $data['barcode_type'];
            $comboProduct->price = $data['combo_selling_price'];
            $comboProduct->total_purchase_price = $data['purchase_price'];
            $comboProduct->total_regular_price = $data['selling_price'];
            $comboProduct->min_selling_price = $data['min_selling_price'];
            $comboProduct->description = $data['product_description'];
            $comboProduct->image_source = isset($data['file']) ? $this->saveImage($data['file'], 94, 94) : null;
            if ($comboProduct->save()) {
                foreach ($data['selected_product_id'] as $key => $product_id) {
                    $comboProductDetail = new ComboProductDetail();
                    $comboProductDetail->combo_product_id = $comboProduct->id;
                    $comboProductDetail->product_sku_id = $product_id;
                    $comboProductDetail->product_qty = $data['selected_product_qty'][$key];
                    $comboProductDetail->save();
                }
            }
        } else {
            $product = new Product();
            $data = Arr::add($data, 'description', $data['product_description']);
            $data['description'] = $data['product_description'];
            if (isset($data['file'])) {
                $data = Arr::add($data, 'image_source', $this->saveImage($data['file'], 94, 94));
            }
            $product->fill(Arr::except($data, ['product_description']))->save();

            if ($data['product_type'] == 'Variable') {
                if (!empty($data['selected_variant'])) {
                    $selected_variant = count($data['selected_variant']);
                    $variation_type_combination = collect($data['variation_type'])->chunk($selected_variant)->toArray();
                    $variation_value_combination = collect($data['variation_value_id'])->chunk($selected_variant)->toArray();
                    $product_variations = [];

                    foreach ($variation_type_combination as $key => $combined_value) {
                        if (!empty($data['variation_sku']) && $data['variation_sku'][$key] != null) {
                            $new_sku = $data['variation_sku'][$key];
                        } else {
                            $new_sku = (strlen($data['product_name']) <= 10) ? $data['product_name'] : Str::limit($data['product_name'], 9, '');
                        }
                        $productSku = new ProductSku();
                        $productSku->product_id = $product->id;
                        $productSku->sku = (ProductSku::where('sku', $new_sku)->first() == null) ? $new_sku : $new_sku . Str::random(6);
                        $productSku->cost_of_goods = $data['purchase_prices'][$key] ?? 0;
                        $productSku->alert_quantity = $data['alert_quantities'][$key] ?? 0;
                        $productSku->purchase_price = $data['purchase_prices'][$key] ?? 0;
                        $productSku->min_selling_price = $data['min_selling_prices'][$key] ?? 0;
                        $productSku->selling_price = $data['selling_prices'][$key] ?? 0;
                        $productSku->tax = ($data['tax']) ?: 0;
                        $productSku->tax_type = 'percent';
                        $productSku->barcode_id = '1000-' . $product->id . '-' . Str::random(12);
                        $productSku->barcode_type = $data['barcode_type'];
                        $productSku->save();

                        $product_variations[] = [
                            'product_id' => $product->id,
                            'variant_id' => json_encode(array_values($combined_value)),
                            'product_sku_id' => $productSku->id,
                            'variant_value_id' => json_encode(array_values($variation_value_combination[$key])),
                            'image_source' => isset($data['variation_file'][$key]) ? $this->saveImage($data['variation_file'][$key], 94, 94) : null,
                            'created_by' => Auth::user()->id ?? null,
                            'updated_by' => Auth::user()->id ?? null,
                            'created_at' => Carbon::now(),
                        ];

                        foreach ($data['variation_value_id'] as $value) {
                            $variation_value = VariantValues::where('id', $value)->where('used', 0)->first();
                            if ($variation_value) {
                                $variation_value->used = 1;
                                $variation_value->save();
                            }
                        }
                    }
                    ProductVariations::insert($product_variations);
                }
            } else {
                if (!empty($data['product_sku'])) {
                    $new_sku = $data['product_sku'];
                } else {
                    $new_sku = (strlen($data['product_name']) <= 10) ? $data['product_name'] : Str::limit($data['product_name'], 9, '');
                }

                if ($data['product_type'] == 'Service') {
                    $data['selling_price'] = $data['hourly_rate'];
                }
                $productSku = new ProductSku();
                $productSku->product_id = $product->id;

                $productSku->cost_of_goods = array_key_exists('purchase_price', $data) ? $data['purchase_price'] : '';
                $productSku->alert_quantity = array_key_exists('alert_quantity', $data) ? $data['alert_quantity'] : '';
                $productSku->purchase_price = array_key_exists('purchase_price', $data) ? $data['purchase_price'] : '';
                $productSku->selling_price = $data['selling_price'];
                $productSku->min_selling_price = $data['min_selling_price'];
                $productSku->tax = $data['tax'];
                $productSku->tax_type = $data['tax_type'];
                $productSku->barcode_id = '1000-' . $product->id . '-' . Str::random(12);
                $productSku->barcode_type = $data['barcode_type'];
                $productSku->save();
                $productSku->fresh();
                $productSku->sku = $new_sku . '-' . $productSku->id;
                $productSku->save();
            }
        }
        DB::commit();

        return $data['product_type'] == 'Combo' ? $comboProduct : $product;
    }

    public function find($id)
    {
        return Product::with('unit_type', 'category', 'subcategory', 'model', 'brand', 'variations')->findOrFail($id);
    }

    public function findCombo($id)
    {
        return ComboProduct::findOrFail($id);
    }

    public function findSku($id)
    {
        return ProductSku::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        DB::beginTransaction();
        if ($data['product_type'] == 'Combo') {
            $comboProduct = ComboProduct::findOrFail($id);
            $comboProduct->name = $data['product_name'];
            $comboProduct->barcode_type = $data['barcode_type'];
            $comboProduct->price = $data['combo_selling_price'];
            $comboProduct->min_selling_price = $data['min_selling_price'];
            $comboProduct->total_purchase_price = $data['purchase_price'];
            $comboProduct->total_regular_price = $data['selling_price'];
            $comboProduct->min_selling_price = $data['min_selling_price'];
            $comboProduct->description = $data['product_description'];
            if (isset($data['file'])) {
                if (File::exists($comboProduct->image_source)) {
                    File::delete($comboProduct->image_source);
                }
                $comboProduct->image_source = $this->saveImage($data['file'], 94, 94);
            }

            if ($comboProduct->save()) {
                foreach ($data['selected_product_id'] as $key => $product_id) {
                    $comboProductDetail = ComboProductDetail::where('product_sku_id', $product_id)->where('combo_product_id', $comboProduct->id)->first();
                    $comboProductDetail->product_sku_id = $product_id;
                    $comboProductDetail->product_qty = $data['selected_product_qty'][$key];
                    $comboProductDetail->save();
                }
            }
        } else {
            $product = Product::findOrFail($id);
            if (isset($data['file'])) {
                if (File::exists($product->image_source)) {
                    File::delete($product->image_source);
                }
                $data = Arr::add($data, 'image_source', $this->saveImage($data['file'], 94, 94));
            }
            $data = Arr::add($data, 'description', $data['product_description']);
            $product->fill(Arr::except($data, ['product_description']))->save();

            if ($data['product_type'] == 'Variable') {
                ProductVariations::where('product_id', $id)->delete();
                foreach (ProductSku::where('product_id', $id)->get() as $p_sku) {
                    $comboExist = ComboProductDetail::where('product_sku_id', $p_sku->id)->first();
                    if ($comboExist) {
                        $comboExist->delete();
                    }
                }

                if (!empty($data['selected_variant'])) {
                    $selected_variant = count($data['selected_variant']);
                    $variation_type_combination = collect($data['variation_type'])->chunk($selected_variant)->toArray();
                    $variation_value_combination = collect($data['variation_value_id'])->chunk($selected_variant)->toArray();
                    $product_variations = [];
                    foreach ($variation_type_combination as $key => $combined_value) {
                        if (array_key_exists('product_sku_ids', $data) && array_key_exists($key, $data['product_sku_ids'])) {
                            $id = $data['product_sku_ids'][$key];
                            $productSku = ProductSku::find($id);
                        } else {
                            $productSku = new ProductSku();
                        }

                        $productSku->product_id = $product->id;
                        $productSku->sku = $data['variation_sku'][$key];
                        $productSku->cost_of_goods = $data['purchase_prices'][$key] ?? 0;
                        $productSku->alert_quantity = $data['alert_quantities'][$key] ?? 0;
                        $productSku->purchase_price = $data['purchase_prices'][$key] ?? 0;
                        $productSku->selling_price = $data['selling_prices'][$key] ?? 0;
                        $productSku->min_selling_price = $data['min_selling_prices'][$key] ?? 0;
                        $productSku->tax = $data['tax'];
                        $productSku->tax_type = 'percent';
                        $productSku->barcode_type = $data['barcode_type'];
                        $productSku->save();
                        $product_variations[] = [
                            'product_id' => $product->id,
                            'variant_id' => json_encode(array_values($combined_value)),
                            'product_sku_id' => $productSku->id,
                            'variant_value_id' => json_encode(array_values($variation_value_combination[$key])),
                            'image_source' => isset($data['variation_file'][$key]) ? $this->saveImage($data['variation_file'][$key], 94, 94) : $data['old_image'][$key],
                            'created_by' => Auth::user()->id ?? null,
                            'updated_by' => Auth::user()->id ?? null,
                            'created_at' => Carbon::now(),
                        ];

                        foreach ($data['variation_value_id'] as $value) {
                            $variation_value = VariantValues::where('id', $value)->where('used', 0)->first();
                            if ($variation_value) {
                                $variation_value->used = 1;
                                $variation_value->save();
                            }
                        }
                    }
                    ProductVariations::insert($product_variations);
                }
            } else {
                $productSku = ProductSku::where('product_id', $id)->first();

                if ($data['product_type'] == 'Service') {
                    $data['selling_price'] = $data['hourly_rate'];
                }

                if (!empty($data['product_sku'])) {
                    $productSku->sku = $data['product_sku'];
                    $productSku->cost_of_goods = $data['purchase_price'];
                    $productSku->alert_quantity = $data['alert_quantity'];
                    $productSku->purchase_price = $data['purchase_price'];
                    $productSku->selling_price = $data['selling_price'];
                    $productSku->min_selling_price = $data['min_selling_price'] ?? 0;
                }
                $productSku->tax = $data['tax'];
                $productSku->tax_type = $data['tax_type'];
                $productSku->barcode_type = $data['barcode_type'];
                $productSku->save();
            }
        }
        DB::commit();
    }

    public function delete($id): void
    {
        $product = Product::findOrFail($id);
        $variations = ProductVariations::where('product_id', $id)->get();
        $productSkus = ProductSku::where('product_id', $id)->get();
        foreach ($productSkus as $p_sku) {
            $comboDetails = ComboProductDetail::where('product_sku_id', $p_sku->id)->first();
            if ($comboDetails != null) {
                $comboDetails->delete();
            }
        }
        ProductSku::where('product_id', $id)->delete();
        if (File::exists($product->image_source)) {
            File::delete($product->image_source);
        }
        foreach ($variations as $variation) {
            if (File::exists($variation->image_source)) {
                File::delete($variation->image_source);
            }
        }
        $product->delete();
    }

    public function deleteCombo($id): void
    {
        $comboProduct = ComboProduct::findOrFail($id);
        if (File::exists($comboProduct->image_source)) {
            File::delete($comboProduct->image_source);
        }
        foreach ($comboProduct->combo_products as $comboDetails) {
            $comboDetails->delete();
        }
        $comboProduct->delete();
    }

    public function decreaseQuantity($id, $quantity): void
    {
        $product = ProductSku::find($id);
        $product->stock_quantity -= $quantity;
        $product->save();
    }

    public function increaseQuantity($id, $quantity): void
    {
        $product = ProductSku::find($id);
        $product->stock_quantity += $quantity;
        $product->save();
    }

    public function getPrice($ids, $purchasePrice, $sellPrice)
    {
        $item = ProductSku::whereIn('id', $ids)->with('product')->get();
        $data['name'] = $item;
        $data['newpurchasePrice'] = $item->sum('purchase_price');
        $data['newsellPrice'] = $item->sum('selling_price') * ((($item->sum('tax') / $item->count('tax')) / 100) + 1);

        return $data;
    }

    public function checkQuantity($data)
    {
        $msg = '';

        if (array_key_exists('house', $data) && !$data['house']) {
            $msg = trans('sale.Select Warehouse or Showroom');

            return $msg;
        }

        if (array_key_exists('house', $data) && !empty($data['house'])) {
            $type = explode('-', $data['house']);
            if ($type[0] == 'warehouse') {
                $house = WareHouse::find($type[1]);
            } else {
                $house = ShowRoom::find($type[1]);
            }
        } else {
            $house = ShowRoom::find(session()->get('showroom_id'));
        }

        if (array_key_exists('type', $data) && $data['type'] == 'combo') {
            $combo_products = ComboProductDetail::where('combo_product_id', 1)->get();
            foreach ($combo_products as $key => $product) {
                $quantity = $house->stocks()->where('product_sku_id', $product->product_sku_id)->first();
                $product_quantity = $data['quantity'] * $product->product_qty;
            }
        } else {
            $quantity = $house->stocks()->where('product_sku_id', $data['id'])->first();

            if (!$quantity) {
                $msg = trans('product.Oops,product not available');

                return $msg;
            }
            $stock = $quantity->stock;
            if ($data['quantity'] > $stock) {
                $msg = trans('product.In your stock you have only') . ' ' . $stock . ' ' . trans('product.items left');
            }
        }

        return $msg;
    }

    public function checkNumberofQuantity($data)
    {
        $msg = '';

        if (array_key_exists('house', $data) && !empty($data['house'])) {
            $type = explode('-', $data['house']);
            if ($type[0] == 'warehouse') {
                $house = WareHouse::find($type[1]);
            } else {
                $house = ShowRoom::find($type[1]);
            }
        } else {
            $house = ShowRoom::find(session()->get('showroom_id'));
        }

        if (array_key_exists('type', $data) && $data['type'] == 'combo') {
            $combo_products = ComboProductDetail::where('combo_product_id', 1)->get();
            foreach ($combo_products as $key => $product) {
                $quantity = $house->stocks()->where('product_sku_id', $product->product_sku_id)->first();
                $product_quantity = $data['quantity'] * $product->product_qty;
            }
        } else {
            $quantity = $house->stocks()->where('product_sku_id', $data['id'])->first();

            if (!$quantity) {
                $msg = 0;

                return $msg;
            }
            $stock = $quantity->stock;
            if ($data['quantity'] > $stock) {
                $msg = $stock;
            }
        }

        return $msg;
    }

    public function productList($id, $type)
    {
        $productList = [];

        $products = $this->allHouseProduct($id, $type);
        $combos = $this->houseComboProduct($id, $type);

        foreach ($products as $key => $product) {
            $item = new stdClass();
            $item->product_name = $product->product_name;
            $item->product_type = $product->product_type;
            $item->image_source = $product->image_source;
            $item->origin = $product->origin;
            $item->brand_name = @$product->brand->name;
            $item->model_name = @$product->model->name;
            if ($product->product_type == 'Single') {
                $sku = $product->skus->first();
                $item->product_id = $sku->id;
                $item->product_sku = $sku->sku;
            } else {
                $item->product_id = $product->id;
                $item->product_sku = '';
            }
            $productList[] = $item;
        }
        foreach ($combos as $key => $product) {
            $item = new stdClass();
            $item->product_id = $product->id;
            $item->product_name = $product->name;
            $item->origin = $product->origin;
            $item->product_sku = '';
            $item->product_type = 'Combo';
            $item->brand_name = @$product->brand->name;
            $item->model_name = @$product->model->name;
            $item->image_source = $product->image_source;
            $productList[] = $item;
        }

        return $productList;
    }

    public function serviceList($id, $type)
    {
        $productList = [];

        $services = $this->allService();

        foreach ($services as $key => $product) {
            $item = new stdClass();

            $item->product_id = $product->skus->first()->id;

            $item->product_name = $product->product_name;
            $item->product_type = $product->product_type;
            $item->brand_name = @$product->brand->name;
            $item->model_name = @$product->model->name;
            $item->image_source = $product->image_source;

            $productList[] = $item;
        }

        return $productList;
    }

    public function stockProductList($type, $id, $house)
    {
        $ProductList = [];
        $products = $type == 'purchase' ? $this->productForPurchase() : $this->allHouseProduct($id, $house);

        foreach ($products as $key => $product) {
            $item = new stdClass();
            if ($product->product_type == 'Single') {
                $item->product_id = $product->skus->first()->id;
            } else {
                $item->product_id = $product->id;
            }
            $item->product_name = $product->product_name;
            $item->product_type = $product->product_type;
            $item->brand = @$product->brand->name;
            $item->model = @$product->model->name;
            $item->origin = @$product->origin;
            $ProductList[] = $item;
        }
        $execpt_service = ['purchase', 'transfer'];

        if (!in_array($type, $execpt_service)) {
            $services = $this->allService();

            foreach ($services as $key => $product) {
                $item = new stdClass();

                $item->product_id = $product->skus->first()->id;

                $item->product_name = $product->product_name;
                $item->product_type = $product->product_type;

                $ProductList[] = $item;
            }
        }

        return $ProductList;
    }

    public function stockAlert($type)
    {
        if ($type == 'all') {
            return ProductSku::latest()->get();
        }

        return ProductSku::latest()->take(10)->get();
    }

    public function csv_upload_single_product($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                $product = Product::create([
                    $column_name[0] => $row[0],
                    $column_name[1] => $row[1],
                    $column_name[2] => $row[2],
                    $column_name[3] => $row[3],
                    $column_name[4] => $row[4],
                    $column_name[5] => $row[5],
                    $column_name[6] => $row[6],
                    $column_name[7] => $row[7],
                ]);
                $product_sku = ProductSku::create([
                    'product_id' => $product->id,
                    'barcode_id' => '1000-' . $product->id . '-' . Str::random(12),
                    'barcode_type' => 'C39',
                    'tax_type' => '%',
                    $column_name[8] => ($row[8] != null) ? $row[8] : '1000-' . $product->id . '-' . Str::random(12),
                    $column_name[9] => $row[9],
                    $column_name[10] => $row[10],
                    $column_name[11] => $row[11],
                    $column_name[12] => $row[12],
                    $column_name[13] => $row[13],
                    $column_name[14] => $row[14],
                ]);
                $stock_report = StockReport::create([
                    'product_sku_id' => $product_sku->id,
                    'houseable_id' => session()->get('showroom_id'),
                    'houseable_type' => 'Modules\Inventory\Entities\ShowRoom',
                    'stock_date' => date('Y-m-d'),
                    $column_name[15] => ($row[15] != null) ? $row[15] : 0,
                ]);

                if ($stock_report->stock > 0) {
                    $productHistory = ProductHistory::create([
                        'type' => 'begining',
                        'date' => Carbon::now()->toDateString(),
                        'in_out' => $stock_report->stock,
                        'product_sku_id' => $stock_report->product_sku_id,
                        'itemable_id' => session()->get('showroom_id'),
                        'itemable_type' => 'Modules\Inventory\Entities\ShowRoom',
                        'houseable_id' => session()->get('showroom_id'),
                        'houseable_type' => 'Modules\Inventory\Entities\ShowRoom',
                    ]);
                }

                $main_amount = $product_sku->purchase_price * $stock_report->stock;
                $sub_account_id[0] = ChartAccount::where('code', '02-09-11')->first()->id;
                $sub_amount[0] = $main_amount;
                $sub_narration[0] = 'Beginning Stock Added By Showroom - ' . ShowRoom::find(session()->get('showroom_id'))->name;
                if ($stock_report->stock > 0) {
                    $repo = new JournalRepository();
                    $repo->create([
                        'voucher_type' => 'JV',
                        'amount' => $main_amount,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'account_type' => 'debit',
                        'payment_type' => 'journal_voucher',
                        'account_id' => $this->defaultPurchaseAccount(),
                        'main_amount' => $main_amount,
                        'narration' => 'Beginning Stock Added By Showroom',
                        'sub_account_id' => $sub_account_id,
                        'sub_amount' => $sub_amount,
                        'sub_narration' => $sub_narration,
                        'sale_id' => null,
                        'sale_class' => null,
                        'is_approve' => (app('business_settings')->where('type', 'beginning_stock_voucher_approval')->first()->status == 1) ? 1 : 0,
                    ]);
                }
            }
        }
    }
}
