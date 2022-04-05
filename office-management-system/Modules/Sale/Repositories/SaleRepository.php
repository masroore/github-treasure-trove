<?php

namespace Modules\Sale\Repositories;

use App\Repositories\UserRepository;
use App\Traits\Accounts;
use App\Traits\ImageStore;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\JournalRepository;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Contact\Entities\ContactModel;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockReport;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ComboProduct;
use Modules\Product\Entities\PartNumber;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductItemDetailPartNumber;
use Modules\Product\Entities\ProductSku;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Quotation\Entities\Quotation;
use Modules\Sale\Entities\Payment;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\Shipping;
use Modules\Setup\Entities\Tax;

class SaleRepository implements SaleRepositoryInterface
{
    use Accounts;
    use ImageStore;

    public function all()
    {
        if (auth()->user()->role->type == 'system_user') {
            return Sale::with('user', 'customer', 'agentuser', 'items')->latest()->get();
        }

        return Sale::with('user', 'customer', 'agentuser', 'items')->whereHasMorph('saleable', ShowRoom::class)->where('saleable_id', session()->get('showroom_id'))->latest()->get();
    }

    public function approvedSales()
    {
        if ((session()->get('showroom_id') == 1)) {
            return Sale::with('user', 'customer', 'agentuser', 'items')->where('is_approved', 1)->latest()->get();
        }

        return Sale::with('user', 'customer', 'agentuser', 'items')->whereHasMorph('saleable', ShowRoom::class)->where('is_approved', 1)->
            where('saleable_id', session()->get('showroom_id'))->latest()->get();
    }

