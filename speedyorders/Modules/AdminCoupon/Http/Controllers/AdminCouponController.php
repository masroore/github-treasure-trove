<?php

namespace Modules\AdminCoupon\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminCoupon\Http\Requests\CreateCouponRequest;
use Modules\AdminCoupon\Http\Requests\UpdateCouponRequest;
use Modules\AdminCoupon\Services\CreateCouponService;
use Modules\AdminCoupon\Services\UpdateCouponService;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'couponsList',
        ];
        $coupons = Coupon::orderByDesc('id')->get();

        return view('admincoupon::index', compact('coupons'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'couponsList',
        ];
        $products = Product::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view('admincoupon::create', compact('products', 'categories'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request, CreateCouponService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Coupon stored successfully.');
        } else {
            session()->flash('error_message', 'Coupon could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.coupons.index');
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
        return view('admincoupon::show');
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
            'menu' => 'couponsList',
        ];

        $coupon = Coupon::where('id', $id)->with(['products', 'excludedProducts', 'categories'])->first();
        if (!$coupon) {
            abort('404');
        }
        $data['couponProducts'] = $coupon->products->pluck('id')->toArray();
        $data['excludedProducts'] = $coupon->excludedProducts->pluck('id')->toArray();
        $data['couponCategories'] = $coupon->categories->pluck('id')->toArray();
        $data['products'] = Product::select('id', 'name')->get();
        $data['categories'] = Category::select('id', 'name')->get();
        $data['coupon'] = $coupon;

        return view('admincoupon::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateCouponRequest $request, $id, UpdateCouponService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Coupon updated successfully.');
        } else {
            session()->flash('error_message', 'Coupon could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.coupons.index');
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
            Coupon::find($id)->delete();
            session()->flash('success_message', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Coupon could not be deleted.');
        }

        return redirect()->route('admin.coupons.index');
    }

    public function updateCouponStatus($id)
    {
        try {
            $coupon = Coupon::find($id);
            if ('1' == $coupon->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Coupon::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Coupon could not be updated.');
        }

        return redirect()->route('admin.coupons.index');
    }
}
