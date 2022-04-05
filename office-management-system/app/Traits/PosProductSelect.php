<?php

namespace App\Traits;

use Modules\Product\Entities\ComboProduct;
use Modules\Product\Entities\ProductSku;

trait PosProductSelect
{
    public function storeSkuProduct($id, $customer)
    {
        $last_price = '';
        $lp = 0;

        $productSku = $this->productRepository->findSku($id);
        $last_price .= '<td style="text-align: right" class="last_price_td">';

        if ($customer && $customer != 1) {
            $customer = $this->contactRepositories->find($customer);
            $sale = $customer->lastPosInvoice;

            if ($sale) {
                $product_item = $sale->items->where('productable_id', $id)->where('productable_type', ProductSku::class)->first();
                if ($product_item) {
                    $lp = $product_item->price;
                    $last_price .= '<input name="last_price" class="primary_input_field product_price_sku" type="number"
                        value="' . $product_item->price . '" readonly>';
                }
            }
        }
        $last_price .= '</td>';
        $skus = session()->get('sku');
        $carts = session()->get('carts');

        $sku[$productSku->sku] = $productSku->sku;

        if (!empty($skus) || !empty($carts)) {
            if ((is_array($skus) && array_key_exists($productSku->sku, $skus)) || (is_array($carts) && array_key_exists('sku-' . $productSku->id, $carts))) {
                return 1;
            }
            if (is_array($skus)) {
                session()->put('sku', $sku + $skus);
            }
        } else {
            session()->put('sku', $sku);
        }

        $variantName = $this->variationRepository->variantName($productSku);
        $option = '';
        foreach ($productSku->part_numbers->where('is_sold', 0) as $key => $part_number) {
            $option .= '<option value="' . $part_number->id . '">' . $part_number->seiral_no . '</option>';
        }
        $type = $productSku->id . ",'sku'";
        $price = $productSku->selling_price + ($productSku->selling_price * $productSku->tax) / 100;
        $taxProduct = ($productSku->selling_price * $productSku->tax) / 100;
        $name = substr($productSku->product->product_name, 0, 40);
        $output = '';
        $output .= '<tr>
                        <input class="product_min_price_sku' . $productSku->id . '" type="hidden" value="' . $productSku->min_selling_price . '">
                        <td data-toggle="tooltip" data-placement="top" title="' . $lp . '"><input type="hidden" name="product_id[]" value="' . $productSku->id . '" class="primary_input_field sku_id' . $productSku->id . '">' . $name . '</br>' . $variantName . '</td>

                        <td>
                        <select class="primary_select sale_type" id="serial_no" name="serial_no[]" multiple>
                            ' . $option . '
                        </select>
                        </td>

                        <td style="text-align: right"><input name="product_price[]" step="0.01" min="' . $productSku->min_selling_price . '" onkeyup="priceCalc(' . $type . ')" class="primary_input_field product_price product_price_sku' . $productSku->id . '" type="number"
                        value="' . $price . '"></td>

                        <td style="text-align: right">
                            <input type="number" name="quantity[]" value="1" onkeyup="addQuantity(' . $type . ')" class="primary_input_field quantity quantity_sku' . $productSku->id . '">
                        </td>

                        <td>
                            <input type="number" name="product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')" class="primary_input_field discount discount_sku' . $productSku->id . '">
                        </td>
                        <input type="hidden" name="product_tax[]" net-sub-total="' . $taxProduct . '" value="' . $productSku->tax . '" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productSku->id . '">

                        <td style="text-align: center" class="product_subtotal product_subtotal_sku' . $productSku->id . '">' . str_replace(',', '', number_format($price, 2)) . '</td>
                        <td style="text-align: right"><a data-id="' . $productSku->id . '" class="delete_product primary-btn primary-circle fix-gr-bg" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>';
        $cart['sku-' . $productSku->id] = [
            'product' => $name,
            'sub_total' => str_replace(',', '', number_format($price, 2)),
            'price' => str_replace(',', '', number_format($price, 2)),
            'min_selling_price' => $productSku->min_selling_price,
            'type' => 'sku',
            'product_sku_id' => $productSku->id,
            'quantity' => 1,
            'taxProduct' => str_replace(',', '', number_format($taxProduct, 2)),
            'taxSku' => $productSku->tax,
        ];

        if (!empty($carts)) {
            session()->put('carts', $carts + $cart);
        } else {
            session()->put('carts', $cart);
        }

        return $output;
    }

