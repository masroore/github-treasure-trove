<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Helpers\Sales\PromoCodeGenerator;
use App\Http\Controllers\Controller;
use App\Managers\DataEditableManager;
use App\Models\Shop\Sale;
use App\Models\Shop\SalePromoCode;
use Illuminate\Http\Request;
use URL;

class SalePromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function store(SalePromoCodeRequest $request)
    {
        $this->authorize('sale.update');

        $sale = Sale::findOrFail($request->sale_id);

        $sale->promoCodes()->create($request->validated());

        $destination = $request->session()->pull('destination', route('admin.sales.options', [$sale]));
        if ($request->ajax()) {
            return response()->json([
                'action' => 'redirect',    //reset
                'destination' => $destination,
                'message' => trans('notifications.store.success'),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $this->authorize('sale.update');

        $request->validate([
            'amount' => 'required|integer|between:1,100',
            'sale_id' => 'required',
        ]);

        $sale = Sale::findOrFail($request->sale_id);

        $codeGenerator = new PromoCodeGenerator();
        $codes = $codeGenerator->generate($request->amount);
        foreach ($codes as $code) {
            $sale->promoCodes()->create([
                'code' => $code,
                'used_limit' => $request->get('used_limit', 1),
            ]);
        }

        $destination = $request->session()->pull('destination', route('admin.sales.options', [$sale]));
        if ($request->ajax()) {
            return response()->json([
                'action' => 'redirect',    //reset
                'destination' => $destination,
                'message' => trans('notifications.store.success'),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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
        $this->authorize('sale.update');

        $promoCode = SalePromoCode::findOrFail($id);
        $sale = $promoCode->sale;
        $promoCode->delete();

        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.shop.sales.inc.promo-codes-table', [
                    'promoCodes' => $sale->promoCodes()->paginate(),
                    'sale' => $sale,
                ])->render(),
                //'action' => 'redirect',
                //'destination' => $destination,
                'message' => trans('notifications.store.success'),
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function editable(DataEditableManager $dataEditableMng, Request $request, $id)
    {
        $this->authorize('form.update');

        $form = SalePromoCode::findOrFail($id);

        $request->validate([
            'name' => 'required|string',    // field name: email, data[answer],...
            'value' => 'nullable|string',   // field value: Hello world!!!
        ]);

        $dataEditableMng->save($form, $request->name, $request->value);

        return response()->json(['message' => trans('notifications.update.success')]);
    }
}
