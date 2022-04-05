<?php

namespace App\Http\Controllers;

use App\Allcountry;
use App\AutoDetectGeo;
use App\CurrencyCheckout;
use App\CurrencyNew;
use App\Location;
use App\ManualPaymentMethod;
use App\multiCurrency;
use Carbon\Carbon;
use DataTables;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MultiCurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['IsInstalled', 'admin_access', 'switch_lang']);
        $this->middleware(['permission:currency.manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all_country = Allcountry::join('countries', 'countries.country', '=', 'allcountry.iso3')->select('allcountry.*')->get();

        $check_cur = multiCurrency::wherehas('currency')->with('currencyLocationSettings')->with('checkoutCurrencySettings')->get();

        $manualpaymentmethods = ManualPaymentMethod::where('status', '1')->get();

        $auto_geo = AutoDetectGeo::first();

        $currencies = CurrencyNew::with('currencyextract');

        if ($request->ajax()) {
            return DataTables::of($currencies)
                ->addIndexColumn()
                ->addcolumn('code', function ($row) {
                    $html = $row->code;

                    if (isset($row->currencyextract) && 1 == $row->currencyextract->default_currency) {
                        $html .= " <label role='button' class='badge badge-primary'>" . __('Default') . '</label>';
                    }

                    return $html;
                })
                ->addColumn('rate', function ($row) {
                    return $row->exchange_rate;
                })
                ->addColumn('additional_amount', function ($row) {
                    return isset($row->currencyextract) ? $row->currencyextract->add_amount : 0;
                })
                ->editColumn('symbol', function ($row) {
                    $symbol = $row->currencyextract['currency_symbol'];

                    return "<i class='$symbol'></i>";
                })
                ->editColumn('action', 'admin.multiCurrency.action')
                ->rawColumns(['code', 'rate', 'additional_amount', 'symbol', 'action'])
                ->make(true);
        }

        return view('admin.multiCurrency.index', compact('auto_geo', 'all_country', 'check_cur', 'manualpaymentmethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:3',
        ], [
            'code.required' => __('Currency code is required'),
            'code.string' => __('Currency code should not be numeric'),
            'code.max' => __('Currency code cannot be greater than 3'),
        ]);

        try {
            Artisan::call('currency:manage add ' . $request->code);

            $output = Artisan::output();

            if (!strstr($output, 'success')) {
                return back()->withErrors($output)->withInput();
            }

            $currency = CurrencyNew::firstWhere('code', $request->code);

            $currency->currencyextract()->updateorCreate([

                'id' => $currency->id,

            ], [
                'add_amount' => $request->add_amount ?? 0.00,
                'currency_symbol' => $request->currency_symbol,
                'default_currency' => 0,
                'position' => $request->position,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Artisan::call('currency:update -o');

            notify()->success('Added', __('Currency :code added !', ['code' => $request->code]));
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return back()
            ->with('category_message', __('Currency Has Been Created'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $currency = DB::table('currency_list')->where('id', $request->currency_id)
            ->first();

        $currency = multiCurrency::where('id', $request->id)
            ->update([
                'currency_id' => $request->currency_id,
            ]);

        return response()
            ->json([
                'id' => $currency->id,
                'code' => $currency->code,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $currency = CurrencyNew::where('code', '=', $code)->first();

        if ($currency) {
            if (isset($currency->currencyextract)) {
                $currency->currencyextract()->update([
                    'currency_symbol' => $request->currency_symbol,
                    'add_amount' => $request->add_amount,
                    'position' => $request->position,
                ]);
            } else {
                $currency->currencyextract()->create([
                    'currency_id' => $currency->id,
                    'add_amount' => $request->add_amount ?? 0.00,
                    'currency_symbol' => $request->currency_symbol,
                    'default_currency' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            notify()->info('Updated', __('Currency :code updated !', ['code' => $currency->code]));

            return back();
        }

        return back()->with('warning', __('Currency not found !'));
    }

    public function auto_update_currency(Request $request)
    {
        if ($request->ajax()) {
            try {
                Artisan::call('currency:update -o');

                return response()->json(__('Auto Update Successfully !'));
            } catch (Exception $e) {
                return response()->json($e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = multiCurrency::find($id);

        if ($obj->checkoutCurrencySettings) {
            $obj->checkoutCurrencySettings->delete();
        }

        if ($obj->currencyLocationSettings) {
            $obj->currencyLocationSettings->delete();
        }

        currency()->delete($obj->currency->code);

        $obj->delete();
        notify()->error(__('Currency deleted successfully !'));

        return back();
    }

    public function addLocation(Request $request)
    {
        $currs = multiCurrency::all();
        foreach ($currs as $curr) {
            $id = 'country' . $curr->id;
            $multi_curr = 'multi_curr' . $curr->id;
            $multi_currency = 'multi_currency' . $curr->id;

            if ('on' == $request->auto_detect) {
                $geo = '1';
            } else {
                $geo = '0';
            }

            $check_loc = Location::where('multi_currency', $curr->id)
                ->first();
            if (!empty($check_loc)) {
                if (!empty($request->$id)) {
                    $child_cat = implode(',', $request->$id);
                    Location::where('multi_currency', $curr->id)
                        ->update([
                            'currency' => $request->$multi_curr,
                            'country_id' => $child_cat,
                            'multi_currency' => $request->$multi_currency,

                        ]);
                } else {
                    Location::where('multi_currency', $curr->id)
                        ->update([
                            'currency' => $request->$multi_curr,
                            'country_id' => $request->$id,
                            'multi_currency' => $request->$multi_currency,

                        ]);
                }
            } else {
                if (\is_array($request[$id])) {
                    if (!empty($request->$id)) {
                        $child_cat = implode(',', $request->$id);
                        Location::insert([
                            'currency' => $request->$multi_curr,
                            'country_id' => $child_cat,

                            'multi_currency' => $request->$multi_currency,

                        ]);
                    } else {
                        Location::insert([
                            'currency' => $request->$multi_curr,
                            'country_id' => $request->$id,

                            'multi_currency' => $request->$multi_currency,

                        ]);
                    }
                }
            }
        }

        return back()->with('updated', __('Currency setting updated !'));
    }

    public function editLocation(Request $request): void
    {
        $child_cat = implode(',', $request->country);
        Location::where('multi_currency', $request->id)
            ->update([

                'country_id' => $child_cat,
                'currency' => $request->currency,

            ]);
    }

    public function deleteLocation($id)
    {
        $obj = Location::where('multicurrency', $id)->first;
        $obj->delete();

        return back();
    }

    public function auto_change(Request $request)
    {
        $g = multiCurrency::where('id', $request->id)
            ->update([
                $request->name => $request->value,
            ]);
        if ($g) {
            return 'save';
        }

        return 'try agin';
    }

    public function auto_detect_location(Request $request)
    {
        $myip = $_SERVER['REMOTE_ADDR'];
        $ip = geoip()->getLocation($myip);

        $auto_detect = AutoDetectGeo::first();
        if (isset($auto_detect)) {
            if (null != $request->auto) {
                if (1 == $request->auto) {
                }
                AutoDetectGeo::where('id', '1')
                    ->update([
                        'auto_detect' => $request->auto,

                    ]);
            } elseif (null != $request->currencybyc) {
                AutoDetectGeo::where('id', '1')
                    ->update([

                        'currency_by_country' => $request->currencybyc,
                    ]);
            } elseif (null != $request->country_id) {
                if (0 == $request->country_id) {
                    $default_geo_location = null;
                } else {
                    $default_geo_location = $request->country_id;
                }
                AutoDetectGeo::where('id', '1')
                    ->update([

                        'default_geo_location' => $default_geo_location,

                    ]);
            } elseif (null != $request->checkout_currency) {
                AutoDetectGeo::where('id', '1')
                    ->update([

                        'checkout_currency' => $request->checkout_currency,

                    ]);
            } elseif (null != $request->cart_page) {
                AutoDetectGeo::where('id', '1')
                    ->update([

                        'enable_cart_page' => $request->cart_page,

                    ]);
            } elseif (null != $request->enable_multicurrency) {
                AutoDetectGeo::where('id', '1')
                    ->update([

                        'enabel_multicurrency' => $request->enable_multicurrency,

                    ]);
            }
        } else {
            AutoDetectGeo::insert([
                'auto_detect' => $request->auto,

                'currency_by_country' => $request->currencybyc,
            ]);
        }

        $flag = strtolower($ip->iso_code);

        $flag_url = url('/admin/flags/4x3/' . $flag . '.svg');

        return response()->json([
            'country' => $ip->country,
            'isoCode' => $flag_url,
        ]);
    }

    public function checkOutUpdate(Request $request): void
    {
        echo $request->default_checkout;

        $show_checkout = CurrencyCheckout::where('multicurrency_id', $request->currencyId)
            ->first();
        if (!empty($show_checkout)) {
            if (\is_array($request->payment)) {
                $payments = implode(',', $request->payment);

                CurrencyCheckout::where('multicurrency_id', $request->currencyId)
                    ->update([

                        'currency' => $request->currency_checkout,
                        'default' => $request->default_checkout,
                        'checkout_currency' => $request->checkout_currency_status,
                        'payment_method' => $payments,
                        'multicurrency_id' => $request->currencyId,

                    ]);
            } else {
                CurrencyCheckout::where('multicurrency_id', $request->currencyId)
                    ->update([

                        'currency' => $request->currency_checkout,
                        'default' => $request->default_checkout,
                        'checkout_currency' => $request->checkout_currency_status,
                        'payment_method' => $request->payment,
                        'multicurrency_id' => $request->currencyId,

                    ]);
            }
        } else {
            if (\is_array($request->payment)) {
                $payments = implode(',', $request->payment);
                CurrencyCheckout::insert([
                    'currency' => $request->currency_checkout,
                    'default' => $request->default_checkout,
                    'checkout_currency' => $request->checkout_currency_status,
                    'payment_method' => $payments,
                    'multicurrency_id' => $request->currencyId,
                ]);
            } else {
                CurrencyCheckout::insert([
                    'currency' => $request->currency_checkout,
                    'default' => $request->default_checkout,
                    'checkout_currency' => $request->checkout_currency_status,
                    'payment_method' => $request->payment,
                    'multicurrency_id' => $request->currencyId,
                ]);
            }
        }
    }

    public function defaul_check_checkout(Request $request): void
    {
        CurrencyCheckout::where('multicurrency_id', '<>', $request->id)
            ->update([

                'default' => '0',
            ]);
        CurrencyCheckout::where('multicurrency_id', $request->id)
            ->update([

                'default' => $request->default_checkout,

            ]);
    }
}
