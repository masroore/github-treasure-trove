<?php

namespace App\Traits;

trait QuotationProductSelect
{
    public function storeSkuSale($id)
    {
        $tax = 0;
        $productSku = $this->productRepository->findSku($id);
        $skus = session()->get('sku');

        $sku[$productSku->sku] = $productSku->sku;

        if (!empty($skus)) {
            if (array_key_exists($productSku->sku, $skus)) {
                return 1;
            }
            session()->put('sku', $sku + $skus);
        } else {
            session()->put('sku', $sku);
        }

        $sub_total = ($productSku->selling_price);

        $variantName = $this->variationRepository->variantName($productSku);

        $type = $productSku->id . ",'sku'";
        $description = $productSku->product->description;
        if (app('general_setting')->origin == 1) {
            $row = '<td class="product_sku' . $productSku->id . '">' . @$productSku->product->origin . '</td>';
        } else {
            $row = null;
        }
        $tax_options = '<input type="number" name="product_tax[]"  value="0" onkeyup="addTax(' . $type . ')" class="primary_input_field tax tax_sku' . $productSku->id . '">';

        $output = '';
        $output .= '<tr>
                        <td><input type="hidden" name="product_id[]" value="' . $productSku->id . '" class="primary_input_field sku_id' . $productSku->id . '">' . $productSku->product->product_name . '</br>' . $variantName . '</td>
                        <td class="product_sku' . $productSku->id . '">' . $description . '</td>
                        ' . $row . '
                        <td>' . @$productSku->product->model->name . '</td>
                        <td>' . @$productSku->product->brand->name . '</td>
                        <td><input name="product_price[]" min="1" onkeyup="priceCalc(' . $type . ')" class="primary_input_field product_price product_price_sku' . $productSku->id . '" type="number"
                        value="' . $productSku->selling_price . '"></td>

                        <td>
                            <input type="number" name="product_quantity[]" value="1" onkeyup="addQuantity(' . $type . ')" class="primary_input_field quantity quantity_sku' . $productSku->id . '">
                        </td>

                        <td>
                            ' . $tax_options . '
                        </td>

                        <td>
                            <input type="number" name="product_discount[]" value="0" onkeyup="addDiscount(' . $type . ')" class="primary_input_field discount discount_sku' . $productSku->id . '">
                        </td>
                        <td style="text-align:center" class="product_subtotal product_subtotal_sku' . $productSku->id . '">' . $sub_total . '</td>
                        <td><a data-id="' . $productSku->id . '" data-product="' . $productSku->id . '-Normal" class="primary-btn primary-circle fix-gr-bg delete_product new_delete_product" href="javascript:void(0)"><i class="ti-trash"></i></a></td>
                        </tr>

                        ';

        return $output;
    }

    public function storeCombo($id)
    {
        $productCombo = $this->productRepository->findCombo($id);
        $type = $productCombo->id . ",'combo'";
        $skus = session()->get('sku');

        $sku[$type] = $type;

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
        $tax = $productCombo->tax ?? 0;
        $output = '';
        $output .= '<tr>
                        <input class="product_min_price_combo' . $productCombo->id . '" type="hidden" value="' . $productCombo->min_selling_price . '">
                        <td><input type="hidden" name="combo_product_id[]" value="' . $productCombo->id . '" class="primary_input_field sku_id' . $productCombo->id . '">' . $name . '</br>' . $variantName . '</td>

                        <td class="product_sku"></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>

                        <td><input type="text" name="combo_product_price[]" class="primary_input_field product_price product_price_combo' . $productCombo->id . '" value="' . $productCombo->price . '"></td>

                            <td><input type="number" data-type="combo" name="combo_product_quantity[]" value="1" onkeyup="addQuantity(' . $type . ')"
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
                        </tr>';

        return $output;
    }
}
