<?php

namespace Modules\Purchase\Repositories;

use App\Traits\Accounts;

use Carbon\Carbon;
use Importer;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Repositories\JournalRepository;
use Modules\Account\Repositories\VoucherRepository;
use Modules\Contact\Entities\ContactModel;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\StockReport;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\PartNumber;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductSellingPriceHistory;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Repositories\ProductRepository;
use Modules\Purchase\Entities\CostOfGoodHistory;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Purchase\Entities\ReceiveProduct;
use Modules\Sale\Entities\Payment;
use Modules\Setup\Entities\Tax;

class PurchaseOrderRepository implements PurchaseOrderRepositoryInterface
{
    use Accounts;

    public function all()
    {
        if (auth()->user()->role->type == 'system_user') {
            return PurchaseOrder::with('supplier', 'payments')->latest()->get();
        }

        return PurchaseOrder::with('supplier', 'payments')->whereHasMorph('purchasable', ShowRoom::class)
            ->where('purchasable_id', session()->get('showroom_id'))->latest()->get();
    }

    public function approvePurchase()
    {
        if (session()->get('showroom_id') == 1) {
            return PurchaseOrder::with('supplier')->where('status', 1)->latest()->get();
        }

        return PurchaseOrder::with('supplier')->whereHasMorph('purchasable', ShowRoom::class)->where('status', 1)
            ->where('purchasable_id', session()->get('showroom_id'))->latest()->get();
    }

    public function create(array $data)
    {
        $error = '';
        $sender = explode('-', $data['showroom']);
        $otherTaxDetails = explode('-', $data['total_tax']);

        if ($otherTaxDetails[1] == 0) {
            $otherTaxDetails[1] = null;
        }

        if ($sender[0] == 'warehouse') {
            $showroom = WareHouse::find($sender[1]);
        } else {
            $showroom = ShowRoom::find($sender[1]);
        }

        $documents = [];
        if (!empty($data['documents'])) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/purchase_order/', $name);
                $documents[] = '/uploads/purchase_order/' . $name;
            }
        }

