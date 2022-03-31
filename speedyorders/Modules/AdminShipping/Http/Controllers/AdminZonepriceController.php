<?php

namespace Modules\AdminShipping\Http\Controllers;

use App\Models\ShippingDeliveryTime;
use App\Models\ShippingPackage;
use App\Models\ShippingZonePrice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminShipping\Http\Requests\CreateZonePriceRequest;
use Modules\AdminShipping\Http\Requests\UpdateZonePriceRequest;
use Modules\AdminShipping\Services\CreateZonepriceService;
use Modules\AdminShipping\Services\UpdateZonepriceService;

class AdminZonepriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'zonepricesList',
        ];
        $zoneprices = ShippingZonePrice::with(['deliverytime', 'package', 'group'])->orderByDesc('shipping_zone_prices.id')->get();

        return view('adminshipping::shippingzoneprice.index', compact('zoneprices'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'zonepricesList',
        ];

        $packages = ShippingPackage::all();
        $deliverytimes = ShippingDeliveryTime::all();
        $data['form'] = 'add';

        return view('adminshipping::shippingzoneprice.create', compact('packages', 'deliverytimes'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateZonePriceRequest $request, CreateZonepriceService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Zone Price stored successfully.');
        } else {
            session()->flash('error_message', 'Zone Price could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.zoneprice.index');
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('adminshipping::shippingzoneprices.show');
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
            'menu' => 'zonepricesList',
        ];

        $zoneprice = ShippingZonePrice::with('group')->where('id', $id)->first();
        if (!$zoneprice) {
            abort('404');
        }
        $packages = ShippingPackage::all();
        $deliverytimes = ShippingDeliveryTime::all();

        $data['zoneprice'] = $zoneprice;
        $data['packages'] = $packages;
        $data['deliverytimes'] = $deliverytimes;
        $data['form'] = 'edit';

        return view('adminshipping::shippingzoneprice.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateZonePriceRequest $request, $id, UpdateZonepriceService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Zone Price updated successfully.');
        } else {
            session()->flash('error_message', 'Zone Price could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.zoneprice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            ShippingZonePrice::find($id)->delete();
            session()->flash('success_message', 'Zone Price deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Zone Price could not be deleted.');
        }

        return redirect()->route('admin.zoneprice.index');
    }

    public function checkZonePrice(Request $request)
    {
        $group_name = $request->group_name;
        $zip_code = $request->zip_code;
        $shipping_delivery_times_id = $request->shipping_delivery_times_id;
        $id = $request->zoneprice_id;

        $shippingzoneprice = ShippingZonePrice::where('zip_code', $zip_code)
            ->where('group_name', $group_name)
            ->where('shipping_delivery_times_id', $shipping_delivery_times_id);

        if ($id) {
            $shippingzoneprice->where('id', '!=', $id);
        }

        $shippingzonepriceCount = $shippingzoneprice->count();

        echo $shippingzonepriceCount;
    }
}
