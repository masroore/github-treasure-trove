<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shop\SaleOptionsRequest;
use App\Http\Requests\Admin\Shop\SaleRequest;
use App\Http\Traits\MediaLibraryManageTrait;
use App\Managers\SaleManager;
use App\Models\Shop\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    use MediaLibraryManageTrait;

    protected $saleManager;

    /**
     * SaleController constructor.
     *
     * @param $saleManager
     */
    public function __construct(SaleManager $saleManager)
    {
        $this->saleManager = $saleManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('sale.read');

        $sales = Sale::filterable($request->get('filter', []))
            //->sortable('id')
            ->byLocales()
            ->orderBy('end_at')
            ->paginate();

        return view('admin.shop.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shop.sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        $this->authorize('sale.create');

        $sale = Sale::create($request->validated());

        $this->manageMedia($sale, $request);

        $destination = $request->get('destination', route('admin.sales.edit', $sale));

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
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);

        return view('admin.shop.sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, $id)
    {
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);
        $sale->update($request->only('publish', 'name', 'description', 'type', 'start_at', 'end_at', 'dateless'));
        $sale->setAttribute('data->msg_after_prepare', $request->input('data.msg_after_prepare'));
        $sale->save();

        $this->manageMedia($sale, $request);

        $destination = $request->get('destination', route('admin.sales.edit', $sale));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
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
        $this->authorize('sale.delete');

        $sale = Sale::findOrFail($id);
        $sale->products()->detach();
        $sale->terms()->detach();
        $sale->delete();
        $destination = $request->session()->pull('destination', route('admin.sales.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    public function options($id)
    {
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);
        $tab = 'options';
        $promoCodes = $sale->promoCodes;

        return view('admin.shop.sales.edit', compact('sale', 'tab', 'promoCodes'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function optionsSave(SaleOptionsRequest $request, $id)
    {
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);

        $this->saleManager->saveOptions($sale, $request->all());

        $destination = $request->session()->pull('destination', route('admin.sales.options', [$sale]));

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
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);
        $tab = 'seo';

        return view('admin.shop.sales.edit', compact('sale', 'tab'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function seoSave(Request $request, $id)
    {
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($id);

        $sale->metaTag()->updateOrCreate([], $request->get('meta_tag'));

        $destination = $request->session()->pull('destination', route('admin.sales.edit', $sale));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }
}
