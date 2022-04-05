<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Coupan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CoupanApplyController extends Controller
{
    public function apply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupan_id' => 'required',
            'currency' => 'required|min:3|min:3|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('coupan_id')) {
                return response()->json(['msg' => $errors->first('coupan_id'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $cpn = Coupan::find($request->coupan_id);

        if (!isset($cpn)) {
            Cart::where('user_id', Auth::user()->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            return response()->json(['msg' => 'Invalid coupan !', 'status' => 'fail']);
        }

        if (1 == $cpn->is_login) {
            if (!Auth::check()) {
                Cart::where('user_id', Auth::user()->id)
                    ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                return response()->json(['msg' => 'Login or signup to use this coupon !', 'status' => 'fail']);
            }
        }

        if (isset($cpn)) {
            $today = date('Y-m-d');

            if (date('Y-m-d', strtotime($cpn->expirydate)) >= $today) {
                if (0 != $cpn->maxusage) {
                    if ('product' == $cpn->link_by) {
                        return $this->validCouponForProduct($cpn);
                    }

                    if ('simple_product' == $cpn->link_by) {
                        return $this->validCouponForSimpleProduct($cpn);
                    }

                    if ('cart' == $cpn->link_by) {
                        return $this->validCouponForCart($request->currency, $cpn);
                    }
                    if ('category' == $cpn->link_by) {
                        return $this->validCouponForCategory($cpn);
                    }
                } else {
                    Cart::where('user_id', Auth::user()->id)
                        ->update(['coupan_id' => null, 'distype' => null, 'disamount' => null]);

                    return response()->json(['msg' => 'Coupan code max usage limit reached !', 'status' => 'fail']);
                }
            } else {
                Cart::where('user_id', Auth::user()
                    ->id)
                    ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                return response()->json(['msg' => 'Coupan code is expired !', 'status' => 'fail']);
            }
        } else {
            Cart::where('user_id', Auth::user()
                ->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            return response()->json(['msg' => 'Coupan code is invalid !', 'status' => 'fail']);
        }
    }

    public function validCouponForCart($currency, $cpn)
    {
        $rates = new CurrencyController();

        $rate = $rates->fetchRates($currency)->getData();

        $conversion_rate = $rate->exchange_rate;

        if (Auth::check()) {
            $cart = Cart::where('user_id', '=', Auth::user()->id)
                ->get();

            $total = 0;

            if (isset($cart)) {
                foreach ($cart as $key => $c) {
                    if (0 != $c->semi_total) {
                        $total = $total + $c->semi_total;
                    } else {
                        $total = $total + $c->price_total;
                    }
                }

                $total = $total + $cart->sum('shipping');

                if (0 != $cpn->minamount) {
                    if ($total * $conversion_rate >= $cpn->minamount * $conversion_rate) {
                        //check cart amount  //
                        $totaldiscount = 0;

                        foreach ($cart as $key => $c) {
                            $per = 0;

                            if ('per' == $cpn->distype) {
                                if (0 != $c->semi_total) {
                                    $per = $c->semi_total * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
                                    $per = $c->price_total * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                }
                            } else {
                                if (0 != $c->semi_total) {
                                    $per = $cpn->amount / \count($cart);
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
                                    $per = $cpn->amount / \count($cart);
                                    $totaldiscount = $totaldiscount + $per;
                                }
                            }

                            Cart::where('user_id', Auth::user()->id)
                                ->update(['distype' => 'cart', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                        }

                        return response()->json(['msg' => "$cpn->code Applied Successfully !", 'status' => 'success']);
                    }

                    Cart::where('user_id', Auth::user()->id)
                        ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                    return response()->json(['msg' => 'For Apply this coupon your cart total should be ' . sprintf('%.2f', $cpn->minamount * $conversion_rate) . ' or greater !', 'status' => 'fail']);
                }

                //check cart amount  //
                $totaldiscount = 0;
                $per = 0;

                foreach ($cart as $key => $c) {
                    if ('per' == $cpn->distype) {
                        if (0 != $c->semi_total) {
                            $per = $c->semi_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $c->price_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                    } else {
                        if (0 != $c->semi_total) {
                            $per = $cpn->amount / \count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $cpn->amount / \count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                    }

                    Cart::where('id', '=', $c->id)
                        ->update(['distype' => 'cart', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                }

                return response()->json(['msg' => "$cpn->code Applied Successfully !", 'status' => 'success']);
            }
        }
    }

    public function validCouponForCategory($cpn)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', '=', Auth::user()->id)
                ->get();
            $catcart = collect();

            foreach ($cart as $row) {
                if ($row
                    ->product
                    ->category->id == $cpn->cat_id) {
                    $catcart->push($row);
                }
            }

            if (\count($catcart) > 0) {
                $total = 0;
                $totaldiscount = 0;
                $distotal = 0;

                foreach ($catcart as $key => $row) {
                    if (0 != $row->semi_total) {
                        $total = $total + $row->semi_total;
                    } else {
                        $total = $total + $row->price_total;
                    }
                }

                foreach ($catcart as $key => $c) {
                    $per = 0;

                    if ('per' == $cpn->distype) {
                        if (0 != $c->semi_total) {
                            $per = $c->semi_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $c->price_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                    } else {
                        if (0 != $c->semi_total) {
                            $per = $cpn->amount / \count($catcart);
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $cpn->amount / \count($catcart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                    }

                    Cart::where('id', '=', $c->id)
                        ->where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => 'category', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                    return response()->json(['msg' => "$cpn->code Applied Successfully !", 'status' => 'success']);
                }

                if (0 != $cpn->minamount) {
                    if ($total > $cpn->minamount) {
                        Cart::where('id', '=', $c->id)
                            ->where('user_id', Auth::user()
                            ->id)
                            ->update(['distype' => 'category', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                        return response()->json(['msg' => "$cpn->code Applied Successfully !", 'status' => 'success']);
                    }

                    Cart::where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                    return response()->json(['msg' => 'For Apply this coupon your similar category products total should be ' . $cpn->minamount . ' or greater !', 'status' => 'fail']);
                }

                Cart::where('id', '=', $c->id)
                    ->where('user_id', Auth::user()
                    ->id)
                    ->update(['distype' => 'category', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                return response()->json(['msg' => "$cpn->code Applied Successfully !", 'status' => 'success']);
            }

            Cart::where('user_id', Auth::user()->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            return response()->json(['msg' => 'Sorry no matching product found in your cart for this coupon !', 'status' => 'fail']);
        }
    }

    public function validCouponForProduct($cpn)
    {
        if (Auth::check()) {
            $cart = Cart::where('pro_id', '=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                ->id)
                ->first();
            $carts = Cart::where('user_id', '=', Auth::user()->id)
                ->get();
            $per = 0;

            if (isset($cart)) {
                if ($cart->pro_id == $cpn->pro_id) {
                    if (0 != $cart->semi_total) {
                        if ('per' == $cpn->distype) {
                            $per = $cart->semi_total * $cpn->amount / 100;
                        } else {
                            $per = $cpn->amount;
                        }
                    } else {
                        if ('per' == $cpn->distype) {
                            $per = $cart->price_total * $cpn->amount / 100;
                        } else {
                            $per = $cpn->amount;
                        }
                    }

                    Cart::where('pro_id', '=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => 'product', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                    Cart::where('pro_id', '!=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                    return response()->json(['msg' => "$cpn->code Applied Successfully !"]);
                }

                Cart::where('user_id', Auth::user()->id)
                    ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                return response()->json(['errors' => 'Sorry no product found in your cart for this coupon !', 'status' => 'fail']);
            }

            Cart::where('user_id', Auth::user()->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            return response()->json(['errors' => 'Sorry no product found in your cart for this coupon !', 'status' => 'fail']);
        }
    }

    public function validCouponForSimpleProduct($cpn)
    {
        if (Auth::check()) {
            $cart = Cart::where('simple_pro_id', '=', $cpn['simple_pro_id'])->where('user_id', '=', Auth::user()
                ->id)
                ->firstorfail();

            $per = 0;

            if (isset($cart)) {
                if ($cart->simple_pro_id == $cpn->simple_pro_id) {
                    if (0 != $cart->semi_total) {
                        if ('per' == $cpn->distype) {
                            $per = $cart->semi_total * $cpn->amount / 100;
                        } else {
                            $per = $cpn->amount;
                        }
                    } else {
                        if ('per' == $cpn->distype) {
                            $per = $cart->price_total * $cpn->amount / 100;
                        } else {
                            $per = $cpn->amount;
                        }
                    }

                    Cart::where('simple_pro_id', '=', $cpn['simple_pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => 'product', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                    Cart::where('simple_pro_id', '!=', $cpn['simple_pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                    return response()->json(['msg' => "$cpn->code Applied Successfully !"]);
                }

                Cart::where('user_id', Auth::user()->id)
                    ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                return response()->json(['errors' => 'Sorry no product found in your cart for this coupon !', 'status' => 'fail']);
            }

            Cart::where('user_id', Auth::user()->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            return response()->json(['errors' => 'Sorry no product found in your cart for this coupon !', 'status' => 'fail']);
        }
    }

    public function removeCoupan(Request $request)
    {
        if (!$request->coupan_id) {
            return response()->json(['msg' => 'Coupan id is required', 'status' => 'fail']);
        }

        if (Auth::check()) {
            $cpn = Coupan::find($request->coupan_id);

            Cart::where('user_id', Auth::user()->id)
                ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

            if (!isset($cpn)) {
                return response()->json(['msg' => 'Invalid coupan !', 'status' => 'fail']);
            }

            return response()->json(['msg' => 'Coupan Removed !', 'status' => 'success']);
        }
    }
}
