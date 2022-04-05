<?php

namespace Modules\AdminCurrency\Http\Controllers;

use App\Models\Currency;
use App\Utils\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'currency',
            'sub_menu' => 'agents',
            'breadcrumb' => Helper::generateBreadCrumb([
                'Currency' => null,
            ]),
        ];

        $currency = Currency::query();

        if ($request->get('from')) {
            $currency->whereDate('date', '>=', $request->from);
        }

        if ($request->get('to')) {
            $currency->whereDate('date', '<=', $request->to);
        }

        if ($request->from && $request->to) {
            $data['currencies'] = $currency->get();
        } else {
            $data['currencies'] = Currency::whereDate('date', today()->format('Y-m-d'))->get();
        }

        return view('admincurrency::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function fetchCurrencyRates()
    {
        try {
            $endpoint = 'https://www.nrb.org.np/forex';

            $data = [
                'dateFrom' => today()->format('Y-m-d'),
                'dateTo' => today()->format('Y-m-d'),
                'export_type' => 'export_json',
            ];

            $ch = curl_init();
            curl_setopt($ch, \CURLOPT_URL, $endpoint);
            curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, \CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($ch, \CURLOPT_POSTFIELDS, http_build_query($data));
            $response = json_decode(curl_exec($ch), true);

            curl_close($ch);

            $currencies = $response[0]['rates'] ?? [];

            $currencyData = [];

            foreach ($currencies as $key => $currency) {
                if ('inr' == $key || 'usd' == $key) {
                    $currencyData[] = [
                        'base_currency' => strtoupper($key),
                        'target_currency' => 'NPR',
                        'base_value' => 'inr' == $key ? 100 : 1,
                        'target_buy' => (float) $currency['buy'],
                        'target_sell' => (float) $currency['sell'],
                        'date' => today()->format('Y-m-d'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            Currency::whereDate('date', today()->format('Y-m-d'))->delete();

            Currency::insert($currencyData);

            session()->flash('success_message', 'Currency rates updated successfully.');

            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
            session()->flash('error_message', 'Currency rates could not be updated.');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'currency',
            'sub_menu' => 'agents',
            'breadcrumb' => Helper::generateBreadCrumb([
                'Currency' => 'admin.currencies.index',
                'Update' => null,
            ]),
        ];

        return view('admincurrency::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }
}
