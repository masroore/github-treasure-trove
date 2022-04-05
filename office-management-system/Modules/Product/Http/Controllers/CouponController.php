<?php

namespace Modules\Product\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Product\Http\Requests\CouponFormRequest;
use Modules\Product\Repositories\CouponRepositoryInterface;

class CouponController extends Controller
{
    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->couponRepository = $couponRepository;
    }

    public function index()
    {
        try {
            $coupons = $this->couponRepository->all();

            return view('product::coupons.index', [
                'coupons' => $coupons,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function store(CouponFormRequest $request)
    {
        try {
            $this->couponRepository->create([
                'code' => $request->code,
                'cause' => $request->cause,
                'discount_type' => $request->discount_type,
                'status' => $request->status,
                'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
                'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
            ]);
            LogActivity::successLog('New Coupon - (' . $request->code . ') has been created.');
            Toastr::success(__('common.Coupon has been added Successfully'));

            return redirect()->route('coupon.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Coupon creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
