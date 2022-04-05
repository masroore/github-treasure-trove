<?php

namespace App\Http\Controllers\Front\Shop;

use App\Helpers\Currency\Facades\Currency;
use App\Helpers\FacetFilter\FacetFilterBuilder;
use App\Http\Controllers\Controller;
use App\Managers\ProductManager;
use App\Models\Shop\Attribute;
use App\Models\Shop\Product;
use App\Models\Shop\ProductGroup;
use App\Models\Shop\ProductReview;
use App\Models\Shop\Value;
use App\Models\Taxonomy\Term;
use FacetFilter;
use Illuminate\Http\Request;
use URL;
use UrlAlias;

class ProductController extends Controller
{
    protected $productManager;

    protected $productTiningId;

    /**
     * ProductController constructor.
     *
     * @param $productManager
     */
    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($id)
    {
        $product = Product::isPublish()->whereHas('txCategory')->findOrFail($id);

//        dd($product->attrsAncestorsCategories($product));

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tiningValues = Value::where('attribute_id', $this->productTiningId)->get();

        //Каталог PDF
//        $catalogPdf = \Illuminate\Support\Facades\Storage::disk('public')->url(variable('file_catalog'));

        $reviews = ProductReview::isPublish()->where('product_id', $product->id)->orderByDesc('created_at')->get(); //$product->group->reviews()->isPublish()->get();

        [$uniqueAttributes, $valuesTree] = $this->productManager->cardAttributesValuesBuild($product); // TODO: add cached ?

        $recommends = Product::isPublish()->where('id', '<>', $id)->where('category_id', $product->txCategory->id)
            ->withBase()->with('txCategory')->limit(8)->inRandomOrder()
            ->get()
            ->unique('product_group_id');

        $priceColor = '';
        $priceColorCurrent = '';
        $priceColorOld = '';

        // TODO: add check AJAX request
        return view('front.products.product', [
            'tining' => $tiningValues,
            'product' => $product,
            'attributes' => $uniqueAttributes,
            'valuesTree' => $valuesTree,
            'reviews' => $reviews,
            'recommends' => $recommends,
            'priceColor' => $priceColor,
            'priceColorCurrent' => $priceColorCurrent,
            'priceColorOld' => $priceColorOld,
            //            'consumption' => $consumption->value,
        ]);
    }

