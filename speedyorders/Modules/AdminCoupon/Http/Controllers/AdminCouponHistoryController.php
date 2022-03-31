<?php

namespace Modules\AdminCoupon\Http\Controllers;

use App\Models\CouponHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AdminCouponHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'couponHistory',
        ];

        $couponHistories = DB::table('coupon_histories')
            ->select('coupon_code', DB::raw('sum(order_amount) as total'))
            ->groupBy('coupon_code')
            ->get();

        return view('admincoupon::couponhistory.index', compact('couponHistories'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'couponHistory',
        ];

        return view('admincoupon::create', $data);
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
        return view('admincoupon::edit');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

    }

    public function couponHistoryDetails($coupon)
    {
        $data = [
            'menu' => 'couponHistory',
        ];

        $couponsHistoryDetails = CouponHistory::where('coupon_code', $coupon)->get();

        if (!$couponsHistoryDetails) {
            abort('404');
        }

        return view('admincoupon::couponhistory.details-index', compact('couponsHistoryDetails'), $data);
    }
}
