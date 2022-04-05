<?php

namespace Modules\Quotation\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ComboProduct;
use Modules\Product\Entities\ProductSku;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Quotation\Entities\Quotation;
use Modules\Setup\Entities\IntroPrefix;

class QuotationRepository implements QuotationRepositoryInterface
{
    public function all()
    {
        return Quotation::with('quotationable', 'user', 'customer')->whereHasMorph('quotationable', ShowRoom::class)->where('quotationable_id', session()->get('showroom_id'))->orWhere('quotationable_id', null)->latest()->get();
    }

    public function create(array $data)
    {
        $documents = [];
        if (!empty($data['total_tax'])) {
            $tax = explode('-', $data['total_tax']);
            if ($tax[1] == 0) {
                $tax[1] = null;
            }
        }
        if (array_key_exists('documents', $data)) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/quotation/', $name);
                $documents[] = '/uploads/quotation/' . $name;
            }
        }
        if ($data['showroom'] != null) {
            $type = explode('-', $data['showroom']);
            if ($type[0] == 'warehouse') {
                $showroom = WareHouse::find($type[1]);
            } else {
                $showroom = ShowRoom::find($type[1]);
            }
        } else {
            $showroom = null;
        }

        $quotation = Quotation::create([
            'customer_id' => $data['customer_id'],
            'date' => Carbon::parse($data['date'])->format('Y-m-d'),
            'valid_till_date' => Carbon::parse($data['valid_till_date'])->format('Y-m-d'),
            'notes' => $data['notes'],
            'user_id' => Auth::id(),
            'shipping_address' => $data['shipping_address'],
            'document' => $documents,
            'amount' => $data['item_amount'],
            'ref_no' => $data['ref_no'],
            'po' => $data['po'],
            'total_quantity' => $data['total_quantity'],
            'total_vat' => $tax[0],
            'total_discount' => $data['total_discount_amount'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['total_discount'],
            'payable_amount' => $data['total_amount'],
            'shipping_charge' => $data['shipping_charge'],
            'other_charge' => $data['other_charge'],
            'quotationable_id' => ($showroom) ? $showroom->id : null,
            'quotationable_type' => ($showroom) ? get_class($showroom) : null,
        ]);

        if (!empty($data['combo_product_id'])) {
            foreach ($data['combo_product_id'] as $key => $id) {
                $sub_total = $data['combo_product_price'][$key] * $data['combo_product_quantity'][$key];
                $comboProduct = new ProductItemDetail([
                    'product_sku_id' => $data['combo_product_id'][$key],
                    'price' => $data['combo_product_price'][$key],
                    'quantity' => $data['combo_product_quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['combo_product_id'][$key],
                    'productable_type' => get_class(new ComboProduct()),
                ]);
                $quotation->items()->save($comboProduct);
            }
        }
        $total_tax = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $calculated_tax = ($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['item_tax'][$key] / 100;
                $calculated_discount = (($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['item_discount'][$key]) / 100;

                $sub_total = ((($data['item_price'][$key] * $data['item_quantity'][$key]) + $calculated_tax) - $calculated_discount);
                $product = new ProductItemDetail([
                    'product_sku_id' => $data['items'][$key],
                    'price' => $data['item_price'][$key],
                    'quantity' => $data['item_quantity'][$key],
                    'tax' => $data['item_tax'][$key],
                    'discount' => $data['item_discount'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['items'][$key],
                    'productable_type' => get_class(new ProductSku()),
                ]);

                $quotation->items()->save($product);
            }
        }
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
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
                $quotation->items()->save($product);
            }
        }

        return $quotation;
    }

    public function find($id)
    {
        return Quotation::with('items', 'items.product', 'customer', 'user', 'showroom')->findOrFail($id);
    }

    public function findToConvert($id): void
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->convert_status = 1;
        $quotation->save();
    }

    public function update(array $data, $id): void
    {
        $quotation = Quotation::find($id);
        if (!empty($data['total_tax'])) {
            $tax = explode('-', $data['total_tax']);
            $tax = explode('-', $data['total_tax']);
            if ($tax[1] == 0) {
                $tax[1] = null;
            }
        }
        if ($data['showroom'] != null) {
            $type = explode('-', $data['showroom']);
            if ($type[0] == 'warehouse') {
                $showroom = WareHouse::find($type[1]);
            } else {
                $showroom = ShowRoom::find($type[1]);
            }
        } else {
            $showroom = null;
        }

        $documents = [];

        if (array_key_exists('documents', $data)) {
            foreach ($data['documents'] as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/quotation/', $name);
                $documents[] = '/uploads/quotation/' . $name;
            }
            $attachment = $documents;
        } else {
            $attachment = $quotation->documents;
        }

        $quotation->update([
            'customer_id' => $data['customer_id'],
            'date' => Carbon::parse($data['date'])->format('Y-m-d'),
            'valid_till_date' => Carbon::parse($data['valid_till_date'])->format('Y-m-d'),
            'notes' => $data['notes'],
            'user_id' => Auth::id(),
            'shipping_address' => $data['shipping_address'],
            'document' => $documents,
            'amount' => $data['item_amount'],
            'ref_no' => $data['ref_no'],
            'po' => $data['po'],
            'total_quantity' => $data['total_quantity'],
            'total_vat' => $tax[0],
            'total_discount' => $data['total_discount_amount'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['total_discount'],
            'payable_amount' => $data['total_amount'],
            'shipping_charge' => $data['shipping_charge'],
            'other_charge' => $data['other_charge'],
            'quotationable_id' => ($showroom) ? $showroom->id : null,
            'quotationable_type' => ($showroom) ? get_class($showroom) : null,
        ]);
        if (!empty($data['items'])) {
            foreach ($data['items'] as $key => $cart) {
                $productsku = ProductItemDetail::where('itemable_id', $id)->where('itemable_type', get_class(new Quotation()))
                    ->where('productable_type', get_class(new ProductSku()))->where('product_sku_id', $data['items'][$key])->first();

                if ($productsku) {
                    $calculated_tax = ($data['item_price'][$key] * $data['item_quantity'][$key]) * $data['item_tax'][$key] / 100;

                    $sub_total = (($data['item_price'][$key] * $data['item_quantity'][$key] + $calculated_tax) - $data['item_discount'][$key]);

                    $productsku->update([
                        'price' => $data['item_price'][$key],
                        'quantity' => $data['item_quantity'][$key],
                        'tax' => $data['item_tax'][$key],
                        'discount' => $data['item_discount'][$key],
                        'sub_total' => $sub_total,
                    ]);
                }
            }
        }

        if (!empty($data['combo_items'])) {
            foreach ($data['combo_items'] as $k => $cart) {
                $productsku = ProductItemDetail::where('itemable_id', $id)->where('itemable_type', get_class(new Quotation()))
                    ->where('productable_type', get_class(new ComboProduct()))->where('productable_id', $data['combo_items'][$k])->first();

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
            }
        }

        if (!empty($data['combo_product_id'])) {
            foreach ($data['combo_product_id'] as $key => $id) {
                $sub_total = $data['combo_product_price'][$key] * $data['combo_product_quantity'][$key];
                $comboProduct = new ProductItemDetail([
                    'product_sku_id' => $data['combo_product_id'][$key],
                    'price' => $data['combo_product_price'][$key],
                    'quantity' => $data['combo_product_quantity'][$key],
                    'sub_total' => $sub_total,
                    'productable_id' => $data['combo_product_id'][$key],
                    'productable_type' => get_class(new ComboProduct()),
                ]);
                $quotation->items()->save($comboProduct);
            }
        }
        $total_tax = 0;
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $key => $id) {
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
                $quotation->items()->save($product);
            }
        }
    }

    public function delete($id): void
    {
        $quotation = Quotation::find($id);

        $quotation->items()->delete();
        $quotation->delete();
    }

    public function statusChange($id): void
    {
        $sale = Quotation::find($id);
        $sale->status = 1;
        $sale->save();
    }

    public function cloneQuotation($id): void
    {
        $quotation = Quotation::find($id);
        $quotation_new = $quotation->replicate();
        $quotation_new->invoice_no = IntroPrefix::find(4)->prefix . '-' . date('y') . date('m') . Auth::id();
        $quotation_new->save();
        $quotation_new->update(['invoice_no' => IntroPrefix::find(4)->prefix . '-' . date('y') . date('m') . Auth::id() . $quotation_new->id]);
        foreach ($quotation->items as $item) {
            $item_old = ProductItemDetail::find($item->id);
            $item_new = $item_old->replicate();
            $item_new->itemable_id = $quotation_new->id;
            $item_new->save();
        }
    }
}