//        Saving Purchase
        $order = PurchaseOrder::create([
            'supplier_id' => $data['supplier_id'],
            'payment_method' => $data['payment_method'],
            'shipping_address' => $data['shipping_address'],
            'notes' => $data['notes'],
            'documents' => $documents,
            'amount' => $data['item_amount'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'total_quantity' => $data['total_quantity'],
            'total_discount' => $data['total_discount_amount'],
            'discount_amount' => $data['total_discount'],
            'discount_type' => $data['discount_type'],
            'payable_amount' => $data['total_amount'],
            'total_vat' => $data['total_tax'],
            'tax_id' => $otherTaxDetails[1],
            'shipping_charge' => $data['shipping_charge'],
            'other_charge' => $data['other_charge'],
            'ref_no' => $data['ref_no'],
            'lc_no' => $data['lc_no'],
            'cnf_id' => $data['cnf_agent'],
            'purchasable_type' => get_class($showroom),
            'purchasable_id' => $showroom->id,
        ]);

//        Saving Items
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $sub_total = $data['product_price'][$key] * $data['product_quantity'][$key];

                $product = new ProductItemDetail([
                    'product_sku_id' => $data['product_id'][$key],
                    'selling_price' => $data['product_selling_price'][$key],
                    'price' => $data['product_price'][$key],
                    'quantity' => $data['product_quantity'][$key],
                    'tax' => $data['product_tax'][$key],
                    'discount' => $data['product_discount'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['product_id'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);
                $order->items()->save($product);

                $productHistory = new ProductHistory([
                    'type' => 'purchase',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $data['product_quantity'][$key],
                    'product_sku_id' => $data['product_id'][$key],
                    'itemable_id' => $showroom->id,
                    'itemable_type' => get_class($showroom),
                ]);

                $order->houses()->save($productHistory);
            }
        }

        return $order;
    }

    public function find($id)
    {
        return PurchaseOrder::with('items', 'items.product')->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $error = 1;
        $sender = explode('-', $data['showroom']);
        $otherTaxDetails = explode('-', $data['total_tax']);

        if ($otherTaxDetails[1] == 0) {
            $otherTaxDetails[1] = null;
        }

        if ($sender[0] == 'warehouse') {
            $showroom = WareHouse::find($sender[1]);
        } else {
            $showroom = ShowRoom::find($sender[1]);
        }

        //Update Purchase
        $order = PurchaseOrder::find($id);
        $order->supplier_id = $data['supplier_id'];
        $order->shipping_address = $data['shipping_address'];
        $order->notes = $data['notes'];
        $order->date = date('Y-m-d', strtotime($data['date']));
        if (!empty($data['documents'])) {
            $documents = [];
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/purchase_order/', $name);
                $documents[] = '/uploads/purchase_order/' . $name;
            }
            $order->documents = $documents;
        }
        $order->purchasable_id = $showroom->id;
        $order->purchasable_type = get_class($showroom);
        $order->amount = $data['item_amount'];
        $order->total_quantity = $data['total_quantity'];

        $order->total_discount = $data['total_discount_amount'];
        $order->discount_amount = $data['total_discount'];

        $order->discount_type = $data['discount_type'];
        $order->total_vat = $data['total_tax'];
        $order->tax_id = $otherTaxDetails[1];
        $order->shipping_charge = $data['shipping_charge'];
        $order->other_charge = $data['other_charge'];
        $order->payable_amount = $data['total_amount'];
        $order->payable_amount = $data['total_amount'];
        $order->ref_no = $data['ref_no'];
        $order->lc_no = $data['lc_no'];
        $order->cnf_id = $data['cnf_agent'];
        $order->save();

//        Update Items
        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $productsku = ProductItemDetail::where('itemable_id', $order->id)->where('itemable_type', get_class(new PurchaseOrder()))
                    ->where('productable_type', get_class(new ProductSku()))->where('product_sku_id', $data['items'][$key])->first();
                $decreaseQuantity = $data['item_quantity'][$key] - $productsku->quantity; //req 55 - 50 = 5

                $sub_total = $data['item_price'][$key] * $data['item_quantity'][$key];

                $productsku->update([
                    'price' => $data['item_price'][$key],
                    'selling_price' => $data['item_selling_price'][$key],
                    'quantity' => $data['item_quantity'][$key],
                    'tax' => $data['item_tax'][$key],
                    'discount' => $data['item_discount'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['items'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);
                $increaseQuantity = $data['item_quantity'][$key] - $productsku->quantity;

                $history = $order->houses()->where('product_sku_id', $data['items'][$key])->first();
                if ($history) {
                    $history->update(['in_out' => $data['item_quantity'][$key]]);
                }
            }
        }

//        Storing New Items
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
                $sub_total = $data['item_price'][$key] * $data['item_quantity'][$key];

                $product = new ProductItemDetail([
                    'product_sku_id' => $data['product_id'][$key],
                    'selling_price' => $data['product_selling_price'][$key],
                    'price' => $data['product_price'][$key],
                    'quantity' => $data['product_quantity'][$key],
                    'tax' => $data['product_tax'][$key],
                    'discount' => $data['product_discount'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['items'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);
                $order->items()->save($product);

                $productHistory = new ProductHistory([
                    'type' => 'purchase',
                    'date' => Carbon::now()->toDateString(),
                    'in_out' => $data['product_quantity'][$key],
                    'product_sku_id' => $data['product_id'][$key],
                    'itemable_id' => $showroom->id,
                    'itemable_type' => get_class($showroom),
                ]);

                $order->houses()->save($productHistory);
            }
        }

        return $order;
    }

    public function approve($id)
    {
        $purchase = PurchaseOrder::find($id);

        //Chart account find
        $chart_account = $this->AccountFind($purchase->supplier_id, get_class(new ContactModel()));
        $house = $purchase->purchasable;
        $acoountBalance = $purchase->supplier->accounts['due'];
        $main_amount = $purchase->payable_amount;
        $tax_account_amount = 0;
        $single_item_tax = 0;

        //Deleting histories
        foreach ($purchase->items as $product) {
            $history = ProductHistory::where('type', 'purchase')->where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                ->where('product_sku_id', $product->product_sku_id)->first();

            if ($history) {
                $history->status = 1;
                $history->save();
            }

            $tax_account_amount += (($product->price - $product->discount) * $product->quantity) * $product->tax / 100;

            $product_sku_tbl = ProductSku::find($product->product_sku_id);

            $selling_history = ProductSellingPriceHistory::create([
                'product_sku_id' => $product_sku_tbl->id,
                'purchase_order_id' => $purchase->id,
                'old_price' => $product_sku_tbl->selling_price,
                'new_selling_price' => $product->selling_price,
                'updated_by' => auth()->user()->id,
            ]);
            $product_sku_tbl->update([
                'selling_price' => $product->selling_price,
            ]);
        }

        $sub_account_id[] = ChartAccount::where('code', '01-07')->first()->id;
        $sub_amount[] = $purchase->amount - ($purchase->total_discount + $tax_account_amount);
        $sub_narration[] = 'Product Purchase';

        if ($tax_account_amount > 0) {
            $sub_account_id[] = $this->defaultProductTaxAccount(); //Product Tax
            $sub_amount[] = $tax_account_amount;
            $sub_narration[] = 'Purchase Tax';
        }

        if ($purchase->total_vat > 0) {
            $taxDetails = Tax::findOrFail($purchase->tax_id);
            $sub_account_id[] = $this->othersTaxAccountByTaxId($purchase->tax_id);
            $sub_amount[] = $purchase->amount * $purchase->total_vat / 100;
            $sub_narration[] = $taxDetails->name . ' ' . $taxDetails->rate . 'Tax on Purchase';
        }

        if ($purchase->shipping_charge > 0 || $purchase->other_charge > 0) {
            $sub_account_id[] = $this->shippingOrOthersChargeExpense();
            $sub_amount[] = $purchase->shipping_charge + $purchase->other_charge;
            $sub_narration[] = 'Purchase Expense (Shipping and others charge)';
        }

        $repo = new JournalRepository();
//        creating journal
        $repo->create([
            'voucher_type' => 'JV',
            'amount' => $main_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'credit',
            'payment_type' => 'journal_voucher',
            'account_id' => $chart_account ? $chart_account->id : '',
            'main_amount' => $main_amount,
            'narration' => 'Product Purchase',

            'sub_account_id' => array_reverse($sub_account_id),
            'sub_amount' => array_reverse($sub_amount),
            'sub_narration' => array_reverse($sub_narration),

            'sale_id' => $purchase->id,
            'sale_class' => get_class(new PurchaseOrder()),
            'is_approve' => (app('business_settings')->where('type', 'purchase_voucher_approval')->first()->status == 1) ? 1 : 0,
            'is_purchase' => 1,
        ]);

        $voucher = new VoucherRepository();

        foreach ($purchase->payments as $key => $payment) {
            //Transaction Moneydd
            $debit_account_id[] = $this->GetAccountId($purchase->supplier_id, ContactModel::class);

            if ($payment->payment_method == 'cash' || $payment->payment_method == 'quick cash') {
                $credit_account_id = $this->GetAccountId($purchase->purchasable_id, $purchase->purchasable_type); //Cash Account
            } else {
                $credit_account_id = ChartAccount::findOrFail($payment->account_id)->id; //Bank Account
            }
            $totalAmountReceived = $payment->amount + $payment->advance_amount;
            $debit_account_amount[] = ($payment->return_amount > 0) ? $totalAmountReceived - $payment->return_amount : $totalAmountReceived;
            $narration[] = 'Purchase Payment';

//            creating voucher
            $voucher->create([
                'voucher_type' => $payment->payment_method == 'bank' ? 'BV' : 'CV',
                'amount' => ($payment->return_amount > 0) ? $totalAmountReceived - $payment->return_amount : $totalAmountReceived,
                'date' => Carbon::now()->format('Y-m-d'),
                'payment_type' => 'voucher_payment',
                'credit_account_id' => $credit_account_id,
                'credit_account_amount' => ($payment->return_amount > 0) ? $totalAmountReceived - $payment->return_amount : $totalAmountReceived,
                'credit_account_narration' => 'Payment given by ' . $payment->payment_method,
                'debit_account_id' => $debit_account_id,
                'debit_account_amount' => $debit_account_amount,
                'debit_account_narration' => $narration,
                'narration' => 'Payment given by ' . $payment->payment_method,
                'cheque_no' => null,
                'cheque_date' => null,
                'bank_name' => $payment->payment_method == 'bank' ? $payment->bank_name : null,
                'bank_branch' => $payment->payment_method == 'bank' ? $payment->branch : null,
                'sale_id' => $purchase->id,
                'sale_class' => get_class(new PurchaseOrder()),
                'is_approve' => (app('business_settings')->where('type', 'purchase_voucher_approval')->first()->status == 1) ? 1 : 0,
                'is_purchase' => 1,
            ]);
        }

        $purchase->status = 1;

//        saving purchase
        $purchase->save();
        if ($acoountBalance < 0) {
            $extra_amount = abs($chart_account->balanceAmount);
            foreach ($purchase->supplier->purchases->where('is_paid', '!=', 2)->where('is_approved', 1) as $key => $order) {
                if ($order->is_paid != 2) {
                    $due_amount = $order->payable_amount - $order->payments->sum('amount');
                    if ($due_amount > 0 && $extra_amount > 0) {
                        if ($extra_amount >= $due_amount) {
                            $purchase_payment = new Payment([
                                'payment_method' => 'Balance adjust',
                                'amount' => $due_amount,
                                'payable_id' => $order->id,
                                'payable_type' => 'Modules\Purchase\Entities\PurchaseOrder',
                            ]);
                            $order->is_paid = 2;
                            $order->payments()->save($purchase_payment);
                            $order->save();
                        } else {
                            $purchase_payment = new Payment([
                                'payment_method' => 'Balance adjust',
                                'amount' => $extra_amount,
                                'payable_id' => $order->id,
                                'payable_type' => 'Modules\Purchase\Entities\PurchaseOrder',
                            ]);
                            $order->is_paid = 1;
                            $order->payments()->save($purchase_payment);
                            $order->save();
                        }
                        $extra_amount -= $due_amount;
                    }
                }
            }
        }

        return $purchase;
    }

    public function delete($id): void
    {
        $order = PurchaseOrder::find($id);
        //deleting related items and histories
        foreach ($order->items as $item) {
            $histories = ProductHistory::where('houseable_id', $item->itemable_id)->where('houseable_type', $item->itemable_type)->where('product_sku_id', $item->product_sku_id)->get();
            foreach ($histories as $history) {
                $history->delete();
            }
            $item->delete();
        }
        //deleting purchase
        $order->delete();
    }

    public function itemList()
    {
        return PurchaseOrder::with('items', 'items.productSku')->where('return_status', '!=', 2)->latest()->get();
    }

    public function itemUpdate(array $data, $id): void
    {
        $purchase = PurchaseOrder::find($id);

        foreach ($data as $key => $item) {
            $products = ProductItemDetail::find($item['item_id']);
            if ($products) {
                $decreaseQuantity = $item['quantity'] - $products->return_quantity;

                $products->return_quantity = $item['quantity'];

                $sub_total = ($products->price * $item['quantity']);
                $products->return_amount = $sub_total;
                $products->return_date = Carbon::now();
                $products->status = 0;
                $products->save();

                $history = ProductHistory::where('houseable_id', $products->itemable_id)->where('houseable_type', $products->itemable_type)
                    ->where('product_sku_id', $products->product_sku_id)->first();
                if ($history) {
                    $history->in_out -= $decreaseQuantity;
                    $history->status = 0;
                    $history->save();
                    $history = ProductHistory::where('houseable_id', $products->itemable_id)->where('houseable_type', $products->itemable_type)->where('product_sku_id', $products->product_sku_id)->first();
                    $productHistory = new ProductHistory();
                    $productHistory->type = 'purchase_return';
                    $productHistory->date = Carbon::now()->toDateString();
                    $productHistory->in_out = $item['quantity'];
                    $productHistory->product_sku_id = $products->product_sku_id;
                    $productHistory->houseable_id = $products->itemable_id;
                    $productHistory->houseable_type = $products->itemable_type;
                    $productHistory->itemable_id = $history->itemable_id;
                    $productHistory->itemable_type = $history->itemable_type;
                    $productHistory->save();
                }
            }
        }

        $purchase->return_status = 0;

        $purchase->save();
        if (app('business_settings')->where('type', 'purchase_return_approval')->first()->status == 1) {
            $this->returnApprove($purchase->id);
        }
    }

    public function returnApprove($id)
    {
        $order = PurchaseOrder::findOrFail($id);
        $total_amount = 0;
        foreach ($order->items as $product) {
            $history = ProductHistory::where('type', 'purchase_return')->where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                ->where('product_sku_id', $product->product_sku_id)->first();
            if ($history) {
                $history->status = 1;
                $history->save();
                $stocks = StockReport::where('houseable_type', $history->itemable_type)->where('houseable_id', $history->itemable_id)->where('product_sku_id', $history->product_sku_id)->first();
                $stocks->stock -= $history->in_out;
                $stocks->save();
            }
        }
        if ($order->items->sum('return_amount') > 0) {
            $debit_account_id[] = $this->GetAccountId($order->supplier_id, get_class(new ContactModel()));
            $debit_account_amount[] = $order->items->sum('return_amount');
            $narration[] = 'Purchase Return Supplier Account';
            $total_amount += $order->items->sum('return_amount');
        }

        $purchase_account = $this->defaultPurchaseReturnAccount(); //Purchase Return Account
        $repo = new JournalRepository();
        $repo->create([
            'voucher_type' => 'JV',
            'amount' => $total_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'credit',
            'payment_type' => 'journal_voucher',
            'account_id' => $purchase_account->id,
            'main_amount' => $total_amount,
            'narration' => 'Purchase Return Account',

            'sub_account_id' => $debit_account_id,
            'sub_amount' => $debit_account_amount,
            'sub_narration' => $narration,
            'sale_id' => $order->id,
            'sale_class' => get_class(new PurchaseOrder()),
            'is_approve' => (app('business_settings')->where('type', 'purchase_return_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        $order->return_status = 1;
        $order->save();

        return $order;
    }

    public function payments(array $payments, $id): void
    {
        $order = PurchaseOrder::find($id);

        $total_amount = 0;
        $voucher = new VoucherRepository();

        $paid_amount_before = $order->payments->sum('amount');
        $dueAmount = $order->payable_amount - $paid_amount_before;
        foreach ($payments as $key => $payment) {
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
                'amount' => (float) $amount,
                'advance_amount' => (float) $advance_amount,
                'account_id' => array_key_exists('account_id', $payment) ? $payment['account_id'] : '',
                'bank_name' => array_key_exists('bank_name', $payment) ? $payment['bank_name'] : '',
                'branch' => array_key_exists('branch', $payment) ? $payment['branch'] : '',
                'account_no' => array_key_exists('account_no', $payment) ? $payment['account_no'] : '',
                'account_owner' => array_key_exists('account_owner', $payment) ? $payment['account_owner'] : '',
            ]);

            $order->payments()->save($sale_payment);

            if ($order->status != 0) {
                $debit_account_id = [];
                $debit_account_amount = [];
                $narration = [];
                $txAmountValue = $payment['amount'];

                $debit_account_id = $this->GetAccountId($order->supplier_id, get_class(new ContactModel()));

                if ($payment['payment_method'] == 'cash' || $payment['payment_method'] == 'quick cash') {
                    $credit_account_id = $this->GetAccountId($order->purchasable_id, $order->purchasable_type);
                } else {
                    $credit_account_id = ChartAccount::findOrFail($payment['account_id'])->id;
                }

                $tx_amount = (float) $txAmountValue;
                $debit_account_amount = $tx_amount;
                $tx_naration = 'Purchase Payment' . $payment['payment_method'];
                $narration = $tx_naration;
                $voucher->create([
                    'voucher_type' => $payment['payment_method'] == 'bank' ? 'BV' : 'CV',

                    'amount' => $txAmountValue,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'payment_type' => 'voucher_payment',
                    'credit_account_id' => $credit_account_id,

                    'credit_account_amount' => (float) $txAmountValue,
                    'credit_account_narration' => 'Payment given by ' . $payment['payment_method'],

                    'debit_account_id' => $debit_account_id,
                    'debit_account_amount' => $debit_account_amount,
                    'debit_account_narration' => $narration,
                    'narration' => 'Payment given by ' . $payment['payment_method'],
                    'cheque_no' => null,
                    'cheque_date' => null,
                    'bank_name' => $payment['payment_method'] == 'bank' ? $payment['bank_name'] : null,
                    'bank_branch' => $payment['payment_method'] == 'bank' ? $payment['branch'] : null,
                    'sale_id' => $order->id,
                    'sale_class' => get_class(new PurchaseOrder()),
                    'is_approve' => (app('business_settings')->where('type', 'purchase_voucher_approval')->first()->status == 1) ? 1 : 0,
                    'is_purchase' => 1,
                ]);
                $dueAmount -= $payment['amount'];
            }
        }

        $amounts = $order->payments->sum('amount');

        $paid_amount = array_sum(array_column($payments, 'amount')) + $amounts;

        if ($order->payable_amount <= $paid_amount) {
            $order->payments()->where('payment_method', 'quick cash')->update(['return_amount' => $paid_amount - $order->payable_amount]);
            $order->is_paid = 2;
        }
        if ($order->payable_amount > $paid_amount) {
            $order->is_paid = 1;
        }
        $order->save();
    }

    public function addToStock($id, $data)
    {
        $purchase = PurchaseOrder::find($id);
        $house = $purchase->purchasable;

        foreach ($data['product_sku_id'] as $key => $product_id) {
            $receive = new ReceiveProduct();
            $receive->purchase_id = $purchase->id;
            $receive->product_sku_id = $product_id;
            $receive->receive_quantity = $data['quantity'][$key];
            $receive->receive_date = Carbon::now();
            $receive->save();
        }

        $flatAmoutDiscount = $purchase->total_discount / $purchase->items->sum('quantity');

        foreach ($purchase->items as $key => $product) {
            $history = ProductHistory::where('type', 'purchase')->where('houseable_id', $product->itemable_id)->where('houseable_type', $product->itemable_type)
                ->where('product_sku_id', $product->product_sku_id)->first();

            $increasedQuantity = $data['quantity'][$key];

            $stock = $house->stocks()->where('product_sku_id', $product->product_sku_id)->first();

            $previous_cost_of_goods_sold = $product->productSku->cost_of_goods;
            if ($stock) {
                $new_cost_of_goods_sold = ($stock->stock * $previous_cost_of_goods_sold + $increasedQuantity * ($product->price - ($product->discount + $flatAmoutDiscount))) / ($stock->stock + $increasedQuantity);
            } else {
                $new_cost_of_goods_sold = ($increasedQuantity * $product->price) / $increasedQuantity;
            }

            CostOfGoodHistory::create([
                'costable_type' => PurchaseOrder::class,
                'costable_id' => $purchase->id,
                'storeable_type' => $purchase->purchasable_type,
                'storeable_id' => $purchase->purchasable_id,
                'date' => Carbon::now()->toDateString(),
                'product_sku_id' => $product->product_sku_id,
                'previous_remaining_stock' => ($stock) ? $stock->stock : 0,
                'newly_stock' => $increasedQuantity,
                'previous_cost_of_goods_sold' => $previous_cost_of_goods_sold,
                'new_cost_of_goods_sold' => $new_cost_of_goods_sold,
            ]);
            $product->productSku->update(['cost_of_goods' => $new_cost_of_goods_sold]);

            if ($stock) {
                $stock->update(['stock' => $stock->stock + $increasedQuantity]);
            } else {
                StockReport::create([
                    'houseable_id' => $purchase->purchasable_id,
                    'houseable_type' => $purchase->purchasable_type,
                    'stock' => $increasedQuantity,
                    'product_sku_id' => $product->product_sku_id,
                ]);
            }

            if ($history) {
                $history->status = 1;
                $history->save();
            }

            if (!empty($data['serial_no'])) {
                $serials = explode(',', $data['serial_no'][$key]);
                foreach ($serials as $k => $serial) {
                    if ($serial) {
                        $serial_no = new PartNumber();
                        $serial_no->product_sku_id = $product->product_sku_id;
                        $serial_no->seiral_no = $serials[$k];
                        $serial_no->save();
                    }
                }
            }
            if (!empty($data['file'])) {
                $a = $data['file'][$key]->getRealPath();
                foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                    $serial_no = new PartNumber();
                    $serial_no->product_sku_id = $product->product_sku_id;
                    $serial_no->seiral_no = $row[0];
                    $serial_no->save();
                }
            }
        }
        $received = $purchase->receiveProducts->sum('receive_quantity');

        if ($purchase->total_quantity == $received) {
            $purchase->added_to_stock = 1;
        } else {
            $purchase->added_to_stock = 2;
        }

        $purchase->save();

        return $purchase;
    }

    public function adToStockOpening(array $data)
    {
        $error = '';
        $sender = explode('-', $data['showroom']);

        if ($sender[0] == 'warehouse') {
            $showroom = WareHouse::find($sender[1]);
        } else {
            $showroom = ShowRoom::find($sender[1]);
        }
        $repo = new ProductRepository();
        $productSku = $repo->findSku($data['product_sku_id']);
        $product = $productSku->product;
        $productHistory = new ProductHistory([
            'type' => 'begining',
            'date' => date('Y-m-d', strtotime($data['stock_date'])),
            'in_out' => $data['stock_quantity'],
            'product_sku_id' => $data['product_sku_id'],
            'itemable_id' => $showroom->id,
            'itemable_type' => get_class($showroom),
        ]);
        $product->houses()->save($productHistory);

        if (!empty($data['serial_no'])) {
            $serials = explode(',', $data['serial_no']);
            foreach ($serials as $key => $value) {
                $serial_no = new PartNumber();
                $serial_no->product_sku_id = $productSku->id;
                $serial_no->seiral_no = $serials[$key];
                $serial_no->save();
            }
        }
        if (!empty($data['file'])) {
            $a = $data['file']->getRealPath();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $key => $value) {
                $serial_no = new PartNumber();
                $serial_no->product_sku_id = $productSku->id;
                $serial_no->seiral_no = $value[0];
                $serial_no->save();
            }
        }
        $existStock = StockReport::where('houseable_type', get_class($showroom))->where('houseable_id', $showroom->id)->where('product_sku_id', $data['product_sku_id'])->first();

        $previous_cost_of_goods_sold = $productSku->cost_of_goods;
        if ($existStock) {
            $new_cost_of_goods_sold = ($existStock->stock * $previous_cost_of_goods_sold + $data['stock_quantity'] * $data['purchase_price']) / ($existStock->stock + $data['stock_quantity']);
        } else {
            $new_cost_of_goods_sold = ($data['stock_quantity'] * $data['purchase_price']) / $data['stock_quantity'];
        }

        CostOfGoodHistory::create([
            'costable_type' => ProductHistory::class,
            'costable_id' => $productHistory->id,
            'storeable_type' => get_class($showroom),
            'storeable_id' => $showroom->id,
            'date' => Carbon::now()->toDateString(),
            'product_sku_id' => $data['product_sku_id'],
            'previous_remaining_stock' => ($existStock) ? $existStock->stock : 0,
            'newly_stock' => $data['stock_quantity'],
            'previous_cost_of_goods_sold' => $previous_cost_of_goods_sold,
            'new_cost_of_goods_sold' => $new_cost_of_goods_sold,
        ]);
        $productSku->update(['cost_of_goods' => $new_cost_of_goods_sold]);

        if ($existStock) {
            $existStock->update(['stock' => $existStock->stock + $data['stock_quantity']]);
        } else {
            $stocks = new StockReport([
                'stock' => $data['stock_quantity'],
                'product_sku_id' => $data['product_sku_id'],
                'houseable_id' => $showroom->id,
                'houseable_type' => get_class($showroom),
                'stock_date' => date('Y-m-d', strtotime($data['stock_date'])),
            ]);
            $showroom->stocks()->save($stocks);
        }

        $productPrice = ($data['purchase_price'] * $productSku->tax) / 100 + $data['purchase_price'];
        $main_amount = $productPrice * $data['stock_quantity'];
        $sub_account_id[] = ChartAccount::where('code', '02-09-11')->first()->id;
        $sub_amount[] = $main_amount;
        $sub_narration[] = 'Beginning Stock Added By Branch - ' . $showroom->name;

        $repo = new JournalRepository();
        $repo->create([
            'voucher_type' => 'JV',
            'amount' => $main_amount,
            'date' => Carbon::now()->format('Y-m-d'),
            'account_type' => 'debit',
            'payment_type' => 'journal_voucher',
            'account_id' => $this->defaultPurchaseAccount(),
            'main_amount' => $main_amount,
            'narration' => 'Beginning Stock Added By Branch',
            'sub_account_id' => $sub_account_id,
            'sub_amount' => $sub_amount,
            'sub_narration' => $sub_narration,
            'sale_id' => null,
            'sale_class' => null,
            'is_approve' => (app('business_settings')->where('type', 'beginning_stock_voucher_approval')->first()->status == 1) ? 1 : 0,
        ]);

        return $productSku;
    }

    public function purchasePayments($type)
    {
        if (session()->get('showroom_id') == 1) {
            return PurchaseOrder::where('status', 1)->get();
        }

        return PurchaseOrder::where('purchasable_type', ShowRoom::class)->where('purchasable_id', session()->get('showroom_id'))->get();
    }

    public function purchaseDue($type)
    {
        if (session()->get('showroom_id') == 1) {
            return Payment::whereHasMorph('payable', PurchaseOrder::class, function ($query): void {
                $query->where('status', 1);
            })->Payment($type)->get();
        } else {
            return Payment::whereHasMorph('payable', PurchaseOrder::class, function ($query): void {
                $query->where('status', 1)->where('purchasable_type', ShowRoom::class)
                    ->where('purchasable_id', session()->get('showroom_id'));
            })->Payment($type)->get();
        }
    }

    public function supplierProducts($supplier)
    {
        return StockReport::with('suggestProducts')->where('houseable_type', 'Modules\Inventory\Entities\ShowRoom')
            ->where('houseable_id', session()->get('showroom_id'))->whereHas('suggestProducts', function ($query): void {
                $query->whereColumn('alert_quantity', '>=', 'stock_reports.stock');
            })->whereHas('items', function ($query) use ($supplier): void {
                $query->whereHasMorph('itemable', [PurchaseOrder::class], function ($query) use ($supplier): void {
                    $query->where('purchasable_id', session()->get('showroom_id'))->where('purchasable_type', 'Modules\Inventory\Entities\ShowRoom')
                        ->where('supplier_id', $supplier);
                });
            })->get();
    }
}