    public function create(array $data)
    {
        $error = '';
        $tax = explode('-', $data['total_tax']);
        if ($tax[1] == 0) {
            $tax[1] = null;
        }

        $type = explode('-', $data['warehouse_id']);
        if ($type[0] == 'warehouse') {
            $w = WareHouse::find($type[1]);
        } else {
            $w = ShowRoom::find($type[1]);
        }
        if (!empty($data['serial_no'])) {
            foreach ($data['serial_no'] as $key => $serial) {
                $part_number = PartNumber::find($data['serial_no'][$key]);
                $part_number->is_sold = 1;
                $part_number->save();
            }
        }

        $user_type = explode('-', $data['customer_id']);

        $repo = new UserRepository();
        $sale = new Sale([
            'customer_id' => $user_type[0] == 'customer' ? $user_type[1] : null,
            'agent_user_id' => $user_type[0] == 'agent' ? $repo->findUser($user_type[1])->id : null,
            'ref_no' => $data['ref_no'],
            'date' => date('Y-m-d H:i:s', strtotime($data['date'])),
            'notes' => $data['notes'],
            'user_id' => Auth::id(),
            'type' => $data['sale_type'] ?? 1,
            'amount' => $data['item_amount'],
            'total_quantity' => $data['total_quantity'],
            'total_tax' => $tax[0],
            'tax_id' => $tax[1],
            'invoice_no' => $data['invoice_no'],
            'shipping_charge' => $data['shipping_charge'],
            'other_charge' => $data['other_charge'],
            'total_discount' => $data['total_discount_amount'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['total_discount'],
            'payable_amount' => $data['total_amount'],
        ]);

        $w->sales()->save($sale);

        if (array_key_exists('shipping_name', $data) && !empty($data['shipping_name'])) {
            $sale->shipping()->create([
                'shipping_name' => $data['shipping_name'],
            ]);
        }

        if (!empty($data['combo_product_id'])) {
            foreach ($data['combo_product_id'] as $key => $id) {
                $combo = ComboProduct::find($id);
                foreach ($combo->combo_products as $c_product_detail) {
                    $stock = $w->stocks()->where('product_sku_id', $c_product_detail->product_sku_id)->first();
                    $in_out = $data['combo_product_quantity'][$key] * $c_product_detail->product_qty;

                    if ($stock) {
                        if ($stock->stock >= $in_out) {
                            $productHistory = new ProductHistory([
                                'type' => 'sales',
                                'date' => Carbon::now()->toDateString(),
                                'in_out' => $in_out,
                                'product_sku_id' => $c_product_detail->product_sku_id,
                                'itemable_id' => $w->id,
                                'itemable_type' => get_class($w),
                            ]);
                            $sale->houses()->save($productHistory);
                        } else {
                            $sale->delete();
                            $error = 1;

                            return $error;
                        }
                    }
                }

                $sub_total = $data['combo_product_price'][$key] * $data['combo_product_quantity'][$key];
                $comboProduct = new ProductItemDetail([
                    'product_sku_id' => $data['combo_product_id'][$key],
                    'price' => $data['combo_product_price'][$key],
                    'quantity' => $data['combo_product_quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['combo_product_id'][$key],
                    'productable_type' => get_class(new ComboProduct()),
                ]);
                $sale->items()->save($comboProduct);

                if (!empty($data['combo_serial_no'])) {
                    for ($i = 0; $i < count($data['combo_serial_no']); ++$i) {
                        $explode_combo_serial = explode('-', $data['combo_serial_no'][$i]);

                        if ($data['combo_product_id'][$key] == $explode_combo_serial[0]) {
                            $part_number_detail = new ProductItemDetailPartNumber();
                            $part_number_detail->part_number_id = $explode_combo_serial[1];
                            $part_number_detail->sale_id = $sale->id;
                            $part_number_detail->product_sku_id = $explode_combo_serial[2];
                            $part_number_detail->product_item_detail_id = $comboProduct->id;
                            $part_number_detail->save();
                        }
                    }
                }
            }
        }
        $total_tax = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $calculated_tax = ($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['product_tax'][$key] / 100;
                $calculated_discount = (($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['item_discount'][$key]) / 100;

                $sub_total = ((($data['item_price'][$key] * $data['item_quantity'][$key]) + $calculated_tax) - $calculated_discount);
                $productSku = ProductSku::find($data['items'][$key]);

                if ($productSku->product->product_type == 'Service') {
                    $product = new ProductItemDetail([
                        'product_sku_id' => $data['items'][$key],
                        'price' => $data['item_price'][$key],
                        'quantity' => $data['item_quantity'][$key],
                        'tax' => $data['product_tax'][$key],
                        'discount' => $data['item_discount'][$key],
                        'sub_total' => $sub_total,
                        'productable_id' => $data['items'][$key],
                        'productable_type' => get_class(new ProductSku()),
                    ]);
                    $sale->items()->save($product);
                }
                $stock = $w->stocks()->where('product_sku_id', $data['items'][$key])->first();
                if ($stock) {
                    if ($stock->stock >= $data['item_quantity'][$key]) {
                        $product = new ProductItemDetail([
                            'product_sku_id' => $data['items'][$key],
                            'price' => $data['item_price'][$key],
                            'quantity' => $data['item_quantity'][$key],
                            'tax' => $data['product_tax'][$key],
                            'discount' => $data['item_discount'][$key],
                            'sub_total' => $sub_total,
                            'productable_id' => $data['items'][$key],
                            'productable_type' => get_class(new ProductSku()),
                        ]);

                        $sale->items()->save($product);
                        if (!empty($data['serial_no'])) {
                            if (!empty(ProductSku::find($data['items'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id'))) {
                                $part_ids = ProductSku::find($data['items'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id');
                                foreach ($part_ids as $kj => $part_number_only) {
                                    $part_number_detail = new ProductItemDetailPartNumber();
                                    $part_number_detail->part_number_id = $part_ids[$kj];
                                    $part_number_detail->sale_id = $sale->id;
                                    $part_number_detail->product_sku_id = $data['items'][$key];
                                    $part_number_detail->product_item_detail_id = $product->id;
                                    $part_number_detail->save();
                                }
                            }
                        }

                        $productHistory = new ProductHistory([
                            'type' => 'sales',
                            'date' => Carbon::now()->toDateString(),
                            'in_out' => $data['item_quantity'][$key],
                            'product_sku_id' => $data['items'][$key],
                            'itemable_id' => $w->id,
                            'itemable_type' => get_class($w),
                        ]);
                        $sale->houses()->save($productHistory);
                    } else {
                        $sale->delete();
                        $error = 1;

                        return $error;
                    }
                }
            }
        }
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $calculated_tax = (($data['product_price'][$key] * $data['product_quantity'][$key]) * $data['product_tax'][$key]) / 100;
                $calculated_discount = (($data['product_price'][$key] * $data['product_quantity'][$key]) * $data['product_discount'][$key]) / 100;

                $sub_total = ((($data['product_price'][$key] * $data['product_quantity'][$key]) + $calculated_tax) - $calculated_discount);

                $productSku = ProductSku::find($id);

                if ($productSku->product->product_type == 'Service') {
                    $product = new ProductItemDetail([
                        'product_sku_id' => $data['product_id'][$key],
                        'price' => $data['product_price'][$key],
                        'quantity' => $data['product_quantity'][$key],
                        'tax' => $data['product_tax'][$key],
                        'discount' => $data['product_discount'][$key],
                        'sub_total' => $sub_total,
                        'productable_id' => $data['product_id'][$key],
                        'productable_type' => get_class(new ProductSku()),
                    ]);
                    $sale->items()->save($product);
                }
                $stock = $w->stocks()->where('product_sku_id', $id)->first();
                if ($stock) {
                    if ($stock->stock >= $data['product_quantity'][$key]) {
                        $product = new ProductItemDetail([
                            'product_sku_id' => $data['product_id'][$key],
                            'price' => $data['product_price'][$key],
                            'quantity' => $data['product_quantity'][$key],
                            'tax' => $data['product_tax'][$key],
                            'discount' => $data['product_discount'][$key],
                            'sub_total' => $sub_total,
                            'productable_id' => $data['product_id'][$key],
                            'productable_type' => get_class(new ProductSku()),
                        ]);

                        $sale->items()->save($product);
                        if (!empty($data['serial_no'])) {
                            if (!empty(ProductSku::find($data['product_id'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id'))) {
                                $part_ids = ProductSku::find($data['product_id'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id');
                                foreach ($part_ids as $ki => $part_number_only) {
                                    $part_number_detail = new ProductItemDetailPartNumber();
                                    $part_number_detail->part_number_id = $part_ids[$ki];
                                    $part_number_detail->sale_id = $sale->id;
                                    $part_number_detail->product_sku_id = $data['product_id'][$key];
                                    $part_number_detail->product_item_detail_id = $product->id;
                                    $part_number_detail->save();
                                }
                            }
                        }

                        $productHistory = new ProductHistory([
                            'type' => 'sales',
                            'date' => Carbon::now()->toDateString(),
                            'in_out' => $data['product_quantity'][$key],
                            'product_sku_id' => $data['product_id'][$key],
                            'itemable_id' => $w->id,
                            'itemable_type' => get_class($w),
                        ]);
                        $sale->houses()->save($productHistory);
                    } else {
                        $sale->delete();
                        $error = 1;

                        return $error;
                    }
                }
            }
        }
        if (!empty($data['quotation_id'])) {
            $quotation = Quotation::findOrFail($data['quotation_id']);
            $quotation->convert_status = 1;
            $quotation->save();
        }

        return $sale;
    }

    public function payments(array $payments, $id, $initial_payment = 0)
    {
        $sale = Sale::find($id);

        $total_amount = 0;
        $repo = new VoucherRepository();
        $paid_amount_before = $sale->payments->sum('amount');
        $paid_amount = 0;
        $dueAmount = $sale->payable_amount - $paid_amount_before;
        foreach ($payments as $key => $payment) {
            $paid_amount += $payment['amount'];
            if ($payment['amount'] >= $dueAmount) {
                if ($dueAmount > 0) {
                    $amount = $dueAmount;
                    $advance_amount = $payment['amount'] - $amount;
                } else {
                    $amount = 0;
                    $advance_amount = $payment['amount'];
                }
            } else {
                $amount = $payment['amount'];
                $advance_amount = 0;
            }
            $sale_payment = new Payment([
                'payment_method' => $payment['payment_method'],
                'initial_payment' => ($initial_payment == 1) ? 1 : 0,
                'amount' => (float) $amount,
                'advance_amount' => (float) $advance_amount,
                'account_id' => array_key_exists('account_id', $payment) ? $payment['account_id'] : '',
                'bank_name' => array_key_exists('bank_name', $payment) ? $payment['bank_name'] : '',
                'branch' => array_key_exists('branch', $payment) ? $payment['branch'] : '',
                'account_no' => array_key_exists('account_no', $payment) ? $payment['account_no'] : '',
                'account_owner' => array_key_exists('account_owner', $payment) ? $payment['account_owner'] : '',
            ]);
            $sale->payments()->save($sale_payment);

            if ($sale->is_approved != 0) {
                $debit_account_id = [];
                $debit_account_amount = [];
                $narration = [];
                $txAmountValue = $payment['amount'];
                //Transaction Money
                if ($sale->customer_id != null) {
                    $chart_account = $this->AccountFind($sale->customer_id, get_class(new ContactModel()));
                } else {
                    $chart_account = $this->AccountFind($sale->agent_user_id, get_class(new User()));
                }

                if ($payment['payment_method'] == 'cash' || $payment['payment_method'] == 'quick cash') {
                    $debit_account_id = $this->GetAccountId($sale->saleable_id, $sale->saleable_type);
                } else {
                    $debit_account_id = $this->inventoryBankAccount($payment['account_id']);
                }
                $tx_amount = ($dueAmount <= (float) $txAmountValue) ? $dueAmount : (float) $txAmountValue;
                $debit_account_amount = $tx_amount;
                $tx_naration = 'Sales ' . $payment['payment_method'];
                $narration = $tx_naration;
                $dueAmount -= $payment['amount'];
                $repo->create([
                    'voucher_type' => $payment['payment_method'] == 'cash' || $payment['payment_method'] == 'quick cash' ? 'CV' : 'BV',
                    'amount' => ($sale->payable_amount <= (float) $payment['amount']) ? $sale->payable_amount : (float) $payment['amount'],
                    'date' => Carbon::now()->format('Y-m-d'),
                    'payment_type' => 'voucher_recieve',
                    'credit_account_id' => $chart_account->id,  //debit side and credit side shoud be same
                    'credit_account_amount' => ($sale->payable_amount <= (float) $payment['amount']) ? $sale->payable_amount : (float) $payment['amount'],  //debit side and credit side shoud be same
                    'credit_account_narration' => 'Payment recieved by' . $payment['payment_method'],  //debit side and credit side shoud be same

                    'debit_account_id' => $debit_account_id,   //debit side and credit side shoud be same
                    'debit_account_amount' => $debit_account_amount,
                    'debit_account_narration' => $narration,
                    'narration' => 'Payment recieved by' . $payment['payment_method'],
                    'cheque_no' => null,
                    'cheque_date' => null,
                    'bank_name' => $payment['payment_method'] == 'bank' ? $payment['bank_name'] : null,
                    'bank_branch' => $payment['payment_method'] == 'bank' ? $payment['branch'] : null,
                    'sale_id' => $sale->id,
                    'sale_class' => get_class(new Sale()),
                    'is_approve' => (app('business_settings')->where('type', 'sale_voucher_approval')->first()->status == 1) ? 1 : 0,
                ]);
            }
        }

        if ($sale->payable_amount <= $paid_amount) {
            $sale->payments()->where('payment_method', 'quick cash')->update(['return_amount' => $paid_amount - $sale->payable_amount]);
            $sale->status = 1;
        }
        if ($sale->payable_amount > $paid_amount && $paid_amount > 0) {
            $sale->status = 2;
        }
        if ($paid_amount == 0) {
            $pos_order->status = 0;
        }

        $sale->save();

        return $sale;
    }

    public function find($id)
    {
        return Sale::with('items', 'items.product', 'shipping')->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $error = 1;
        $tax = explode('-', $data['total_tax']);
        if ($tax[1] == 0) {
            $tax[1] = null;
        }
        $type = explode('-', $data['warehouse_id']);
        if ($type[0] == 'warehouse') {
            $w = WareHouse::find($type[1]);
        } else {
            $w = ShowRoom::find($type[1]);
        }
        $user_type = explode('-', $data['customer_id']);
        $sale = Sale::find($id);
        foreach ($sale->houses as $productHistory) {
            $productHistory->delete();
        }
        $repo = new UserRepository();

        $sale = Sale::find($id);

        $sale->update([
            'customer_id' => $user_type[0] == 'customer' ? $user_type[1] : null,
            'agent_user_id' => $user_type[0] == 'agent' ? $repo->findUser($user_type[1])->id : null,
            'ref_no' => $data['ref_no'],
            'date' => Carbon::parse($data['date'])->format('Y-m-d'),
            'notes' => $data['notes'],
            'user_id' => Auth::id(),
            'amount' => $data['item_amount'],
            'total_quantity' => $data['total_quantity'],
            'total_discount' => $data['total_discount_amount'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['total_discount'],
            'payable_amount' => $data['total_amount'],
            'shipping_charge' => $data['shipping_charge'],
            'other_charge' => $data['other_charge'],
            'total_tax' => $tax[0],
            'tax_id' => $tax[1],
        ]);

        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $productsku = ProductItemDetail::where('itemable_id', $sale->id)->where('itemable_type', get_class(new Sale()))
                    ->where('productable_type', get_class(new ProductSku()))->where('product_sku_id', $data['items'][$key])->first();

                if (count($productsku->part_number_details) > 0) {
                    $productsku->part_number_details()->delete();
                }

                if (!empty($data['item_serial_no'])) {
                    if (!empty(ProductSku::find($data['items'][$key])->part_numbers->whereIn('id', $data['item_serial_no'])->pluck('id'))) {
                        $part_ids = ProductSku::find($data['items'][$key])->part_numbers->whereIn('id', $data['item_serial_no'])->pluck('id');
                        foreach ($part_ids as $ki => $part_number_only) {
                            $part_number_detail = new ProductItemDetailPartNumber();
                            $part_number_detail->part_number_id = $part_ids[$ki];
                            $part_number_detail->sale_id = $sale->id;
                            $part_number_detail->product_sku_id = $data['items'][$key];
                            $part_number_detail->product_item_detail_id = $productsku->id;
                            $part_number_detail->save();
                        }
                    }
                }

                $decreaseQuantity = $data['item_quantity'][$key] - $productsku->quantity; //req 55 - 50 = 5
                $stock = $w->stocks()->where('product_sku_id', $cart)->first();
                $product = ProductSku::find($data['items'][$key]);

                if ($product->product->product_type != 'Service') {
                    if ($stock->stock >= $decreaseQuantity) {
                        if ($productsku) {
                            $calculated_tax = ($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['product_tax'][$key] / 100;

                            $sub_total = (($data['item_price'][$key] * $data['item_quantity'][$key] + $calculated_tax) - $data['item_discount'][$key]);

                            $productsku->update([
                                'price' => $data['item_price'][$key],
                                'quantity' => $data['item_quantity'][$key],
                                'tax' => $data['product_tax'][$key],
                                'discount' => $data['item_discount'][$key],
                                'sub_total' => $sub_total,
                            ]);
                        }

                        $productHistory = new ProductHistory([
                            'type' => 'sales',
                            'date' => Carbon::now()->toDateString(),
                            'in_out' => $data['item_quantity'][$key],
                            'product_sku_id' => $data['items'][$key],
                            'itemable_id' => $w->id,
                            'itemable_type' => get_class($w),
                        ]);
                        $sale->houses()->save($productHistory);
                    } else {
                        return $error;
                    }
                }
            }
        }

        if (!empty($data['combo_items'])) {
            foreach ($data['combo_items'] as $k => $cart) {
                $productsku = ProductItemDetail::where('itemable_id', $sale->id)->where('itemable_type', get_class(new Sale()))
                    ->where('productable_type', get_class(new ComboProduct()))->where('productable_id', $data['combo_items'][$k])->first();
                $decreaseQuantity = $data['combo_item_quantity'][$k] - $productsku->quantity; //req 55 - 50 = 5

                if (count($productsku->part_number_details) > 0) {
                    $productsku->part_number_details()->delete();
                }

                $combo = ComboProduct::find($data['combo_items'][$k]);

                if (!empty($data['combo_item_serial_no'])) {
                    for ($i = 0; $i < count($data['combo_item_serial_no']); ++$i) {
                        $explode_combo_serial = explode('-', $data['combo_item_serial_no'][$i]);

                        if ($data['combo_items'][$k] == $explode_combo_serial[0]) {
                            $part_number_detail = new ProductItemDetailPartNumber();
                            $part_number_detail->part_number_id = $explode_combo_serial[1];
                            $part_number_detail->sale_id = $sale->id;
                            $part_number_detail->product_sku_id = $explode_combo_serial[2];
                            $part_number_detail->product_item_detail_id = $productsku->id;
                            $part_number_detail->save();
                        }
                    }
                }

                $combo = ComboProduct::find($data['combo_items'][$k]);
                foreach ($combo->combo_products as $c_product_detail) {
                    $stock = $w->stocks()->where('product_sku_id', $c_product_detail->product_sku_id)->first();
                    $in_out = $decreaseQuantity * $c_product_detail->product_qty;
                }

                if ($productsku) {
                    $sub_total = $data['combo_item_price'][$k] * $data['combo_item_quantity'][$k];
                    $productsku->update([
                        'price' => $data['combo_item_price'][$k],
                        'quantity' => $data['combo_item_quantity'][$k],
                        'sub_total' => $sub_total,
                        'productable_id' => $data['combo_items'][$k],
                        'productable_type' => get_class(new ComboProduct()),
                    ]);
                }

                $productHistory = new ProductHistory([
                    'type' => 'sales',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $data['combo_item_quantity'][$k],
                    'product_sku_id' => $data['combo_items'][$k],
                    'itemable_id' => $w->id,
                    'itemable_type' => get_class($w),
                ]);
                $sale->houses()->save($productHistory);
            }
        }

        if (!empty($data['combo_product_id'])) {
            foreach ($data['combo_product_id'] as $key => $id) {
                $combo = ComboProduct::find($id);

                foreach ($combo->combo_products as $c_product_detail) {
                    $stock = $w->stocks()->where('product_sku_id', $c_product_detail->product_sku_id)->first();
                    $in_out = $data['combo_product_quantity'][$key] * $c_product_detail->product_qty;
                    if ($stock) {
                        if ($stock->stock >= $in_out) {
                            $productHistory = new ProductHistory([
                                'type' => 'sales',
                                'date' => Carbon::now()->toDateString(),
                                'in_out' => $in_out, //Kaj krte hobe qty niye ekhane
                                'product_sku_id' => $c_product_detail->product_sku_id, //Kaj krte hobe qty niye ekhane
                                'itemable_id' => $w->id,
                                'itemable_type' => get_class($w),
                            ]);
                            $sale->houses()->save($productHistory);
                        } else {
                            return $error;
                        }
                    }
                }

                if (!empty($data['combo_serial_no'])) {
                    for ($j = 0; $j < count($data['combo_serial_no']); ++$j) {
                        $explode_combo_serial = explode('-', $data['combo_serial_no'][$j]);

                        if ($combo->id == $explode_combo_serial[0]) {
                            $part_number_detail_combo = new ProductItemDetailPartNumber();
                            $part_number_detail_combo->part_number_id = $explode_combo_serial[1];
                            $part_number_detail_combo->sale_id = $sale->id;
                            $part_number_detail_combo->product_sku_id = $explode_combo_serial[2];
                            $part_number_detail_combo->product_item_detail_id = $combo->id;
                            $part_number_detail_combo->save();
                        }
                    }
                }

                $sub_total = $data['combo_product_price'][$key] * $data['combo_product_quantity'][$key];
                $comboProduct = new ProductItemDetail([
                    'product_sku_id' => $data['combo_product_id'][$key],
                    'price' => $data['combo_product_price'][$key],
                    'quantity' => $data['combo_product_quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['combo_product_id'][$key],
                    'productable_type' => get_class(new ComboProduct()),
                ]);
                $sale->items()->save($comboProduct);
            }
        }

        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $stock = $w->stocks()->where('product_sku_id', $id)->first();
                if ($stock) {
                    if ($stock->stock >= $data['product_quantity'][$key]) {
                        $calculated_tax = ($data['product_price'][$key] * $data['product_quantity'][$key]) * $data['product_tax'][$key] / 100;

                        $sub_total = (($data['product_price'][$key] * $data['product_quantity'][$key] + $calculated_tax) - $data['product_discount'][$key]);
                        $product = new ProductItemDetail([
                            'product_sku_id' => $data['product_id'][$key],
                            'price' => $data['product_price'][$key],
                            'quantity' => $data['product_quantity'][$key],
                            'tax' => $data['product_tax'][$key],
                            'discount' => $data['product_discount'][$key],
                            'sub_total' => $sub_total,
                            'productable_id' => $data['product_id'][$key],
                            'productable_type' => get_class(new ProductSku()),
                        ]);

                        $sale->items()->save($product);

                        if (!empty($data['serial_no'])) {
                            if (!empty(ProductSku::find($data['product_id'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id'))) {
                                $part_ids = ProductSku::find($data['product_id'][$key])->part_numbers->whereIn('id', $data['serial_no'])->pluck('id');
                                foreach ($part_ids as $k => $part_number_only) {
                                    $part_number_details = new ProductItemDetailPartNumber();
                                    $part_number_details->part_number_id = $part_ids[$k];
                                    $part_number_details->sale_id = $sale->id;
                                    $part_number_details->product_sku_id = $data['product_id'][$key];
                                    $part_number_details->product_item_detail_id = $product->id;
                                    $part_number_details->save();
                                }
                            }
                        }

                        $productHistory = new ProductHistory([
                            'type' => 'sales',
                            'date' => Carbon::now()->toDateString(),
                            'in_out' => $data['product_quantity'][$key],
                            'product_sku_id' => $data['product_id'][$key],
                            'itemable_id' => $w->id,
                            'itemable_type' => get_class($w),
                        ]);
                        $sale->houses()->save($productHistory);
                    } else {
                        return $error;
                    }
                }
            }
        }

        return $sale;
    }

    public function delete($id): void
    {
        $sale = Sale::findOrFail($id);
        $w = $sale->saleable;
        foreach ($sale->items as $item) {
            ProductHistory::where('houseable_id', $item->itemable_id)->where('houseable_type', $item->itemable_type)->where('product_sku_id', $item->product_sku_id)->delete();
            if ($item->productable_type == 'Modules\\Product\\Entities\\ComboProduct') {
                foreach ($item->productable->combo_products as $key => $combo_product_sku) {
                    $pro_sku = $combo_product_sku->product_sku_id;
                    $qty = $item->quantity * $combo_product_sku->product_qty;
                    $stock = $w->stocks()->where('product_sku_id', $pro_sku)->first();
                    $stock->update(['stock' => $stock->stock + $qty]);
                }
            } else {
                $stock = $w->stocks()->where('product_sku_id', $item->product_sku_id)->first();
                $product = ProductSku::find($item->product_sku_id);
                if ($product->product->product_type != 'Service') {
                    $stock->update(['stock' => $stock->stock + $item->quantity - $item->return_quantity]);
                }
            }

            $item->delete();
        }
        $sale->delete();
    }

    public function itemList()
    {
        return Sale::with('items', 'items.productSku')->where('return_status', '!=', 2)->latest()->get();
    }

    public function itemUpdate(array $data, $item, $id): void
    {
        $type = explode('-', $data['warehouse_id']);
        if ($type[1] == 'warehouse') {
            $w = WareHouse::find($type[0]);
        } else {
            $w = ShowRoom::find($type[0]);
        }
        $sale = Sale::find($id);
        $documents = [];

        if (array_key_exists('documents', $data)) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/sale/' . $name);
                $documents[] = '/uploads/sale/' . $name;
            }
        }

        $sale->document = $documents;
        $sale->return_status = 0;
        $sale->document = '0';
        $sale->save();
        if (!empty($data['item_serial_no'])) {
            foreach ($data['item_serial_no'] as $m => $item_ser) {
                $productItemDetail_id = explode('-', $data['item_serial_no'][$m])[1];
                $part_number_id = explode('-', $data['item_serial_no'][$m])[0];
                $part_details = ProductItemDetailPartNumber::where('product_item_detail_id', $productItemDetail_id)->where('part_number_id', $part_number_id)->first();
                $part_details->is_returned = 1;
                $part_details->save();
            }
        }

        foreach ($item as $key => $product) {
            $products = ProductItemDetail::find($product['item_id']);
            if ($products) {
                $products->return_quantity = $product['quantity'];
                $sub_total = ($products->price * $product['quantity']);
                $products->return_amount = $sub_total;
                $products->return_date = Carbon::now();
                if ($product['quantity'] > 0) {
                    $products->status = 0;
                }
                $products->save();
            }
            if ($products->product_type != 'Service') {
                $productHistory = new ProductHistory([
                    'type' => 'sales_return',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $product['quantity'],
                    'product_sku_id' => $products->product_sku_id,
                    'itemable_id' => $w->id,
                    'itemable_type' => get_class($w),
                ]);
                $sale->houses()->save($productHistory);
            }
        }
        if (app('business_settings')->where('type', 'sale_return_approval')->first()->status == 1) {
            $this->returnApprove($sale->id);
        }
    }

    public function itemDelete($id)
    {
        $product = ProductItemDetail::find($id);
        if ($product) {
            $type = $product->itemable;
            if ($type->saleable) {
                $house_id = $type->saleable_id;
                $house_type = $type->saleable_type;
            } elseif ($type->purchasable) {
                $house_id = $type->purchasable_id;
                $house_type = $type->purchasable_type;
            } elseif ($type->quotationable) {
                $house_id = $type->quotationable_id;
                $house_type = $type->quotationable_type;
            } elseif ($type->packable) {
                $house_id = $type->packable_id;
                $house_type = $type->packable_type;
            }
            ProductHistory::where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                ->where('product_sku_id', $product->product_sku_id)->delete();

            $stock = StockReport::where('houseable_id', $house_id)->where('houseable_type', $house_type)
                ->where('product_sku_id', $product->product_sku_id)->first();
            $stock->stock += $product->quantity;
            $stock->save();
            $product->delete();
        }

        return true;
    }

    public function statusChange($id)
    {
        $sale = Sale::find($id);
        $w = $sale->saleable;
        $part_number_details = $sale->product_item_details_part_numbers;
        if (count($part_number_details) > 0) {
            foreach ($part_number_details as $key => $part_number_detail) {
                $part_number = PartNumber::find($part_number_detail->part_number_id);
                $part_number->is_sold = 1;
                $part_number->save();
            }
        }
        if ($sale->customer_id) {
            $chart_account = $this->AccountFind($sale->customer_id, get_class(new ContactModel()));

            $acoountBalance = $sale->customer->accounts['due'];
        } else {
            $chart_account = $this->AccountFind($sale->agent_user_id, get_class(new User()));

            $acoountBalance = $sale->agentuser->accounts['due'];
        }
        $tax_account_amount = 0;
        $single_item_tax = 0;
        $purchase_amount = 0;
        foreach ($sale->items as $item) {
            if ($item->productable_type == 'Modules\\Product\\Entities\\ComboProduct') {
                foreach ($item->productable->combo_products as $key => $combo_product_sku) {
                    $pro_sku = $combo_product_sku->product_sku_id;
                    $qty = $item->quantity * $combo_product_sku->product_qty;
                    $stock = $w->stocks()->where('product_sku_id', $pro_sku)->first();
                    $stock->update(['stock' => $stock->stock - $qty]);
                }
            } else {
                $productSku = ProductSku::find($item->product_sku_id);

                if ($productSku->product->product_type != 'Service') {
                    $stock = $w->stocks()->where('product_sku_id', $item->product_sku_id)->first();
                    $stock->update(['stock' => $stock->stock - $item->quantity - $item->return_quantity]);
                }
            }
            $tax_account_amount += (($item->price - $item->discount) * $item->quantity) * $item->tax / 100;
            if ($item->productable_type == get_class(new ProductSku())) {
                $purchase_amount += $item->productable->cost_of_goods * $item->quantity;
            } else {
                $purchase_amount += $item->productable->total_purchase_price * $item->quantity;
            }
        }
        $sub_account_id[] = $this->defaultSalesAccount(); //Sales Transacton Account
        $sub_amount[] = $sale->amount - $tax_account_amount;
        $sub_narration[] = 'Product Sales';

        if ($tax_account_amount > 0) {
            $sub_account_id[] = $this->defaultProductTaxAccount(); //Product Tax
            $sub_amount[] = $tax_account_amount;
            $sub_narration[] = 'Product Sale Tax';
        }

        if ($sale->tax_id != 0) {
            $taxDetails = Tax::findOrFail($sale->tax_id);
            $sub_account_id[] = $this->GetAccountId($sale->tax_id, 'Modules\Setup\Entities\Tax');
            $sub_amount[] = (($sale->amount - $sale->total_discount) * $sale->total_tax) / 100;
            $sub_narration[] = $taxDetails->name . ' ' . $taxDetails->rate . 'Tax on Purchase';
        }
        if ($sale->shipping_charge > 0 || $sale->other_charge > 0) {
            $sub_account_id[] = $this->shippingOrOthersChargeIncome();
            $sub_amount[] = $sale->shipping_charge + $sale->other_charge;
            $sub_narration[] = 'Sales Income (Shipping and others charge)';
        }

        $journal = new JournalRepository();
        $journal->create([
            'voucher_type' => 'JV',
            'amount' => $sale->payable_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'debit',
            'payment_type' => 'journal_voucher',
            'account_id' => $chart_account->id,
            'main_amount' => $sale->payable_amount,
            'narration' => 'Product Sales',

            'sub_account_id' => array_reverse($sub_account_id),
            'sub_amount' => array_reverse($sub_amount),
            'sub_narration' => array_reverse($sub_narration),

            'sale_id' => $sale->id,
            'sale_class' => get_class(new Sale()),
            'is_approve' => (app('business_settings')->where('type', 'sale_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        $purchase_sub_account_id[] = $this->defaultCostofGoodsSoldAccount();
        $purchase_sub_amount[] = $purchase_amount;
        $purchase_sub_narration[] = 'Cost of goods sold to customer/Retailer';
        $journal->create([
            'voucher_type' => 'JV',
            'amount' => $purchase_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'credit',
            'payment_type' => 'journal_voucher',
            'account_id' => $this->defaultPurchaseAccount(), //Purchase & Inventory Account
            'main_amount' => $purchase_amount,
            'narration' => 'Inventory deduct for sales purpose',

            'sub_account_id' => $purchase_sub_account_id,
            'sub_amount' => $purchase_sub_amount,
            'sub_narration' => $purchase_sub_narration,
            'sale_id' => $sale->id,
            'sale_class' => get_class(new Sale()),
            'is_approve' => (app('business_settings')->where('type', 'sale_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        $voucher = new VoucherRepository();

        foreach ($sale->payments as $key => $payment) {
            if ($payment->payment_method == 'cash' || $payment->payment_method == 'quick cash') {
                $debit_account_id[] = $this->GetAccountId($sale->saleable_id, $sale->saleable_type); //ChartAccount::where('contactable_type',
            } else {
                $debit_account_id[] = ChartAccount::findOrFail($payment->account_id)->id; //Bank Account
            }
            if ($payment->return_amount > 0) {
                $debit_account_amount[] = ($payment->amount + $payment->advance_amount) - $payment->return_amount;
            } else {
                $debit_account_amount[] = $payment->amount + $payment->advance_amount;
            }
            $narration[] = 'Product Sales';
            $voucher->create([
                'voucher_type' => $payment->payment_method == 'cash' || $payment->payment_method == 'quick cash' ? 'CV' : 'BV',
                'amount' => ($payment->amount + $payment->advance_amount) - $payment->return_amount,
                'date' => Carbon::now()->format('Y-m-d'),
                'payment_type' => 'voucher_recieve',
                'credit_account_id' => $chart_account->id, //debit side and credit side shoud be same
                'credit_account_amount' => ($payment->amount + $payment->advance_amount) - $payment->return_amount, //debit side and credit side shoud be same
                'credit_account_narration' => 'Payment recieved by ' . $payment->payment_method, //debit side and credit side shoud be same

                'debit_account_id' => $debit_account_id, //debit side and credit side shoud be same
                'debit_account_amount' => $debit_account_amount,
                'debit_account_narration' => $narration,
                'narration' => 'Payment recieved by ' . $payment->payment_method,
                'cheque_no' => null,
                'cheque_date' => null,
                'bank_name' => $payment->payment_method == 'bank' ? $payment->bank_name : null,
                'bank_branch' => $payment->payment_method == 'bank' ? $payment->branch : null,
                'sale_id' => $sale->id,
                'sale_class' => get_class(new Sale()),
                'is_approve' => (app('business_settings')->where('type', 'sale_voucher_approval')->first()->status == 1) ? 1 : 0,
            ]);
        }

        $sale->is_approved = 1;

        $sale->save();
        if ($acoountBalance < 0) {
            $extra_amount = abs($acoountBalance);
            if ($sale->customer_id) {
                $customer = ContactModel::find($sale->customer_id);
            } else {
                $customer = User::find($sale->agent_user_id);
            }

            if ($customer->sales) {
                foreach ($customer->sales->where('status', '!=', 1)->where('is_approved', 1) as $key => $sale) {
                    if ($sale->status != 1) {
                        $order = $sale;
                        $due_amount = $order->payable_amount - $order->payments->sum('amount');
                        if ($due_amount > 0 && $extra_amount > 0) {
                            if ($extra_amount >= $due_amount) {
                                $sale_payment = new Payment([
                                    'payment_method' => 'Adjustment Balance',
                                    'amount' => $due_amount,
                                    'payable_id' => $order->id,
                                    'payable_type' => 'Modules\Sale\Entities\Sale',
                                ]);
                                $order->status = 1;
                                $order->payments()->save($sale_payment);
                            } else {
                                $sale_payment = new Payment([
                                    'payment_method' => 'Adjustment Balance',
                                    'amount' => $extra_amount,
                                    'payable_id' => $order->id,
                                    'payable_type' => 'Modules\Sale\Entities\Sale',
                                ]);
                                $order->status = 2;
                                $order->payments()->save($sale_payment);
                            }
                            $extra_amount -= $due_amount;
                        }
                        $order->save();
                    }
                }
            }
        }

        return $sale;
    }

    public function returnApprove($id): void
    {
        $sale = Sale::find($id);
        foreach ($sale->product_item_details_part_numbers->where('is_returned', 1) as $key => $part_details) {
            $part_details->part_number->update(['is_sold' => 0]);
            $part_details->delete();
        }
        $total_amount = 0;
        $purchase_amount = 0;
        foreach ($sale->items as $product) {
            $productSku = ProductSku::find($product->product_sku_id);

            if ($productSku->product->product_type != 'Service') {
                $history = ProductHistory::where('type', 'sales_return')->where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                    ->where('product_sku_id', $product->product_sku_id)->first();
                if ($history) {
                    $history->status = 1;
                    $history->save();
                    $stocks = StockReport::where('houseable_type', $history->itemable_type)->where('houseable_id', $history->itemable_id)->where('product_sku_id', $history->product_sku_id)->first();
                    $stocks->stock += $history->in_out;
                    $stocks->save();
                }
            }

            if ($product->productable_type == get_class(new ProductSku())) {
                $purchase_amount += $product->productable->purchase_price * $product->return_quantity;
            } else {
                $purchase_amount += $product->productable->total_purchase_price * $product->return_quantity;
            }
        }
        if ($sale->items->sum('return_amount') > 0) {
            if ($sale->customer_id) {
                $debit_account_id[] = $this->GetAccountId($sale->customer_id, get_class(new ContactModel()));
            } else {
                $debit_account_id[] = $this->GetAccountId($sale->agent_user_id, get_class(new User()));
            }

            $debit_account_amount[] = $sale->items->sum('return_amount');
            $narration[] = 'Sales Return Supplier Account';
            $total_amount += $sale->items->sum('return_amount');
        }
        $credit_account = $this->defaultSalesReturnAccount(); // Sales Return Account
        $journal = new JournalRepository();

        $journal->create([
            'voucher_type' => 'JV',
            'amount' => $total_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'debit',
            'payment_type' => 'journal_voucher',
            'account_id' => $credit_account->id,  //here will be changed
            'main_amount' => $total_amount,  //debit side and credit side shoud be same
            'narration' => 'Sales Return Account',  //debit side and credit side shoud be same
            'sub_account_id' => $debit_account_id,   //debit side and credit side shoud be same
            'sub_amount' => $debit_account_amount,
            'sub_narration' => $narration,
            'sale_id' => $sale->id,
            'sale_class' => Sale::class,
            'is_approve' => (app('business_settings')->where('type', 'sale_return_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        $purchase_sub_account_id[] = $this->defaultCostofGoodsSoldAccount();
        $purchase_sub_amount[] = $purchase_amount;
        $purchase_sub_narration[] = 'Cost of goods sold return to customer/Retailer';
        $journal->create([
            'voucher_type' => 'JV',
            'amount' => $purchase_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'debit',
            'payment_type' => 'journal_voucher',
            'account_id' => $this->defaultPurchaseAccount(), //Purchase & Inventory Account
            'main_amount' => $purchase_amount,
            'narration' => 'Inventory deduct for sales return purpose',
            'sub_account_id' => $purchase_sub_account_id,
            'sub_amount' => $purchase_sub_amount,
            'sub_narration' => $purchase_sub_narration,
            'sale_id' => $sale->id,
            'sale_class' => get_class(new Sale()),
            'is_approve' => (app('business_settings')->where('type', 'sale_return_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        $sale->return_status = 1;
        $sale->save();
    }

    public function acceptOrder(array $data): void
    {
        $shipping = Shipping::where('sale_id', $data['id'])->latest()->first();
        $shipping->received_by = $data['name'];
        $shipping->received_date = date('Y-m-d', strtotime($data['delivery_date']));
        $shipping->save();
    }

    public function customerDetails(array $data)
    {
        return Sale::with('items')->where('customer_id', $data['customer_id'])->latest()->first();
    }

    public function customerDues($customer_id, $sale_id)
    {
        $sales = Sale::where('customer_id', $customer_id)->where('id', '!=', $sale_id)->pluck('id')->toArray();
        $items = ProductItemDetail::whereHasMorph('itemable', [Sale::class])->whereIn('itemable_id', $sales)->get();
        $payments = Payment::whereHasMorph('payable', [Sale::class])->whereIn('payable_id', $sales)->get();

        $result['payable_price'] = $items->sum('sub_total');
        $result['paid_price'] = $payments->sum('amount');

        return $result;
    }

    public function quotationToSale($data)
    {
        $sale = new Sale();
        $sale->customer_id = $data->customer_id;
        $sale->user_id = $data->user_id;
        $sale->saleable_id = ($data->quotationable_id) ?: ShowRoom::first()->id;
        $sale->saleable_type = ($data->quotationable_type) ?: 'Modules\Inventory\Entities\ShowRoom';
        $sale->amount = $data->amount;
        $sale->total_quantity = $data->total_quantity;
        $sale->total_discount = $data->total_discount;
        $sale->total_tax = $data->total_vat;
        $sale->payable_amount = $data->payable_amount;
        $sale->ref_no = $data->ref_no;
        $sale->status = $data->status;
        $sale->type = 1;
        $sale->is_approved = 0;
        $sale->date = $data->date;
        $sale->save();

        foreach ($data->items as $key => $item) {
            $productItems = ProductItemDetail::find($item->id);
            $productItems->itemable_id = $sale->id;
            $productItems->itemable_type = get_class($sale);
            $productItems->save();
        }

        return $sale;
    }

    public function storeShipping($data)
    {
        $shipping = Shipping::find($data['id']);
        if (!$shipping) {
            $shipping = new Shipping();
        }

        if (array_key_exists('booking_slip', $data)) {
            $file = $data['booking_slip'];
            $name = uniqid() . $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/sale/booking_slip/', $name);
            $booking_slip = '/uploads/sale/booking_slip/' . $name;
        }
        if (array_key_exists('prove_of_delivery', $data)) {
            $file = $data['prove_of_delivery'];
            $name = uniqid() . $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/sale/prove_of_delivery/', $name);
            $prove_of_delivery = '/uploads/sale/prove_of_delivery/' . $name;
        }
        $shipping->sale_id = $data['sale_id'];
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_ref = $data['shipping_ref'];
        $shipping->date = Carbon::parse($data['shipping_date'])->format('Y-m-d');
        if ($data['received_date'] != '') {
            $shipping->received_date = Carbon::parse($data['received_date'])->format('Y-m-d');
        }
        $shipping->received_by = $data['received_by'];
        $shipping->prove_of_delivery = $prove_of_delivery ?? '';
        $shipping->booking_slip = $booking_slip ?? '';
        $shipping->save();

        return $shipping;
    }

    public function customerInvoiceList($customer_id)
    {
        return Sale::where('customer_id', $customer_id)->where('status', '!=', 1)->latest()->get();
    }

    public function retailerInvoiceList($user_id)
    {
        return Sale::where('agent_user_id', $user_id)->where('status', '!=', 1)->latest()->get();
    }

    public function salePayments($type)
    {
        if (session()->get('showroom_id') == 1) {
            return Payment::whereHasMorph('payable', Sale::class, function ($query): void {
                $query->where('is_approved', 1);
            })->Payment($type)->get();
        } else {
            return Payment::whereHasMorph('payable', Sale::class, function ($query): void {
                $query->where('saleable_type', ShowRoom::class)->where('is_approved', 1)
                    ->where('saleable_id', session()->get('showroom_id'));
            })->Payment($type)->get();
        }
    }

    public function saleDue($type)
    {
        if (session()->get('showroom_id') == 1) {
            return Payment::whereHasMorph('payable', Sale::class, function ($query): void {
                $query->where('is_approved', 1);
            })->Payment($type)->get();
        } else {
            return Payment::whereHasMorph('payable', Sale::class, function ($query): void {
                $query->where('saleable_type', ShowRoom::class)->where('is_approved', 1)
                    ->where('saleable_id', session()->get('showroom_id'));
            })->Payment($type)->get();
        }
    }

    public function monthlySales()
    {
        if (session()->get('showroom_id') == 1) {
            return Sale::select(
                DB::raw('sum(payable_amount) as total_sell'),
                DB::raw("DATE_FORMAT(date,'%b') as month_name"),
                DB::raw("DATE_FORMAT(date,'%m') as month")
            )->groupBy('month_name')->whereYear('date', Carbon::now())->orderBy('month', 'asc')->where('is_approved', 1)->get();
        }

        return Sale::where('saleable_type', Sale::class)->where('saleable_id', session()->get('showroom_id'))->select(
            DB::raw('sum(payable_amount) as total_sell'),
            DB::raw("DATE_FORMAT(date,'%b') as month_name"),
            DB::raw("DATE_FORMAT(date,'%m') as month")
        )->groupBy('month_name')->whereYear('date', Carbon::now())->orderBy('month', 'asc')->where('is_approved', 1)->get();
    }

    public function dailySales()
    {
        if (session()->get('showroom_id') == 1) {
            return Sale::select(
                DB::raw('sum(payable_amount) as total_sell'),
                DB::raw('DAY(date) as day'),
                'date'
            )->groupBy('day')->orderBy('day', 'asc')->where('is_approved', 1)->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->get();
        }

        return Sale::where('saleable_type', Sale::class)->where('saleable_id', session()->get('showroom_id'))->select(
            DB::raw('sum(payable_amount) as total_sell'),
            DB::raw('DAY(date) as day'),
            'date'
        )->groupBy('day')->orderBy('day', 'asc')->where('is_approved', 1)->whereMonth('date', Carbon::now())->whereYear('date', Carbon::now())->get();
    }

    public function monthlyShowroomSales()
    {
        return Sale::select(
            DB::raw('sum(payable_amount) as total_sell'),
            DB::raw("DATE_FORMAT(date,'%b') as month_name"),
            DB::raw("DATE_FORMAT(date,'%m') as month")
        )->groupBy('month_name', '')->whereYear('date', Carbon::now())->orderBy('month', 'asc')->where('is_approved', 1)->get();
    }

    public function yearlyShowroomSales()
    {
        return Sale::select(
            DB::raw('sum(payable_amount) as total_sell'),
            DB::raw('YEAR(date) as year')
        )->groupBy('year')->orderBy('year', 'desc')->where('is_approved', 1)->get();
    }

    public function dueList($type)
    {
        if ($type == 'all' && session()->get('showroom_id') == 1) {
            return Sale::where('is_approved', 1)->where('status', '!=', 1)->get();
        } elseif ($type != 'all' && session()->get('showroom_id') == 1) {
            return Sale::where('is_approved', 1)->where('status', '!=', 1)->latest()->take(10)->get();
        } elseif ($type != 'all' && session()->get('showroom_id') != 1) {
            return Sale::where('saleable_type', Sale::class)->where('saleable_id', session()->get('showroom_id'))->where('is_approved', 1)->where('status', '!=', 1)
                ->latest()->take(10)->get();
        } elseif ($type == 'all' && session()->get('showroom_id') != 1) {
            return Sale::where('saleable_type', Sale::class)->where('saleable_id', session()->get('showroom_id'))->where('is_approved', 1)->where('status', '!=', 1)
                ->latest()->get();
        }
    }

    public function dueInvoiceList()
    {
        $sales = [];
        if (session()->has('customer')) {
            $user = session()->get('customer');
            $type = explode('-', $user);
            if ($type[0] == 'agent') {
                $sales = Sale::where('agent_user_id', $type[1])->where('type', '!=', 2)->where('status', '!=', 1)->get();
            } else {
                $sales = Sale::where('customer_id', $type[1])->where('type', '!=', 2)->where('status', '!=', 1)->get();
            }
        }

        return $sales;
    }

    public function saleTotalPayments($type)
    {
        if (session()->get('showroom_id') == 1) {
            return Sale::Payment($type)->sum('payable_amount');
        }

        return Sale::Payment($type)->where('saleable_type', ShowRoom::class)->where('saleable_id', session()->get('showroom_id'))->sum('payable_amount');
    }
}
