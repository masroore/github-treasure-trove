<?php

namespace Modules\Sale\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Product\Entities\ProductHistory;
use Modules\Purchase\Entities\PurchaseOrder;

class ProductHistoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        for ($i = 1; $i < 11; ++$i) {
            ProductHistory::insert([
                'type' => 'begining',
                'date' => Carbon::now()->toDateString(),
                'in_out' => '25',
                'product_sku_id' => $i,
                'houseable_id' => '1',
                'houseable_type' => get_class(new PurchaseOrder()),
                'itemable_id' => '1',
                'itemable_type' => get_class(new ShowRoom()),
            ]);
        }
        // $this->call("OthersTableSeeder");
    }
}