    public function updateProduct(Request $request)
    {
        $product = Product::findOrFail($request->get('id'));
        $reviews = ProductReview::isPublish()->where('product_id', $product->id)->orderByDesc('created_at')->get();
        $recommends = Product::isPublish()->where('id', '<>', $product->id)->where('category_id', $product->txCategory->id)
            ->withBase()->with('txCategory')->limit(8)->inRandomOrder()->get()->unique('product_group_id');

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        $priceColor = '';
        $priceColorCurrent = '';
        $priceColorOld = '';

        if ($request->get('colorId')) {
            $color = Value::findOrFail($request->get('colorId'));
            $productPriceColor = $this->getCalculatePriceColor($product, $color->id);
            $priceColor = Currency::format($productPriceColor);
            $priceColorCurrent = Currency::getConvertsStr($productPriceColor, $product->currency);
            $priceColorOld = Currency::format($this->getCalculateOldPriceColor($product, $color->id));
        }

        $destination = $request->session()->pull('destination', URL::previous());

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                'html' => view('front.products.inc.product-content', compact('product', 'tining', 'priceColor', 'priceColorCurrent', 'priceColorOld', 'reviews', 'recommends'))->render(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function updateProductCount(Request $request)
    {
        $quantity = (int) ($request->get('quantity'));
        $product = Product::findOrFail($request->get('id'));
        $reviews = ProductReview::isPublish()->where('product_id', $product->id)->orderByDesc('created_at')->get();
        $recommends = Product::isPublish()->where('id', '<>', $product->id)->where('category_id', $product->txCategory->id)
            ->withBase()->with('txCategory')->limit(8)->inRandomOrder()->get()->unique('product_group_id');

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        $priceColor = '';
        $priceColorCurrent = '';
        $priceColorOld = '';

        if ($quantity > 0) {
            if ($request->get('colorId')) {
                $color = Value::findOrFail($request->get('colorId'));

                $productPriceColor = $this->getCalculatePriceColor($product, $color->id) * $quantity;
                $priceColor = Currency::format($productPriceColor);
                $priceColorCurrent = Currency::getConvertsStr($productPriceColor, $product->currency);

                if ($product->getCalculatePrice('price_old')) {
                    $priceColorOld = Currency::format($this->getCalculateOldPriceColor($product, $color->id) * $quantity);
                }
            } else {
                $productPriceColor = $product->getCalculatePrice('price') * $quantity;
                $priceColor = Currency::format($productPriceColor);

                $priceColorCurrent = Currency::getConvertsStr($productPriceColor, $product->currency);

                if ($product->getCalculatePrice('price_old')) {
                    $priceColorOld = Currency::format($product->getCalculatePrice('price_old') * $quantity);
                }
            }
        }

        $destination = $request->session()->pull('destination', URL::previous());

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                'html' => view('front.products.inc.product-content', compact('product', 'priceColor', 'tining', 'priceColorCurrent', 'priceColorOld', 'reviews', 'recommends'))->render(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function updateProductGroup(Request $request)
    {
        $product = Product::findOrFail($request->get('id'));
        $destination = $request->session()->pull('destination', URL::previous());

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                'html' => view('front.products.inc.single-product', compact('product', 'tining'))->render(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function colorClear(Request $request)
    {
        $quantity = $request->get('quantity');
        $product = Product::findOrFail($request->get('id'));
        $reviews = ProductReview::isPublish()->where('product_id', $product->id)->orderByDesc('created_at')->get();
        $recommends = Product::isPublish()->where('id', '<>', $product->id)->where('category_id', $product->txCategory->id)
            ->withBase()->with('txCategory')->limit(8)->inRandomOrder()->get()->unique('product_group_id');

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        $priceColor = '';
        $priceColorCurrent = '';
        $priceColorOld = '';

        if ($quantity > 1) {
            $price = $product->getCalculatePrice('price') * $quantity;
            $priceColor = Currency::format($price);

            $priceColorCurrent = Currency::getConvertsStr($price, $product->currency);

            if ($product->getCalculatePrice('price_old')) {
                $priceColorOld = Currency::format($product->getCalculatePrice('price_old') * $quantity);
            }
        }

        $destination = $request->session()->pull('destination', URL::previous());

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                'html' => view('front.products.inc.product-content', compact('product', 'priceColor', 'tining', 'priceColorCurrent', 'priceColorOld', 'reviews', 'recommends'))->render(),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function productColor(Request $request)
    {
        $quantity = (int) ($request->get('quantity'));
        $color = Value::findOrFail($request->get('colorId'));
        $product = Product::findOrFail($request->get('productId'));

        $product->txCategory->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });

        $tining = Value::where('attribute_id', $this->productTiningId)->get();

        $productPriceColor = $this->getCalculatePriceColor($product, $color->id) * $quantity;
        $priceColor = Currency::format($productPriceColor);
        $priceColorCurrent = Currency::getConvertsStr($productPriceColor, $product->currency);

        $priceColorOld = '';
        if ($product->getCalculatePrice('price_old')) {
            $priceColorOld = Currency::format($this->getCalculateOldPriceColor($product, $color->id) * $quantity);
        }

        $destination = $request->session()->pull('destination', URL::previous());

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.update.success'),
                'color' => $color,
                'tining' => $tining,
                'priceWithColor' => [
                    'priceColor' => $priceColor,
                    'priceColorCurrent' => $priceColorCurrent,
                    'priceColorOld' => $priceColorOld,
                ],
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Get product by category (& category children).
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function category(Request $request, $id)
    {
        $filter = FacetFilter::toArray($request->get(FacetFilterBuilder::$filterUrlKey, ''));

        $category = Term::isPublish()->byVocabulary('product_categories')->findOrFail($id);

        $productGroups = ProductGroup::pluck('default_product_id');
        $productGroups = $productGroups->toArray();
        // category + category children
        $categoryIds = array_merge([$category->id], $category->children->pluck('id')->toArray());

        $categoryTemp = Term::byVocabulary('product_categories')->findOrFail($id);

        [$categoryAttributes, $attributeValues] = $this->productManager->facetAttributesValuesBuild($categoryTemp, $categoryIds, $filter);

        // Products.
        $products = Product::withBase()->with('txCategory')->with('values')->isPublish()->facetFilter($filter)
            ->byTaxonomies(['product_categories' => $categoryIds])
            ->whereIn('id', $productGroups)
            ->sortable(['product_group_id' => 'asc'])->orderBy('created_at', 'asc')
            ->paginate();

        $category->attrs->whereIn('purpose', [Attribute::PURPOSE_TINTING_INTERIOR, Attribute::PURPOSE_TINTING_FACADE])->map(function (Attribute $attribute) {
            return $this->productTiningId = $attribute->id;
        });
        $tiningValues = Value::where('attribute_id', $this->productTiningId)->get();

        // For ajax pagination alias links.
        $products->appends($request->except('page'))
            ->setPath(UrlAlias::current());

        if ($request->ajax()) {
            return response()->json([
                'message' => trans('notifications.operation.success'),
                'html' => view('front.products.inc.grid-products', compact('products'))->render(),
                'nextPageUrl' => $products->nextPageUrl(),
                'paginationLinks' => $products->links()->toHtml(),
            ]);
        }

        return view('front.products.products', [
            'category' => $category,
            'categories' => $category->children,
            'products' => $products,
            'tining' => $tiningValues,
            'facet' => [
                'attributes' => $categoryAttributes,
                'values' => $attributeValues,
            ],
        ]);
    }

    public function categories()
    {
        $categories = Term::isPublish()->byVocabulary('product_categories')
            ->byLocale()
            ->with('urlAlias', 'media')->whereNull('parent_id')->get();

        return view('front.products.categories', compact('categories'));
    }

    public function search(Request $request)
    {
        if ($q = $request->q) {
            $products = Product::isPublish()
                ->byLocale()
                ->whereHas('txCategory')
                ->with('media', 'urlAlias', 'group.product.media', 'reviews')
                ->where(function ($p) use ($q): void {
                    $p->where('name', 'LIKE', "%{$q}%")->orWhere('sku', 'LIKE', "%{$q}%");
                })
                ->sortable(['product_group_id' => 'asc'])->orderBy('created_at', 'asc')
                ->limit($request->get('limit', 300))
                ->paginate(16);

            if ($request->ajax()) {
                //$html = view('front.products.inc.search-result', compact('products'))->render();
                return response()->json([
                    'html' => view('front.products.inc.grid-products', compact('products'))->render(),
                    'nextPageUrl' => $products->appends(request()->except('page'))->nextPageUrl(),
                    'paginationLinks' => $products->links()->toHtml(),
                ]);
            }

            return view('front.products.search', compact('products'));
        }

        $products = Product::whereId(0)->paginate();

        return view('front.products.search', compact('products'));
    }

    public function getCalculatePriceColor(Product $product, $color)
    {
        if ($color) {
            $color = Value::findOrFail($color);
        }
        $price = $product->getCalculatePrice('price');
        if ($color) {
            $price = $price + ($price * $color->markup);

            return $price;
        }

        return $price;
    }

    public function getCalculateOldPriceColor(Product $product, $color)
    {
        if ($color) {
            $color = Value::findOrFail($color);
        }
        if ($product->getCalculatePrice('price_old')) {
            $priceOldCalc = $product->getCalculatePrice('price_old');
            if ($color) {
                $price = $priceOldCalc + ($priceOldCalc * $color->markup);

                return $price;
            }

            return $priceOldCalc;
        }
    }
}
