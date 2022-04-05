<?php

namespace Modules\AdminShipping\Http\Controllers;

use App\Models\ShippingPackage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminShipping\Http\Requests\CreatePackageRequest;
use Modules\AdminShipping\Http\Requests\UpdatePackageRequest;
use Modules\AdminShipping\Services\CreatePackageService;
use Modules\AdminShipping\Services\UpdatePackageService;

class AdminPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'packagesList',
        ];
        $packages = ShippingPackage::orderByDesc('id')->get();

        return view('adminshipping::shippingpackage.index', compact('packages'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'packagesList',
        ];

        return view('adminshipping::shippingpackage.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreatePackageRequest $request, CreatePackageService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Package stored successfully.');
        } else {
            session()->flash('error_message', 'Package could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.package.index');
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
        return view('adminshipping::shippingpackages.show');
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
            'menu' => 'packagesList',
        ];

        $package = ShippingPackage::where('id', $id)->first();
        if (!$package) {
            abort('404');
        }
        $data['package'] = $package;

        return view('adminshipping::shippingpackage.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdatePackageRequest $request, $id, UpdatePackageService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Package updated successfully.');
        } else {
            session()->flash('error_message', 'Package could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.package.index');
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
            ShippingPackage::find($id)->delete();
            session()->flash('success_message', 'Package deleted successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Package could not be deleted.');
        }

        return redirect()->route('admin.package.index');
    }

    public function updatePackageStatus($id)
    {
        try {
            $package = Package::find($id);
            if ('1' == $package->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            ShippingPackage::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Package updated successfully.');
        } catch (Exception $e) {
            session()->flash('error_message', 'Package could not be updated.');
        }

        return redirect()->route('admin.package.index');
    }
}
