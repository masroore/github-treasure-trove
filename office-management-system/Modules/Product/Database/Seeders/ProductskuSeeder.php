<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\ProductSku;

class ProductskuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProductSku::insert([

            [
                'id' => 1,
                'product_id' => 1,
                'sku' => 'SKU - Bngp8',
                'stock_quantity' => 25,
                'alert_quantity' => 5,
                'purchase_price' => 75,
                'selling_price' => 95,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 5,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 2,
                'product_id' => 2,
                'sku' => 'sku-aar4545',
                'stock_quantity' => 1000,
                'alert_quantity' => 10,
                'purchase_price' => 1500,
                'selling_price' => 1700,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 5,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 3,
                'product_id' => 3,
                'sku' => 'sku-aar454522',
                'stock_quantity' => 2000,
                'alert_quantity' => 40,
                'purchase_price' => 2000,
                'selling_price' => 2500,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 4,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 4,
                'product_id' => 4,
                'sku' => 'sku-aar454533',
                'stock_quantity' => 200,
                'alert_quantity' => 10,
                'purchase_price' => 3000,
                'selling_price' => 3500,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 4,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 5,
                'product_id' => 5,
                'sku' => 'sku-aar45452233',
                'stock_quantity' => 2000,
                'alert_quantity' => 10,
                'purchase_price' => 200,
                'selling_price' => 240,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 2,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 6,
                'product_id' => 6,
                'sku' => 'sku-aar4545331',
                'stock_quantity' => 200,
                'alert_quantity' => 10,
                'purchase_price' => 2200,
                'selling_price' => 2500,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 3,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 7,
                'product_id' => 7,
                'sku' => 'sku-aar45454345',
                'stock_quantity' => 200,
                'alert_quantity' => 20,
                'purchase_price' => 2200,
                'selling_price' => 2500,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 4,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 10,
                'product_id' => 10,
                'sku' => 'sku-aar454555',
                'stock_quantity' => 200,
                'alert_quantity' => 10,
                'purchase_price' => 1400,
                'selling_price' => 1600,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 5,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

            [
                'id' => 11,
                'product_id' => 11,
                'sku' => 'sku-aar454555',
                'stock_quantity' => 200,
                'alert_quantity' => 10,
                'purchase_price' => 1400,
                'selling_price' => 1600,
                'barcode_type' => 'PHARMA2T',
                'discount_type' => '',
                'discount' => 0,
                'tax_type' => '%',
                'tax' => 5,
                'created_at' => '2020-10-14T13:52:12.000000Z',
                'updated_at' => '2020-10-14T13:52:12.000000Z',
            ],

        ]);
    }
}
