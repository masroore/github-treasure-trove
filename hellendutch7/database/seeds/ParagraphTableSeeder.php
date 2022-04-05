<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParagraphTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paras')->insert([
            'page_id' => 1,
            'para_content' => 'Hellen is a Dutch lady who came to live in Borneo in early 2011.',
        ]);

        DB::table('paras')->insert([
            'page_id' => 1,
            'para_content' => 'Coming from a hectic job back in Holland (her home country), which consumed all her time, she finally found time in Borneo to explore her long lost hobbies making paintings & sculptures. Living in Sabah and exploring the underwater world inspired her and shows in a lot of her work that makes her “grow wings". *',
        ]);

        DB::table('paras')->insert([
            'page_id' => 1,
            'para_content' => 'With a degree in In-house Architecture she loves to make objects to show around the house. One of her projects is working with paper (like old newspapers, paper pulp and paper clay) and recycled materials to create sculptures.',
        ]);

        DB::table('paras')->insert([
            'page_id' => 1,
            'para_content' => "* Please note the the original website name of 'Growing Wings' as changed to the artist's name, now 'Hellen Dutch Art'",
        ]);
    }
}
