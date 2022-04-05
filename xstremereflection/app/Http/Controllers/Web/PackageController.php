<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\EstimatePackage;
use Vanguard\Http\Controllers\Controller;

use Vanguard\Package;
use Vanguard\packageItem;
use Vanguard\PackageType;
use Vanguard\Services;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::where('companyId', auth()->user()->companyId)->orWhere('companyId', 0)->get();
        $estimates = EstimatePackage::where('approved', 1)->where('companyId', Auth()->user()->companyId)->get();
        $packageTypes = PackageType::get();

        return view('packages.index', compact('packages', 'estimates', 'packageTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Services::where('company_id', auth()->user()->companyId)->orWhere('company_id', 0)->get();
        $packageTypes = PackageType::get();

        return view('packages.create', compact('services', 'packageTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new Package();

        $package->companyId = auth()->user()->companyId;
        $package->description = $request->description;
        $package->cost = $request->cost;
        $package->packageType = $request->packageType;
        $package->description = $request->description;
        $package->productCost = $request->productCost;
        $package->laborCost = $request->laborCost;
        $package->acquisitionCost = $request->acquisitionCost;
        $package->save();

        //dd($request->package_items);

        return redirect()->route('package.show', ['id' => $package->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);
        $array = explode(',', $package->includes);
        $upsaleArray = explode(',', $package->upsale);
        $upsale = Services::whereIn('id', $upsaleArray)->get();
        $packages = Package::whereIn('id', $array)->get();
        $packageServices = packageItem::whereIn('packageId', $array)->orWhere('packageId', $id)->get();
        $availableServices = Services::where('company_id', Auth()->user()->companyId)->orWhere('company_id', 0)->get();
        $availablePackages = Package::where('companyId', Auth()->user()->companyId)->orWhere('companyId', 0)->get();
        $services = Services::where('company_id', 0)->orWhere('company_id', Auth()->user()->companyId)
            ->orderBy('serviceTypeId')
            ->get();

        return view('packages.show', compact('package', 'packages', 'packageServices', 'upsale', 'availableServices', 'services', 'availablePackages'));
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
        $package = Package::with('items')->find($id);
        $services = Services::where('company_id', auth()->user()->companyId)->orWhere('company_id', 0)->get();

        return view('packages.edit', compact('package', 'services'));
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
        $package = Package::find($id);

        $package->companyId = auth()->user()->companyId;
        $package->description = $request->description;
        $package->cost = $request->cost;
        $package->save();

        //dd($request->package_items);

        foreach ($request->package_items as $item) {
            $packageItemCheck = packageItem::where('packageId', $package->id)->where('serviceId', $item)->get();
            if (!$packageItemCheck) {
                $pi = new packageItem();

                $pi->packageId = $package->id;
                $pi->serviceId = $item;
                $pi->save();
            }
        }

        return back()->with('success', 'Updates completed.');
    }

    public function addService(Request $request, $id)
    {
        foreach ($request->package_items as $item) {
            $pkgCheck = packageItem::where('packageId', $id)->where('serviceId', $item)->firstOrNew(
                ['packageId' => $id],
                ['serviceId' => $item]
            );

            $pkgCheck->save();
        }

        return back();
    }

    public function addIncludedPackage(Request $request, $id)
    {
        $package = Package::find($id);

        $items = $request->input('packages_included');
        $items = implode(',', $items);

        $package->includes = $items;
        $package->save();

        return back();
    }

    public function removePackageInclude($rid, $id)
    {
        $include = Package::find($id);

        $items = explode(',', $include->includes);

        $item = $rid;

        while (($i = array_search($item, $items)) !== false) {
            unset($items[$i]);
        }

        $items = implode(',', $items);

        $include->includes = $items;
        $include->save();

        return back()->with('success', 'Included package removed successfully.');
    }

    public function addUpdsale(Request $request, $id)
    {
        $package = Package::find($id);

        $items = $request->input('package_upsale');
        $items = implode(',', $items);

        $package->upsale = $items;
        $package->save();

        return back()->with('success', 'Upsale service added to package successfully.');
    }

    public function removeService($id)
    {
        $service = packageItem::find($id)->delete();

        return back()->with('success', 'Service removed from package.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
