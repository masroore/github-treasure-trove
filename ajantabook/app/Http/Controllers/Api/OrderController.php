<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Allcity;
use App\Allcountry;
use App\Allstate;
use App\BillingAddress;
use App\Cart;
use App\Genral;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Order;
use App\Shipping;
use App\ShippingWeight;
use App\Store;
use App\Tax;
use App\TaxClass;
use App\Zone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ShippingPrice;

class OrderController extends Controller
{
    public function orderReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        $same = $request->same_as;

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $data = [];

        $address = Address::find($request->address_id);

        if (!$address) {
            return response()->json(['msg' => 'Address not found !', 'status' => 'fail']);
        }

        if (1 == $request->same_as) {
            $billing_address = $address;

            $data['billing_address'] = [
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'country' => $address->getCountry ? $address->getCountry->nicename : null,
                'state' => $address->getstate ? $address->getstate->name : null,
                'city' => $address->getcity ? $address->getcity->name : null,
                'pincode' => $address->pin_code,
            ];
        } else {
            $billing_address = BillingAddress::find($request->billing_id);

            if (!$billing_address) {
                return response()->json(['msg' => 'Billing address not found !', 'status' => 'fail']);
            }

            $data['billing_address'] = [
                'id' => $billing_address->id,
                'name' => $billing_address->firstname,
                'email' => $billing_address->email,
                'phone' => (int) $billing_address->mobile,
                'address' => strip_tags($billing_address->address),
                'country' => $billing_address->countiess ? $billing_address->countiess->nicename : null,
                'state' => $billing_address->states ? $billing_address->states->name : null,
                'city' => $billing_address->cities ? $billing_address->cities->name : null,
                'pincode' => (int) $billing_address->pincode,
            ];
        }

        $data['shipping_address'] = [
            'id' => $address->id,
            'name' => $address->name,
            'email' => $address->email,
            'phone' => $address->phone,
            'address' => $address->address,
            'country' => $address->getCountry ? $address->getCountry->nicename : null,
            'state' => $address->getstate ? $address->getstate->name : null,
            'city' => $address->getcity ? $address->getcity->name : null,
            'pincode' => $address->pin_code,
        ];

        $data['order_review'] = $this->getProducts($request, $address, $billing_address, $same);

        $data['payment_details'] = $this->getPaymentTotal($request, $address, $billing_address);

