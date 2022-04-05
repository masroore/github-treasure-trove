<?php

namespace App\Helpers;

use App\Commission;
use App\CommissionSetting;
use App\Http\Controllers\Api\CurrencyController;
use App\Subcategory;

class SubcategoryUrl
{
    public static function getURL($id)
    {
        $rate = new CurrencyController();
        $conversion_rate = $rate->fetchRates('INR')->getData()->exchange_rate;

        $item = Subcategory::where('id', $id)->first();

        $price_array = [];

        $commision_setting = CommissionSetting::first();

        if ($item) {
            foreach ($item->products as $old) {
                foreach ($old->subvariants as $orivar) {
                    if ('flat' == $commision_setting->type) {
                        $commission_amount = $commision_setting->rate;
                        if ('f' == $commision_setting->p_type) {
                            if ('' != $old->tax_r) {
                                $cit = $commission_amount * $old->tax_r / 100;
                                $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                            } else {
                                $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                            }

                            if (0 == $old->vender_offer_price) {
                                $price_array[] = $totalprice;
                            } else {
                                $price_array[] = $totalsaleprice;
                            }
                        } else {
                            $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                            $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                            $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                            $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                            if (0 == $old->vender_offer_price) {
                                $bprice = round($buyerprice, 2);

                                $price_array[] = $bprice;
                            } else {
                                $bsprice = round($buyersaleprice, 2);
                                $price_array[] = $bsprice;
                            }
                        }
                    } else {
                        $comm = Commission::where('category_id', $old->category_id)->first();
                        if (isset($comm)) {
                            if ('f' == $comm->type) {
                                if ('' != $old->tax_r) {
                                    $cit = $comm->rate * $old->tax_r / 100;
                                    $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                    $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                } else {
                                    $price = $old->vender_price + $comm->rate + $orivar->price;
                                    $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                }

                                if (0 == $old->vender_offer_price) {
                                    $price_array[] = $price;
                                } else {
                                    $price_array[] = $offer;
                                }
                            } else {
                                $commission_amount = $comm->rate;

                                $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                if (0 == $old->vender_offer_price) {
                                    $bprice = round($buyerprice, 2);
                                    $price_array[] = $bprice;
                                } else {
                                    $bsprice = round($buyersaleprice, 2);
                                    $price_array[] = $bsprice;
                                }
                            }
                        }
                    }
                }
            }

            if (isset($item->simpleproducts)) {
                foreach ($item->simpleproducts as $sp) {
                    if (0 != $sp->offer_price) {
                        $price_array[] = $sp->offer_price;
                    } else {
                        $price_array[] = $sp->price;
                    }
                }
            }

            if (null != $price_array) {
                $firstsub = min($price_array);
                $startp = round($firstsub);
                if ($startp >= $firstsub) {
                    $startp = $startp - 1;
                } else {
                    $startp = $startp;
                }

                $lastsub = max($price_array);
                $endp = round($lastsub);

                if ($endp <= $lastsub) {
                    $endp = $endp + 1;
                } else {
                    $endp = $endp;
                }
            } else {
                $startp = 0.00;
                $endp = 0.00;
            }

            if (isset($firstsub)) {
                if ($firstsub == $lastsub) {
                    $startp = 0.00;
                }
            }

            unset($price_array);

            $price_array = [];

            return url('shop?category=' . $item->category->id . '&sid=' . $item->id . '&start=' . sprintf('%.2f', $startp * $conversion_rate) . '&end=' . sprintf('%.2f', $endp * $conversion_rate));
        }

        return '#';
    }
}
