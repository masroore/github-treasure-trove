<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('faqs')->delete();

        DB::table('faqs')->insert([
            0 => [
                'id' => 1,
                'que' => '{"en":"Hello world"}',
                'ans' => '{"en":"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam accusantium aliquid eaque fugit perferendis et commodi facilis animi ratione laborum dignissimos suscipit aut provident minima culpa ab fuga, expedita dolores aliquam qui facere inventore amet illum eligendi! Facere nobis fuga doloribus iure architecto, distinctio expedita, labore dolore reprehenderit, quisquam commodi."}',
                'status' => '1',
                'created_at' => '2020-04-06 19:59:23',
                'updated_at' => '2020-04-06 19:59:23',
            ],
            1 => [
                'id' => 2,
                'que' => '{"en":"Second world"}',
                'ans' => '{"en":"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam accusantium aliquid eaque fugit perferendis et commodi facilis animi ratione laborum dignissimos suscipit aut provident minima culpa ab fuga, expedita dolores aliquam qui facere inventore amet illum eligendi! Facere nobis fuga doloribus iure architecto, distinctio expedita, labore dolore reprehenderit, quisquam commodi."}',
                'status' => '1',
                'created_at' => '2020-04-06 19:59:29',
                'updated_at' => '2020-04-06 19:59:29',
            ],
        ]);
    }
}
