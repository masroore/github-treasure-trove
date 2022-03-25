<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new \App\Votes(
            [
                'title'=> 'This is a default title',
                'content'=> 'This is a default content',
            ]
        );

        $post->save();

        $post = new \App\Votes(
            [
                'title'=> 'This is a default title2',
                'content'=> 'This is a default content2',
            ]
        );

        $post->save();
    }
}
