<?php

namespace App\Jobs;

use App\AddSubVariant;
use App\Commission;
use App\CommissionSetting;
use App\Product;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class GuestCartPriceChange implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $cart;

    /**
     * Create a new job instance.
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     */
    public function handle(Request $request): void
    {
        DB::reconnect('mysql');

        $convert_price = 0;
        $show_price = 0;
        foreach ($this->cart as $key => $c) {
            $pro = Product::withTrashed()->find($c['pro_id']);

            if (!$pro->trashed()) {
                $orivar = AddSubVariant::withTrashed()->findorfail($c['variantid']);

                if (!$orivar->trashed()) {
                    $oriofferprice = $pro->offer_price + $orivar->price;
                    $oriprice = $pro->price_total + $orivar->price;

                    $commision_setting = CommissionSetting::first();

                    if ('flat' == $commision_setting->type) {
                        $commission_amount = $commision_setting->rate;
                        if ('f' == $commision_setting->p_type) {
                            $totalprice = $pro->vender_price + $orivar->price + $commission_amount;
                            $totalsaleprice = $pro->vender_offer_price + $orivar->price + $commission_amount;

                            if (0 == $pro->vender_offer_price) {
                                $show_price = $totalprice;
                            } else {
                                $convert_price = '' == $totalsaleprice ? $totalprice : $totalsaleprice;
                                $show_price = $totalprice;
                            }
                        } else {
                            $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                            $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                            $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                            $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                            if (0 == $pro->vender_offer_price) {
                                $show_price = round($buyerprice, 2);
                            } else {
                                round($buyersaleprice, 2);
                                $convert_price = '' == $buyersaleprice ? $buyerprice : $buyersaleprice;
                                $show_price = $buyerprice;
                            }
                        }
                    } else {
                        $comm = Commission::where('category_id', $pro->category_id)->first();
                        if (isset($comm)) {
                            if ('f' == $comm->type) {
                                $price = $pro->vender_price + $comm->rate + $orivar->price;

                                if (null != $pro->vender_offer_price) {
                                    $offer = $pro->vender_offer_price + $comm->rate + $orivar->price;
                                } else {
                                    $offer = $pro->vender_offer_price;
                                }

                                if (0 == $pro->vender_offer_price || null == $pro->vender_offer_price) {
                                    $show_price = $price;
                                } else {
                                    $convert_price = $offer;
                                    $show_price = $price;
                                }
                            } else {
                                $commission_amount = $comm->rate;

                                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                if (0 == $pro->vender_offer_price) {
                                    $show_price = round($buyerprice, 2);
                                } else {
                                    round($buyersaleprice, 2);

                                    $convert_price = '' == $buyersaleprice ? $buyerprice : $buyersaleprice;
                                    $show_price = round($buyerprice, 2);
                                }
                            }
                        } else {
                            $commission_amount = 0;

                            $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                            $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                            $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                            $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                            if (0 == $pro->vender_offer_price) {
                                $show_price = round($buyerprice, 2);
                            } else {
                                round($buyersaleprice, 2);

                                $convert_price = '' == $buyersaleprice ? $buyerprice : $buyersaleprice;
                                $show_price = round($buyerprice, 2);
                            }
                        }
                    }

                    if ('' != $pro->vender_offer_price || 0 != $pro->vender_offer_price) {
                        if ($c['pro_id'] == $pro->id) {
                            if ($convert_price != $c['varofferprice'] || $show_price != $c['varprice']) {
                                $this->cart[$key]['varprice'] = $show_price;
                                $this->cart[$key]['varofferprice'] = $convert_price;
                            }
                        }
                    } else {
                        if ($c['pro_id'] == $pro->id) {
                            if ('' == $pro->vender_offer_price || 0 == $pro->vender_offer_price && $show_price != $c['varprice'] || 0 == $pro->vender_offer_price) {
                                $this->cart[$key]['varofferprice'] = 0;
                                $this->cart[$key]['varprice'] = $show_price;
                            }
                        }
                    }
                } else {
                    unset($this->cart[$key]);
                }
            } else {
                unset($this->cart[$key]);
            }
        }

        $request->session()->put('cart', $this->cart);
        DB::disconnect('mysql');
        // dd(session()->get('cart'));
    }
}
