<?php

namespace App\Traits;

use Modules\Product\Entities\ComboProduct;

trait SaleProductSelect
{
    public function storeSkuSale($id, $customer)
    {
        $last_price = '';
        $tax = 0;

        $productSku = $this->productRepository->findSku($id);
        $type = $productSku->id . ",'sku'";

        $skus = session()->get('sku');

        $sku[$productSku->sku] = $productSku->sku;

        if (!empty($skus) && count($skus) > 0) {
            if (array_key_exists($productSku->sku, $skus)) {
                return 1;
            }
            session()->put('sku', $sku + $skus);
        } else {
            session()->put('sku', $sku);
        }

        $sub_total = ($productSku->selling_price);

        $variantName = $this->variationRepository->variantName($productSku);

        $option = '';
        foreach ($productSku->part_numbers->where('is_sold', 0) as $key => $part_number) {
            $option .= '<option value="' . $part_number->id . '">' . $part_number->seiral_no . '</option>';
        }
        if (app('general_setting')->origin == 1) {
            $row = '<td class="product_sku' . $productSku->id . '">' . $productSku->product->origin . '</td>';
        } else {
            $row = '<td class="product_sku' . $productSku->id . '">' . $productSku->sku . '</td>';
        }
        $output = '';
        $output .= '<tr>
                        <input class="product_min_price_sku' . $productSku->id . '" type="hidden" value="' . $productSku->min_selling_price . '" >
                        <td><input type="hidden" name="product_id[]" value="' . $productSku->id . '" class="primary_input_field sku_id' . $productSku->id . '">' . $productSku->product->product_name . '</br>' . $variantName . '</td>

                        ' . $row . '
                        <td>' . @$productSku->product->model->name . '</td>
                        <td>' . @$productSku->product->brand->name . '</td>
                        <td class="d-none">
                        <select class="primary_select mb-15 sale_type" id="serial_no" name="serial_no[]" multiple>
                            ' . $option . '
                        </select>
                        </td>

                        <td><input name="product_price[]" min="' . $productSku->cost_of_goods . '" onkeyup="priceCalc(' . $type . ')" class="primary_input_field product_price product_price_sku' . $productSku->id . '" type="number"
                        value="' . $productSku->selling_price . '"></td>


                        <td>
                            <input type="number" name="product_quantity[]" value="1" onkeyup="addQuantity(' . $type . ')" class="primary_input_field quantity quantity_sku' . $productSku->id . '">
                        </td>

                        <td>
                            <input type="number" name="product_tax[]"  value="' . $productSku->tax . '" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productSku->id . '">
                        </td>

                        <td>
                            <input type="number" name="product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')" class="primary_input_field discount discount_sku' . $productSku->id . '">
                        </td>
                        <td style="text-align:center" class="product_subtotal product_subtotal_sku' . $productSku->id . '">' . $sub_total . '</td>
                        <td><a data-id="' . $productSku->id . '" data-product="' . $productSku->id . '-Normal" class="primary-btn primary-circle fix-gr-bg delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

        return $output;
    }

    public function storeCombo($id, $customer)
    {
        $tax = 0;
        $productCombo = $this->productRepository->findCombo($id);
        $type = $productCombo->id . ",'combo'";
        $skus = session()->get('sku');
        $last_price = '';
        $last_price .= '<td style="text-align: right" class="last_price_td">';
        if ($customer && $customer != 1) {
            $customer_type = explode('-', $customer);

            $customer = $this->contactRepositories->find($customer_type[1]);
            if ($customer != null) {
                $sale = $customer->lastPosInvoice;

                if ($sale) {
                    $product_item = $sale->items->where('productable_id', $id)->where('productable_type', ComboProduct::class)->first();
                    if ($product_item) {
                        $last_price .= '<input name="last_price_td" class="primary_input_field product_price product_price_sku' . $productCombo->id . '" type="number"
                            value="' . $product_item->price . '" readonly>';
                    }
                }
            }
        }
        $last_price .= '</td>';
        $sku[$type] = $type;

        $skU = '';
        foreach ($productCombo->combo_products as $key => $combo_product) {
            $skU .= $combo_product->productSku->sku . '</br>';
        }
        $option = '';
        foreach ($productCombo->combo_products as $key => $combo_product_option) {
            foreach ($combo_product_option->productSku->part_numbers->where('is_sold', 0) as $key => $part_number) {
                $option .= '<option value="' . $productCombo->id . '-' . $part_number->id . '-' . $combo_product_option->product_sku_id . '">' . $part_number->seiral_no . '</option>';
            }
        }

        if (!empty($skus)) {
            if (array_key_exists($type, $skus)) {
                return 1;
            }
            session()->put('sku', $sku + $skus);
        } else {
            session()->put('sku', $sku);
        }

        $variantName = $this->variationRepository->comboVariant($productCombo);

        $type = $productCombo->id . ",'combo'";
        $name = substr($productCombo->name, 0, 40);

        $output = '';
        $output .= '<tr>
                        <input class="product_min_price_combo' . $productCombo->id . '" type="hidden" value="' . $productCombo->min_selling_price . '" >
                        <td><input type="hidden" name="combo_product_id[]" value="' . $productCombo->id . '" class="primary_input_field sku_id' . $productCombo->id . '">' . $name . '</br>' . $variantName . '</td>

                        <td class="product_sku">' . $skU . '</td>
                        <td></td>
                        <td></td>
                        <td class="d-none">
                            <select class="primary_select mb-15 sale_type" id="combo_serial_no" name="combo_serial_no[]" multiple>
                                ' . $option . '
                            </select>
                        </td>
                        <td><input type="text" name="combo_product_price[]" class="primary_input_field product_price product_price_combo' . $productCombo->id . '" value="' . $productCombo->price . '"></td>


                        <td>
                            <input type="number" data-type="combo" name="combo_product_quantity[]" value="1" oninput="addQuantity(' . $type . ')"
                            class="primary_input_field quantity quantity_combo' . $productCombo->id . '">
                        </td>

                        <td>
                            <input type="number" name="product_tax[]"  value="0" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productCombo->id . '">
                        </td>

                        <td>
                            <input type="number" data-type="combo" name="combo_product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')"
                            class="primary_input_field discount discount_combo' . $productCombo->id . '">
                        </td>
                        <td style="text-align:center" class="product_subtotal product_subtotal_combo' . $productCombo->id . '">' . $productCombo->price . '</td>
                        <td><a data-id="' . $productCombo->id . '" data-product="' . $productCombo->id . '-Combo" class="primary-btn primary-circle fix-gr-bg delete_product new_delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

        return $output;
    }
}