    public function storeCombo($id, $customer)
    {
        $productCombo = $this->productRepository->findCombo($id);

        $last_price = '';
        $last_price .= '<td style="text-align: right" class="last_price_td">';

        if ($customer && $customer != 1) {
            $customer = $this->contactRepositories->find($customer);
            $sale = $customer->lastPosInvoice;
            if ($sale) {
                $product_item = $sale->items->where('productable_id', $id)->where('productable_type', ComboProduct::class)->first();
                if ($product_item) {
                    $last_price .= '<input name="last_price_td" class="primary_input_field product_price product_price_sku' . $productCombo->id . '" type="number"
                        value="' . $product_item->price . '" readonly>';
                }
            }
        }
        $last_price .= '</td>';
        $type = $productCombo->id . ",'combo'";
        $skus = session()->get('sku');
        $carts = session()->get('carts');

        $sku[$type] = $type;

        if (!empty($skus) || !empty($carts)) {
            if ((is_array($skus) && array_key_exists($type, $skus)) || (is_array($carts) && array_key_exists('combo-' . $productCombo->id, $carts))) {
                return 1;
            }
            if (is_array($skus)) {
                session()->put('sku', $sku + $skus);
            }
        } else {
            session()->put('sku', $sku);
        }

        $variantName = $this->variationRepository->variantName($productCombo);
        $name = substr($productCombo->name, 0, 40);
        $option = '';
        foreach ($productCombo->combo_products as $key => $combo_product_option) {
            foreach ($combo_product_option->productSku->part_numbers->where('is_sold', 0) as $key => $part_number) {
                $option .= '<option value="' . $productCombo->id . '-' . $part_number->id . '-' . $combo_product_option->product_sku_id . '">' . $part_number->seiral_no . '</option>';
            }
        }
        $output = '';
        $output .= '<tr>
                        <input class="product_min_price_combo' . $productCombo->id . '" type="hidden" value="' . $productCombo->min_selling_price . '">
                    <td><input type="hidden" name="combo_product_id[]" value="' . $productCombo->id . '" class="primary_input_field sku_id' . $productCombo->id . '">' . $name . '</br>' . $variantName . '</td>

                    <td>
                        <select class="primary_select sale_type" id="combo_serial_no" name="combo_serial_no[]" multiple>
                            ' . $option . '
                        </select>
                    </td>

                    <td style="text-align: right"><input type="text" min="' . $productCombo->min_selling_price . '" name="combo_product_price[]" class="primary_input_field product_price product_price_combo' . $productCombo->id . '" value="' . $productCombo->price . '"></td>
                    <input type="hidden" name="product_tax[]"  value="0" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productCombo->id . '">
                    <td style="text-align: right">
                        <input type="number" data-type="combo" name="combo_product_quantity[]" value="1" onfocusout="addQuantity(' . $type . ')"
                        class="primary_input_field quantity quantity_combo' . $productCombo->id . '">
                    </td>
                    <td style="text-align: center" class="product_subtotal product_subtotal_combo' . $productCombo->id . '">' . str_replace(',', '', number_format($productCombo->price, 2)) . '</td>
                    <td style="text-align: right"><a data-id="' . $productCombo->id . '" data-product="' . $productCombo->id . '-Combo" class="primary-btn primary-circle fix-gr-bg delete_product new_delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                    </tr>';

        $cart['combo-' . $productCombo->id] = [
            'product' => $name,
            'sub_total' => str_replace(',', '', number_format($productCombo->price, 2)),
            'price' => str_replace(',', '', number_format($productCombo->price, 2)),
            'type' => 'combo',
            'min_selling_price' => $productCombo->min_selling_price,
            'productable_id' => $productCombo->id,
            'product_sku_id' => $productCombo->id,
            'quantity' => 1,
        ];

        if (!empty($carts)) {
            session()->put('carts', $carts + $cart);
        } else {
            session()->put('carts', $cart);
        }

        return $output;
    }
}
