<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shop\ProductRequest;
use App\Http\Traits\MediaLibraryManageTrait;
use App\Managers\ProductManager;
use App\Models\Shop\Product;
use App\Models\Shop\ProductGroup;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use MediaLibraryManageTrait;

    protected $productManager;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('product.read');

        $filter = $request->get('filter'); //TODO admin product filter

        // Список товаров.
        if ($request->session()->get('show_products_type_list')) {
            $products = Product::when($filter, function ($q) use ($filter): void {
                $q->filterable($filter);
            })
                ->byLocales()
                ->with('values', 'urlAlias', 'group.product', 'media', 'group.products.txCategory', 'txCategory')
                ->orderBy('product_group_id', 'desc')->orderBy('created_at', 'asc')
                ->paginate();

            return view('admin.shop.products.index', compact('products'));
        }

        // Список груп товаров.
        $productGroups = ProductGroup::whereHas('products', function ($p) use ($filter): void {
            $p->filterable($filter)->byLocales();
        })
            ->with('products', 'products.values', 'products.urlAlias', 'products.group', 'products.media', 'products.txCategory', 'product', 'product.txCategory')
            ->orderBy('id', 'desc')
            ->simplePaginate();
//        dd($productGroups);

        return view('admin.shop.products.groups', compact('productGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $group = ProductGroup::find($request->product_group_id);
        $product = $request->product_id ? Product::find($request->product_id) : optional($group)->product;
        if ($request->get('locale') && $product) {
            $product->locale = $request->get('locale');
        }

        return view('admin.shop.products.create', compact('group', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('product.create');

        $product = $this->productManager->store($request->all());

        $this->manageMedia($product, $request);

        $destination = $request->get('destination', route('admin.products.edit', $product));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.shop.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $this->authorize('product.edit');

//        dd($request->specification);

        /** @var Product $product */
        $product = Product::findOrFail($id);

        //$product->addMediaFromRequest($request->specification)->toMediaCollection('specification');

        $product = $this->productManager->update($product, $request->all());

        $this->manageMedia($product, $request);

        $destination = $request->session()->pull('destination', route('admin.products.edit', $product));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('product.delete');

        $product = Product::findOrFail($id);

        $destination = $request->session()->pull('destination', route('admin.products.index'));
        if ($product->group && $product->group->products->count() > 1 && $product->group->default_product_id == $id) {
            return redirect()->to($destination)
                ->with('error', trans('notifications.destroy.error_children'));
        }

        $product->delete();

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * TODO: is not used.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function groupDestroy($id)
    {
        $this->authorize('product.delete');

        $group = ProductGroup::findOrFail($id);

        $group->products()->each(function ($p) {
            return $p->delete();
        });

        $group->delete();

        return redirect()->route('admin.products.index')
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * Set default product for group.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function groupDefaultProduct($id, Request $request)
    {
        $this->authorize('product.update');

        $product = Product::findOrFail($id);

        $product->group->default_product_id = $id;
        $product->group->save();

        if ($request->ajax()) {
            return response()->json(['message' => trans('notifications.store.success')])
                ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
        }
        $destination = $request->session()->pull('destination', route('admin.products.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * Data search for select autocomplete.
     *
     * @return array
     */
    public function autocomplete(Request $request)
    {
        if ($request->has('q') && strlen($request->get('q'))) {
            $terms = Product::select('name', 'sku', 'id')
                ->where('name', 'LIKE', "%$request->q%")
                ->orWhere('sku', 'LIKE', "%$request->q%")
                ->orderBy('id', 'desc')
                ->limit($request->get('limit', 500))
                ->get();

            $result = $terms->map(function ($item) {
                return [
                    'text' => $item->name,  // 'label' => $item->name,
                    'id' => $item->id,      // 'value' => $item->id,
                ];
            })->toArray();

            return ['results' => $result];
        }

        return ['results' => []];
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function values($id)
    {
        $this->authorize('product.update');

        $product = Product::findOrFail($id);
        $tab = 'values';

        return view('admin.shop.products.edit', compact('product', 'tab'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function valuesSave(Request $request, $id)
    {
        $this->authorize('product.update');

        $product = Product::findOrFail($id);

        $values = [];
        foreach ($request->get('values', []) as $attribute => $attributeValues) {
            if (!empty($attributeValues)) {
                $attributeValues = is_array($attributeValues) ? $attributeValues : [$attributeValues];
                $values = array_merge($values, $attributeValues);
            }
        }

        $product->values()->sync($values);

        $destination = $request->session()->pull('destination', route('admin.products.edit', $product));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seo($id)
    {
        $this->authorize('product.update');

        $product = Product::findOrFail($id);
        $tab = 'seo';

        return view('admin.shop.products.edit', compact('product', 'tab'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function seoSave(Request $request, $id)
    {
        $this->authorize('product.update');

        $product = Product::findOrFail($id);

        //if ($request->has('url_alias')) {
        //    $product->updateOrCreateUrlAlias($request->url_alias);
        //}

        $product->metaTag()->updateOrCreate([], $request->get('meta_tag'));

        $destination = $request->session()->pull('destination', route('admin.products.edit', $product));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }
}
