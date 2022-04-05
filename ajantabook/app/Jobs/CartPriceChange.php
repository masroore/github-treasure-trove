<?php

namespace App\Jobs;

use App\Cart;
use App\Commission;
use App\CommissionSetting;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CartPriceChange implements ShouldQueue
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
    public function handle(): void
    {
        DB::reconnect('mysql');

        foreach ($this->cart as $citem) {
            $convert_price = 0;
            $show_price = 0;

            $pro = $citem->pro;

            $orivar = $citem->variant;

            if ($orivar->trashed()) {
                Cart::where('variant_id', $citem->variant_id)->where('user_id', $citem->user_id)->delete();
            }

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

                    if (null == $pro->vender_offer_price) {
                        $show_price = round($buyerprice, 2);
                    } else {
                        $convert_price = round($buyersaleprice, 2);

                        $convert_price = '' == $buyersaleprice ? $buyerprice : $buyersaleprice;
                        $show_price = round($buyerprice, 2);
                    }
                }
            }

            if (null != $pro->vender_offer_price || '' != $pro->vender_offer_price || 0 != $pro->vender_offer_price) {
                if ($convert_price != $citem->ori_offer_price || $show_price != $citem->ori_price) {
                    Cart::where('pro_id', '=', $pro->id)->where('id', '=', $citem->id)->update(['semi_total' => $convert_price * $citem->qty, 'ori_offer_price' => $convert_price, 'price_total' => $show_price * $citem->qty, 'ori_price' => $show_price]);
                }
            } else {
                if (null == $pro->vender_offer_price || '' == $pro->vender_offer_price || 0 == $pro->vender_offer_price && $show_price != $citem->ori_price) {
                    Cart::where('pro_id', '=', $pro->id)->where('id', '=', $citem->id)->update(['semi_total' => '0', 'ori_offer_price' => '0', 'price_total' => $show_price * $citem->qty, 'ori_price' => $show_price]);
                }
            }
        }

        DB::disconnect('mysql');
    }
}
