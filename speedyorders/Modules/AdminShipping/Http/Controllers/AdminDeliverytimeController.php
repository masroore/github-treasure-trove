<?php

namespace Modules\AdminShipping\Http\Controllers;

use App\Models\ShippingDeliveryTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminShipping\Http\Requests\CreateDeliverytimeRequest;
use Modules\AdminShipping\Http\Requests\UpdateDeliverytimeRequest;
use Modules\AdminShipping\Services\CreateDeliverytimeService;
use Modules\AdminShipping\Services\UpdateDeliverytimeService;

class AdminDeliverytimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'deliverytimesList',
        ];
        $deliverytimes = ShippingDeliveryTime::orderByDesc('id')->get();

        return view('adminshipping::shippingdeliverytime.index', compact('deliverytimes'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'deliverytimesList',
        ];

        return view('adminshipping::shippingdeliverytime.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateDeliverytimeRequest $request, CreateDeliverytimeService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Delivery Time stored successfully.');
        } else {
            session()->flash('error_message', 'Delivery Time could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.deliverytime.index');
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
        return view('adminshipping::shippingdeliverytime.show');
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
            'menu' => 'deliverytimesList',
        ];

        $deliverytime = ShippingDeliveryTime::where('id', $id)->first();
        if (!$deliverytime) {
            abort('404');
        }
        $data['deliverytime'] = $deliverytime;

        return view('adminshipping::shippingdeliverytime.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateDeliverytimeRequest $request, $id, UpdateDeliverytimeService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Delivery Time updated successfully.');
        } else {
            session()->flash('error_message', 'Delivery Time could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.deliverytime.index');
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
            ShippingDeliveryTime::find($id)->delete();
            session()->flash('success_message', 'Delivery Time deleted successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Delivery Time could not be deleted.');
        }

        return redirect()->route('admin.deliverytime.index');
    }

    public function updateDeliverytimeStatus($id)
    {
        try {
            $deliverytime = ShippingDeliveryTime::find($id);
            if ('1' == $deliverytime->is_avaiable) {
                $is_avaiable = '0';
            } else {
                $is_avaiable = '1';
            }
            ShippingDeliveryTime::where('id', $id)->first()->update(['is_avaiable' => $status]);
            session()->flash('success_message', 'Delivery Time updated successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Delivery Time could not be updated.');
        }

        return redirect()->route('admin.deliverytime.index');
    }
}