        return response()->json($data);
    }

    public function getProducts($request, $address, $billing_address, $same)
    {
        $rates = new CurrencyController();

        $rate = $rates->fetchRates($request->currency)->getData();

        $carts = auth()->user()->cart;

        $products = [];

        $price = 0;

        foreach ($carts as $cart) {
            $productData = new ProductController();

            $getvariant = new CartController();

            $rating = $productData->getproductrating($cart->product);

            $reviews = $productData->getProductReviews($cart->product);

            if (null != $cart->product->tax_r && 0 == $cart->product->tax) {
                if (0 != $cart->ori_offer_price) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf('%.2f', $taxAmnt);
                    $price = ($cart->ori_offer_price - $taxAmnt) * $cart->qty;
                } else {
                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf('%.2f', $taxAmnt);

                    $price = ($cart->ori_price - $taxAmnt) * $cart->qty;
                }
            } else {
                if (0 != $cart->semi_total) {
                    $price = $cart->semi_total;
                } else {
                    $price = $cart->price_total;
                }
            }

            $price = sprintf('%.2f', $price * $rate->exchange_rate);

            $shipping = 0;

            if (null != $cart->ship_type) {
                $shipping += sprintf('%.2f', $cart->shipping * $rate->exchange_rate);
            } else {
                $shipping += (float) $this->calculateShipping($cart) * $rate->exchange_rate;
            }

            $tax = $this->getTaxInfo($cart->product, $rate, $address, $billing_address, $cart, $same);

            $subtotal = (float) sprintf('%.2f', $price);

            $products[] = [
                'cartid' => $cart->id,
                'productid' => $cart->product->id,
                'variantid' => $cart->variant_id,
                'productname' => $cart->product->getTranslations('name'),
                'price' => (float) $price / $cart->qty,
                'total_price' => (float) $price,
                'currency_symbol' => $rate->symbol,
                'qty' => $cart->qty,
                'rating' => $rating,
                'localpickup' => 'localpickup' == $cart->ship_type ? 1 : 0,
                'review' => \count($reviews),
                'thumbnail_path' => url('variantimages/thumbnails'),
                'thumbnail' => $cart->variant->variantimages->main_image,
                'tax_info' => '' == $cart->product->tax_r ? __('Exclusive of tax') : __('Inclusive of all taxes'),
                'soldby' => $cart->product->store->name,
                'common_variant' => $this->commonvariant($cart->product),
                'variant' => $getvariant->variantDetail($cart->variant),
                'minorderqty' => (int) $cart->variant->min_order_qty,
                'maxorderqty' => (int) $cart->variant->max_order_qty,
                'shipping' => $shipping,
                'tax' => $tax,
                'subtotal' => $subtotal,
                'product_grand_total' => $subtotal + $tax['total_tax_amount'] + $shipping,
            ];
        }

        return $products;
    }

    public function commonvariant($pro)
    {
        $common_variant = [];

        if (isset($pro->commonvars)) {
            foreach ($pro->commonvars as $cvar) {
                $common_variant[] = [
                    'attr_id' => $cvar->attribute->id,
                    'attrribute' => $cvar->attribute->attr_name,
                    'valueid' => $cvar->provalues->id,
                    'value' => $cvar->provalues->values,
                    'unit' => $cvar->provalues->unit_value,
                    'type' => 'color' == $cvar->attribute->attr_name || 'Color' == $cvar->attribute->attr_name || 'colour' == $cvar->attribute->attr_name || 'Colour' == $cvar->attribute->attr_name ? 'c' : 's',
                ];
            }
        }

        return $common_variant;
    }

    public static function calculateShipping($cart)
    {
        $shipping = 0;

        if (0 == $cart->product->free_shipping) {
            $free_shipping = Shipping::where('id', $cart->product->shipping_id)->first();

            if (!empty($free_shipping)) {
                if ('Shipping Price' == $free_shipping->name) {
                    $weight = ShippingWeight::first();
                    $pro_weight = $cart->variant->weight;
                    if ($weight->weight_to_0 >= $pro_weight) {
                        if ('po' == $weight->per_oq_0) {
                            $shipping = $weight->weight_price_0;
                        } else {
                            $shipping = $weight->weight_price_0 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_1 >= $pro_weight) {
                        if ('po' == $weight->per_oq_1) {
                            $shipping = $weight->weight_price_1;
                        } else {
                            $shipping = $weight->weight_price_1 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_2 >= $pro_weight) {
                        if ('po' == $weight->per_oq_2) {
                            $shipping = $weight->weight_price_2;
                        } else {
                            $shipping = $weight->weight_price_2 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_3 >= $pro_weight) {
                        if ('po' == $weight->per_oq_3) {
                            $shipping = $weight->weight_price_3;
                        } else {
                            $shipping = $weight->weight_price_3 * $cart->qty;
                        }
                    } else {
                        if ('po' == $weight->per_oq_4) {
                            $shipping = $weight->weight_price_4;
                        } else {
                            $shipping = $weight->weight_price_4 * $cart->qty;
                        }
                    }
                } else {
                    $shipping = $free_shipping->price;
                }
            }
        }

        return $shipping;
    }

    public function getTaxInfo($pro, $rate, $address, $billing_address, $cart, $same)
    {
        $tax = [];

        // if tax is set to 0 here which means price is incl. of tax

        if (0 == $pro->tax) {
            if (0 != $pro->offer_price) {
                $p = 100;
                $taxrate_db = $pro->tax_r;
                $vp = $p + $taxrate_db;
                $tamount = $pro->offer_price / $vp * $taxrate_db;
                $tamount = sprintf('%.2f', $tamount);
            } else {
                $p = 100;
                $taxrate_db = $pro->tax_r;
                $vp = $p + $taxrate_db;
                $tamount = $pro->price / $vp * $taxrate_db;

                $tamount = sprintf('%.2f', $tamount);
            }

            if ('India' == $pro->store->country['nicename'] || 'india' == $pro->store->country['nicename']) {

                // IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT

                if ($pro->store->state['id'] != $address->getstate->id) {
                    $igst = $tamount * $cart->qty;

                    $igst = sprintf('%.2f', $igst * $rate->exchange_rate);

                    $tax['tax_type'] = 'single';

                    $tax['tax_name'] = [

                        'name1' => [
                            'en' => 'IGST',
                        ],

                    ];

                    $tax['amount'] = [

                        'amount1' => (float) sprintf('%.2f', $tamount * $rate->exchange_rate),
                        'totalAmount1' => (float) $igst,
                        'combinedTotal' => (float) $igst,

                    ];
                }

                // CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE SAME

                if ($pro->store->state['id'] == $address->getstate->id) {
                    $t_amount = $tamount * $cart->qty;
                    $t_amount = sprintf('%.2f', $t_amount * $rate->exchange_rate);

                    $tax['tax_type'] = 'multiple';

                    $tax['tax_name'] = [

                        'name1' => [
                            'en' => 'SGST',
                        ],

                        'name2' => [
                            'en' => 'CGST',
                        ],
                    ];

                    $tax['amount'] = [
                        'amount1' => (float) sprintf('%.2f', ($tamount / 2) * $rate->exchange_rate),
                        'totalAmount1' => (float) sprintf('%.2f', ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                        'amount2' => (float) sprintf('%.2f', ($tamount / 2) * $rate->exchange_rate),
                        'totalAmount2' => (float) sprintf('%.2f', ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                        'combinedTotal' => (float) $t_amount,
                    ];
                }
            } else {
                $tax['tax_type'] = 'single';

                $tax['tax_name'] = [
                    'name1' => $pro->getTranslations('tax_name'),
                ];

                $tax['amount'] = [

                    'amount1' => (float) sprintf('%.2f', ($tamount / $cart->qty) * $rate->exchange_rate),
                    'totalAmount1' => (float) sprintf('%.2f', ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                    'combinedTotal' => (float) sprintf('%.2f', ($tamount * $cart->qty / 2) * $rate->exchange_rate),

                ];
            }

            $tamount = $tamount * $cart->qty;

            $tax['total_tax_amount'] = (float) sprintf('%.2f', $tamount * $rate->exchange_rate);

            return $tax;
        }

        return $this->getExcludeTax($tax, $address, $billing_address, $pro, $cart, $rate, $same);
    }

    public function getExcludeTax($tax, $address, $billing_address, $pro, $cart, $rate, $same)
    {
        $pri = [];

        $taxable = [];

        $min_pri = [];

        if (1 == $same) {
            $s_id = $address->getstate->id;
        } else {
            $s_id = $billing_address->states->id;
        }

        foreach (TaxClass::where('id', $pro->tax)->get() as $tax) {
            if (isset($tax->priority)) {
                foreach ($tax->priority as $proity) {
                    $pri[] = $proity;
                }
            }
        }

        $matched = 'no';
        $after_tax_amount = 0;

        if ('no' == $matched) {
            if ('' == $pri || null == $pri) {
                $after_tax_amount = 0;
            } else {
                if (null == $min_pri) {
                    $ch_prio = 0;
                    $i = 0;
                    $x = min($pri);
                    $min_pri[] = $x;
                    if (isset($tax->priority)) {
                        foreach ($tax->priority as $key => $MaxPri) {
                            try {
                                if ('billing' == $tax->based_on[$min_pri[0]]) {
                                    $taxRate = Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                    $zone = Zone::where('id', $taxRate->zone_id)->first();
                                    $store = $s_id;

                                    if (\is_array($zone->name)) {
                                        $zonecount = \count($zone->name);

                                        if ($ch_prio == $min_pri[0]) {
                                            break;
                                        }
                                        foreach ($zone->name as $z) {
                                            ++$i;

                                            if ($store == $z) {
                                                $i = $zonecount;
                                                $matched = 'yes';
                                                if ('p' == $taxRate->type) {
                                                    $tax_amount = $taxRate->rate;
                                                    $price = null == $cart->ori_offer_price && 0 == $pro->ori_offer_price ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                    $after_tax_amount = $price * ($tax_amount / 100);
                                                } // End if Billing Type per And fix
                                                else {
                                                    $tax_amount = $taxRate->rate;
                                                    $price = null == $cart->ori_offer_price && 0 == $cart->ori_offer_price ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                    $after_tax_amount = $taxRate->rate * $cart->qty;
                                                }
                                                $ch_prio = $min_pri[0];

                                                break;
                                            }

                                            if ($i == $zonecount) {
                                                array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                unset($min_pri);
                                                $min_pri = [];

                                                $x = min($pri);
                                                $min_pri[] = $x;

                                                $i = 0;

                                                break;
                                            }
                                        }
                                    }
                                } else {
                                    $taxRate = Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();

                                    $zone = Zone::where('id', $taxRate->zone_id)->first();

                                    $store = Store::where('user_id', $pro->vender_id)->first();

                                    if (\is_array($zone->name)) {
                                        $zonecount = \count($zone->name);

                                        if ($ch_prio == $min_pri[0]) {
                                            break;
                                        }
                                        foreach ($zone->name as $z) {
                                            ++$i;
                                            if ($store->state_id == $z) {
                                                $i = $zonecount;
                                                $matched = 'yes';
                                                if ('p' == $taxRate->type) {
                                                    $tax_amount = $taxRate->rate;
                                                    $price = 0 == $cart->ori_offer_price ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                    $after_tax_amount = $price * ($tax_amount / 100);
                                                } // End if Billing Typ per And fix
                                                else {
                                                    $tax_amount = $taxRate->rate;
                                                    $price = 0 == $cart->ori_offer_price ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                    $after_tax_amount = $taxRate->rate * $cart->qty;
                                                }
                                                $ch_prio = $min_pri[0];

                                                break;
                                            }
                                            if ($i == $zonecount) {
                                                array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                unset($min_pri);
                                                $min_pri = [];

                                                $x = min($pri);
                                                $min_pri[] = $x;

                                                $i = 0;

                                                break;
                                            }
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $after_tax_amount = 0;

                                break;
                            }
                        }
                    }
                }
            }
        }

        if ('India' == $pro->store->country['nicename'] || 'india' == $pro->store->country['nicename']) {
            // IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT

            if ($pro->store->state['id'] != $address->getstate->id) {
                $igst = $after_tax_amount;

                $igst = sprintf('%.2f', $igst * $rate->exchange_rate);

                $taxable['tax_type'] = 'single';

                $taxable['tax_name'] = [

                    'name1' => [
                        'en' => 'IGST',
                    ],

                ];

                $taxable['amount'] = [

                    'amount1' => (float) sprintf('%.2f', $after_tax_amount / $cart->qty * $rate->exchange_rate),
                    'totalAmount1' => (float) $igst,
                    'combinedTotal' => (float) $igst,

                ];
            }

            // CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE SAME

            if ($pro->store->state['id'] == $address->getstate->id) {
                $t_amount = $after_tax_amount;
                $t_amount = sprintf('%.2f', $t_amount * $rate->exchange_rate);

                $taxable['tax_type'] = 'multiple';

                $taxable['tax_name'] = [

                    'name1' => [
                        'en' => 'IGST',
                    ],

                    'name2' => [
                        'en' => 'CGST',
                    ],
                ];

                $taxable['amount'] = [
                    'amount1' => (float) sprintf('%.2f', ($after_tax_amount / 2) * $rate->exchange_rate),
                    'totalAmount1' => (float) sprintf('%.2f', ($after_tax_amount) * $rate->exchange_rate),
                    'amount2' => (float) sprintf('%.2f', ($after_tax_amount / 2) * $rate->exchange_rate),
                    'totalAmount2' => (float) sprintf('%.2f', ($after_tax_amount) * $rate->exchange_rate),
                    'combinedTotal' => (float) $t_amount,
                ];
            }
        } else {
            $taxable['tax_type'] = 'single';

            $taxable['tax_name'] = [
                'name1' => [
                    'en' => $pro->taxclass->title,
                ],
            ];

            $taxable['amount'] = [

                'amount1' => (float) sprintf('%.2f', ($after_tax_amount / $cart->qty) * $rate->exchange_rate),
                'totalAmount1' => (float) sprintf('%.2f', ($after_tax_amount) * $rate->exchange_rate),
                'combinedTotal' => (float) sprintf('%.2f', ($after_tax_amount) * $rate->exchange_rate),

            ];
        }

        $taxable['total_tax_amount'] = (float) sprintf('%.2f', ($after_tax_amount) * $rate->exchange_rate);

        return $taxable;
    }

    public function getPaymentTotal($request, $address, $billing_address)
    {
        $rates = new CurrencyController();

        $rate = $rates->fetchRates($request->currency)->getData();

        $handlinecharge = 0;

        $shipping = 0;

        $total = 0;

        $totalTax = 0;

        $grandtotal = 0;

        // Handling charge per item count
        $hcsetting = Genral::first();

        if ('fo' == $hcsetting->chargeterm) {
            // on full order handling charge
            $handlinecharge = $hcsetting->handlingcharge;
        } elseif ('pi' == $hcsetting->chargeterm) {
            // Per item handling charge
            $totalcartitem = auth()->user()->cart()->count();
            $handlinecharge = $hcsetting->handlingcharge * $totalcartitem;
        }
        // END

        $paymentdetails = [];

        foreach (auth()->user()->cart as $val) {
            if (null == $val->ship_type) {
                $shipping += ShippingPrice::calculateShipping($val);
            } else {
                $shipping += $val->shipping;
            }

            if (null != $val->product->tax_r && 0 == $val->product->tax) {
                if (0 != $val->ori_offer_price) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf('%.2f', $taxAmnt);
                    $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;
                } else {
                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf('%.2f', $taxAmnt);

                    $price = ($val->ori_price - $taxAmnt) * $val->qty;
                }
            } else {
                if (0 != $val->semi_total) {
                    $price = $val->semi_total;
                } else {
                    $price = $val->price_total;
                }
            }

            $total = $total + $price;

            $x = $this->getTaxInfo($val->product, $rate, $address, $billing_address, $val, $request->same_as);

            $totalTax = $totalTax + $x['total_tax_amount'];
        }

        $grandtotal = ($total * $rate->exchange_rate) + ($handlinecharge * $rate->exchange_rate);

        $grandtotal = $grandtotal + ($shipping * $rate->exchange_rate) + $totalTax;

        $promo = (float) sprintf('%.2f', Cart::getDiscount() * $rate->exchange_rate);

        if (0 != $promo) {
            $grandtotal = $grandtotal - $promo;
        }

        return [

            'total_items' => auth()->user()->cart()->count(),
            'currency_symbol' => $rate->symbol,
            'subtotal' => (float) sprintf('%.2f', $total * $rate->exchange_rate),
            'total_tax' => $totalTax,
            'discount_amount' => $promo,
            'coupan' => Cart::getCoupanDetail(),
            'total_handingcharge' => (float) sprintf('%.2f', $handlinecharge * $rate->exchange_rate),
            'total_shipping' => (float) sprintf('%.2f', $shipping * $rate->exchange_rate),
            'grand_total' => (float) sprintf('%.2f', $grandtotal),

        ];
    }

    public function localpickupapply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartid' => 'required',
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('cartid')) {
                return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $getrate = Shipping::where('name', '=', 'Local Pickup')->first()->price;

        $rates = new CurrencyController();

        $cartrow = Cart::where('id', '=', $request->cartid)->where('user_id', Auth::user()
            ->id)
            ->first();

        if (isset($cartrow)) {
            if (!empty($cartrow->product->shipping_id)) {

                // Update cart row
                $cartrow->shipping = $getrate;
                $cartrow->ship_type = 'localpickup';
                $cartrow->save();
            // End
            } else {

                // Update cart row
                $getrate = 0;
                $cartrow->shipping = '0';
                $cartrow->ship_type = 'localpickup';
                $cartrow->save();
                // End
            }

            return $this->orderReview($request);
        }

        return response()->json([
            'message' => 'Cart row not found !',
            'status' => 'fail',
        ]);
    }

    public function localpickupremove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartid' => 'required',
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('cartid')) {
                return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $row = Cart::where('id', '=', $request->cartid)->where('user_id', Auth::user()
            ->id)
            ->first();

        if (!isset($row)) {
            return response()->json([
                'message' => 'Cart row not found !',
                'status' => 'fail',
            ]);
        }

        $free_shipping = Shipping::where('id', $row
            ->product
            ->shipping_id)
            ->first();

        if (!empty($free_shipping)) {
            if ('Shipping Price' == $free_shipping->name) {
                $weight = ShippingWeight::first();
                $pro_weight = $row
                    ->variant->weight;
                if ($weight->weight_to_0 >= $pro_weight) {
                    if ('po' == $weight->per_oq_0) {
                        $per_shipping = $weight->weight_price_0;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    } else {
                        $per_shipping = $weight->weight_price_0 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    }
                } elseif ($weight->weight_to_1 >= $pro_weight) {
                    if ('po' == $weight->per_oq_1) {
                        $per_shipping = $weight->weight_price_1;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    } else {
                        $per_shipping = $weight->weight_price_1 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    }
                } elseif ($weight->weight_to_2 >= $pro_weight) {
                    if ('po' == $weight->per_oq_2) {
                        $per_shipping = $weight->weight_price_2;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    } else {
                        $per_shipping = $weight->weight_price_2 * $row->qty;
                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    }
                } elseif ($weight->weight_to_3 >= $pro_weight) {
                    if ('po' == $weight->per_oq_3) {
                        $per_shipping = $weight->weight_price_3;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    } else {
                        $per_shipping = $weight->weight_price_3 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    }
                } else {
                    if ('po' == $weight->per_oq_4) {
                        $per_shipping = $weight->weight_price_4;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    } else {
                        $per_shipping = $weight->weight_price_4 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update([
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ]);
                    }
                }
            } else {
                $per_shipping = $free_shipping->price;

                Cart::where('id', $row->id)
                    ->update([
                        'shipping' => $per_shipping,
                        'ship_type' => null,
                    ]);
            }
        } else {
            Cart::where('id', $row->id)
                ->update([
                    'shipping' => '0',
                    'ship_type' => null,
                ]);
        }

        return $this->orderReview($request);
    }

    public function listOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $invoice = Invoice::first();

        $orders = Order::whereHas('shippingaddress')
            ->whereHas('user')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->get()
            ->transform(function ($order) use ($invoice) {
                $item['id'] = $order->id;
                $item['order_id'] = $invoice->order_prefix . $order->order_id;
                $item['total_qty'] = $order->qty_total;
                $item['payment_method'] = $order->payment_method;
                $item['transaction_id'] = $order->transaction_id;
                $item['total_items'] = $order->invoices()->count();
                $item['currency'] = $order->paid_in_currency;

                $item['order_total'] = (float) sprintf('%.2f', ($order->order_total - $order->shipping - $order->tax_amount - $order->gift_charge));
                $item['tax_amount'] = (float) $order->tax_amount;
                $item['shipping'] = (float) $order->shipping;
                $item['handlingcharge'] = (float) $order->handlingcharge;
                $item['gift_charge'] = (float) $order->gift_charge;
                $item['grand_total'] = (float) $order->order_total + $order->handlingcharge;

                return $item;
            });

        return response()->json(['orders' => $orders, 'status' => 'success'], 200);
    }

    public function viewOrder(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $order = Order::whereHas('invoices')
            ->whereHas('user')
            ->whereHas('shippingaddress')
            ->with(['shippingaddress'])
            ->find($order_id);

        if (!$order) {
            return response()->json([
                'msg' => 'Order not found !',
                'status' => 'fail',
            ]);
        }

        $invoice_fix = Invoice::first();

        $shipping_address = [
            'name' => $order->shippingaddress->name,
            'phone' => $order->shippingaddress->phone,
            'email' => $order->shippingaddress->email,
            'address' => $order->shippingaddress->address,
            'city' => $order->shippingaddress->getcity->name ?? '-',
            'state' => $order->shippingaddress->getstate->name ?? '-',
            'country' => $order->shippingaddress->getCountry->nicename ?? '-',
            'pin_code' => $order->shippingaddress->pin_code,
        ];

        $billing_address = [
            'name' => $order->billing_address['firstname'],
            'phone' => $order->billing_address['mobile'],
            'email' => $order->billing_address['email'],
            'address' => $order->billing_address['address'],
            'city' => Allcity::find($order->billing_address['city']) ? Allcity::find($order->billing_address['city'])->name : '-',
            'state' => Allstate::find($order->billing_address['state']) ? Allstate::find($order->billing_address['state'])->name : '-',
            'country' => Allcountry::find($order->billing_address['country_id']) ? Allcountry::find($order->billing_address['country_id'])->nicename : '-',
            'pin_code' => $order->billing_address['pincode'],
        ];

        $orderitems = [];

        foreach ($order->invoices as $invoice) {
            if (isset($invoice->variant, $invoice->variant->products)) {
                $pname = $invoice->variant->products->getTranslations('name');
            } else {
                $pname = $invoice->simple_product->getTranslations('product_name');
            }

            if (isset($invoice->variant, $invoice->variant->products)) {
                $image = $invoice->variant->variantimages->main_image;
                $thumbpath = url('/variantimages/');
            } else {
                $image = $invoice->simple_products->thumbnail;
                $thumbpath = url('/images/simple_products/');
            }

            $orderitems[] = [
                'invoice_no' => $invoice_fix->prefix . $invoice->inv_no . $invoice_fix->postfix,
                'qty' => $invoice->qty,
                'price' => $invoice->price,
                'igst' => $invoice->igst,
                'cgst' => $invoice->cgst,
                'sgst' => $invoice->sgst,
                'total_tax' => (float) $invoice->tax_amount * $invoice->qty,
                'product_name' => $pname,
                'product_thumb' => $image,
                'thumb_path' => $thumbpath,
                'shipping' => $invoice->shipping,
                'handlingcharge' => $invoice->handlingcharge,
                'gift_charge' => $invoice->gift_charge,
                'status' => ucfirst($invoice->status),
                'tracking_id' => $invoice->tracking_id,
                'courier_channel' => $invoice->courier_channel,
                'tracking_link' => $invoice->tracking_link,
                'exp_delivery_date' => $invoice->exp_delivery_date,
                'cashback' => $invoice->cashback,
            ];
        }

        $order = [
            'id' => (int) $order->id,
            'total_qty' => (int) $order->qty_total,
            'order_id' => $invoice_fix->order_prefix . $order->order_id,
            'shipping_address' => $shipping_address,
            'billing_address' => $billing_address,
            'orderitems' => $orderitems,
            'transaction_id' => $order->transaction_id,
            'payment_method' => $order->payment_method,
            'currency' => $order->paid_in_currency,
            'subtotal' => (float) sprintf('%.2f', ($order->order_total - $order->shipping - $order->tax_amount - $order->gift_charge)),
            'tax' => (float) sprintf('%.2f', $order->tax_amount),
            'shipping' => (float) sprintf('%.2f', $order->shipping),
            'handlingcharge' => (float) sprintf('%.2f', $order->handlingcharge),
            'gift_charge' => (float) sprintf('%.2f', $order->gift_charge),
            'grand_total' => (float) $order->order_total + $order->handlingcharge,
        ];

        return response()->json([
            'order' => $order,
            'status' => 'success',
        ], 200);
    }
}
