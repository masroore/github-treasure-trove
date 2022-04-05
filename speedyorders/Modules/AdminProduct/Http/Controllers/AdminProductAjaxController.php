<?php

namespace Modules\AdminProduct\Http\Controllers;

use App\Models\Option;
use App\Models\ShippingZonePrice;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminProductAjaxController extends Controller
{
    public function option(Request $request)
    {
        $returnHTML = '';
        if (!$request->optionId) {
            return;
        }
        $option_data = Option::with('optionValues')->where('options.id', $request->optionId)->first();

        $counter = $request->counter;

        switch ($option_data->type) {
            case 'select':
                $returnHTML .= view('adminproduct::htmlelement.select', compact('option_data', 'counter'))->render();

            break;

            case 'input':
                $returnHTML .= view('adminproduct::htmlelement.input', compact('option_data', 'counter'))->render();

            break;
        }

        return response()->json(['success' => true, 'html' => $returnHTML]);
    }

    public function group(Request $request)
    {
        if (!$request->groupId) {
            return;
        }
        $option = ShippingZonePrice::where('id', $request->groupId)->first();

        $returnHTML = view('adminproduct::htmlelement.input', compact('option', 'counter'))->render();

        return response()->json(['success' => true, 'html' => $returnHTML]);
    }

    public function optionValue(Request $request)
    {
        if (!$request->optionId) {
            return;
        }
        $option = Option::where('id', $request->optionId)->with('optionValues')->first();

        $counter = $request->counter;

        switch ($option->type) {

            case 'select':
                $returnHTML = view('adminproduct::htmlelement.select-value', compact('option', 'counter'))->render();

                return response()->json(['success' => true, 'html' => $returnHTML]);

                break;
        }
    }

    public function packageDeliveryTime(Request $request)
    {
        if (!$request->zone_id || !$request->package_id) {
            return;
        }

        $deliverArr = (isset($request->deliveryTimes) && '' != $request->deliveryTimes) ? json_decode($request->deliveryTimes) : '';

        $zone_prices = ShippingZonePrice::leftjoin('shipping_delivery_times', 'shipping_delivery_times.id', '=', 'shipping_zone_prices.shipping_delivery_times_id')
            ->where('shipping_zone_groups_id', $request->zone_id)
            ->where('shipping_packages_id', $request->package_id)
            ->select(['shipping_delivery_times.id', 'shipping_delivery_times.name', 'shipping_zone_prices.price'])
            ->get();

        $returnHTML = view('adminproduct::htmlelement.deliverytime', compact('zone_prices', 'deliverArr'))->render();

        return response()->json(['success' => true, 'html' => $returnHTML]);
    }
}
