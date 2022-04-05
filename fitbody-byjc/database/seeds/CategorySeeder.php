<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        DB::insert(
            "INSERT INTO `categories` (`id`, `name`, `description`, `meta_description`, `meta_keyword`, `image`, `parent_id`, `group`, `single_page`, `lang_code`, `top`, `column`, `sort_order`, `status`, `slug`, `created_at`, `updated_at`)
                    VALUES
                        (1, 'O nama', '<p>O nama opis.</p>', 'O nama meta opis', 'O nama, meta, keys', 'images/categories/default.jpg', 0, 'NAVBAR', 1, 'hr', 1, 1, 1, 1, 'o-nama', '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (2, 'Novosti', '<p>Novosti opis.</p>', 'Novosti meta opis', 'Novosti, meta, keys', 'images/categories/default.jpg', 0, 'NAVBAR', 0, 'hr', 1, 1, 2, 1, 'novosti', '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (3, 'Kontakt', '<p>Kontakt opis</p>', 'Kontakt meta opis', 'Kontakt, meta, keys', 'images/categories/default.jpg', 0, 'NAVBAR', 1, 'hr', 1, 1, 3, 1, 'kontakt', '2020-01-02 19:08:42', '2020-01-03 00:00:09');"
        );

        // Create SubCategories
        /*DB::insert(
            "INSERT INTO `categories` (`id`, `name`, `description`, `meta_description`, `meta_keyword`, `image`, `parent_id`, `lang_code`, `top`, `column`, `sort_order`, `status`, `slug`, `created_at`, `updated_at`)
                    VALUES
                        (10, 'Toyota Lifter L', 'Toyota Lifter L', 'Toyota Lifter L', 'Toyota Lifter L', 'images/categories/default.jpg', 1, 'hr', 0, 1, 0, 1, 'rucni-paletni', '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (11, 'Toyota Lifter H', 'Toyota Lifter H', 'Toyota Lifter H', 'Toyota Lifter H', 'images/categories/default.jpg', 1, 'hr', 0, 1, 0, 1, 'elektricni-niskopodizni-paletni', '2020-01-02 19:08:42', '2020-01-03 00:00:09'),
                        (12, 'Toyota Lifter S', 'Toyota Lifter S', 'Toyota Lifter S', 'Toyota Lifter S', 'images/categories/default.jpg', 1, 'hr', 0, 1, 0, 1, 'elektricni-visokopodizni', '2020-01-02 19:08:42', '2020-01-03 00:00:18'),
                        (13, 'Toyota Levio W', 'Toyota Levio W', 'Toyota Levio W', 'Toyota Levio W', 'images/categories/default.jpg', 2, 'hr', 0, 1, 0, 1, 'elektricni-komisioni', '2020-01-02 19:08:42', '2020-01-03 00:00:24'),
                        (14, 'Toyota Levio P', 'Toyota Levio P', 'Toyota Levio P', 'Toyota Levio P', 'images/categories/default.jpg', 2, 'hr', 0, 1, 0, 1, 'elektricni-regalni', '2020-01-02 19:08:42', '2020-01-03 00:00:30'),
                        (15, 'Toyota Levio R', 'Toyota Levio R', 'Toyota Levio R', 'Toyota Levio R', 'images/categories/default.jpg', 2, 'hr', 0, 1, 0, 1, 'elektricni-visokoregalni', '2020-01-02 19:08:42', '2020-01-03 00:00:36'),
                        (16, 'Toyota Levio S', 'Toyota Levio S', 'Toyota Levio S', 'Toyota Levio S', 'images/categories/default.jpg', 2, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:42'),
                        (17, 'Toyota Staxio W', 'Toyota Staxio W', 'Toyota Staxio W', 'Toyota Staxio W', 'images/categories/default.jpg', 3, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:48'),
                        (18, 'Toyota Staxio P', 'Toyota Staxio P', 'Toyota Staxio P', 'Toyota Staxio P', 'images/categories/default.jpg', 3, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (19, 'BT Staxio S', 'BT Staxio S', 'BT Staxio S', 'BT Staxio S', 'images/categories/default.jpg', 3, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (20, 'BT Staxio R', 'BT Staxio R', 'BT Staxio R', 'BT Staxio R', 'images/categories/default.jpg', 3, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (21, 'BT Optio L', 'BT Optio L', 'BT Optio L', 'BT Optio L', 'images/categories/default.jpg', 4, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (22, 'BT Optio M', 'BT Optio M', 'BT Optio M', 'BT Optio M', 'images/categories/default.jpg', 4, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (23, 'BT Optio H', 'BT Optio H', 'BT Optio H', 'BT Optio H', 'images/categories/default.jpg', 4, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (24, 'BT Reflex B', 'BT Reflex B', 'BT Reflex B', 'BT Reflex B', 'images/categories/default.jpg', 5, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (25, 'BT Reflex O', 'BT Reflex O', 'BT Reflex O', 'BT Reflex O', 'images/categories/default.jpg', 5, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (26, 'BT Reflex R/E', 'BT Reflex R/E', 'BT Reflex R/E', 'BT Reflex R/E', 'images/categories/default.jpg', 5, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (27, 'BT Reflex F', 'BT Reflex F', 'BT Reflex F', 'BT Reflex F', 'images/categories/default.jpg', 5, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (28, 'BT Vector R', 'BT Vector R', 'BT Vector R', 'BT Vector R', 'images/categories/default.jpg', 6, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (29, 'BT Vector C', 'BT Vector C', 'BT Vector C', 'BT Vector C', 'images/categories/default.jpg', 6, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (30, 'BT Vector A', 'BT Vector A', 'BT Vector A', 'BT Vector A', 'images/categories/default.jpg', 6, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (31, 'Toyota Traigo 24', 'Toyota Traigo 24', 'Toyota Traigo 24', 'Toyota Traigo 24', 'images/categories/default.jpg', 7, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (32, 'Toyota Traigo 48', 'Toyota Traigo 48', 'Toyota Traigo 48', 'Toyota Traigo 48', 'images/categories/default.jpg', 7, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (33, 'Toyota Traigo 48/3', 'Toyota Traigo 48/3', 'Toyota Traigo 48/3', 'Toyota Traigo 48/3', 'images/categories/default.jpg', 7, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (34, 'Toyota Traigo 80', 'Toyota Traigo 80', 'Toyota Traigo 80', 'Toyota Traigo 80', 'images/categories/default.jpg', 7, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (35, 'Toyota Traigo HT', 'Toyota Traigo HT', 'Toyota Traigo HT', 'Toyota Traigo HT', 'images/categories/default.jpg', 7, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (36, 'Toyota Tonero 3.5', 'Toyota Tonero 3.5', 'Toyota Tonero 3.5', 'Toyota Tonero 3.5', 'images/categories/default.jpg', 8, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (37, 'Toyota Tonero 8', 'Toyota Tonero 8', 'Toyota Tonero 8', 'Toyota Tonero 8', 'images/categories/default.jpg', 8, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (38, 'BT Movit W', 'BT Movit W', 'BT Movit W', 'BT Movit W', 'images/categories/default.jpg', 9, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (39, 'BT Movit N', 'BT Movit N', 'BT Movit N', 'BT Movit N', 'images/categories/default.jpg', 9, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (40, 'BT Movit S', 'BT Movit S', 'BT Movit S', 'BT Movit S', 'images/categories/default.jpg', 9, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (41, 'Toyota Tracto S', 'Toyota Tracto S', 'Toyota Tracto S', 'Toyota Tracto S', 'images/categories/default.jpg', 9, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53'),
                        (42, 'Toyota Tracto R', 'Toyota Tracto R', 'Toyota Tracto R', 'Toyota Tracto R', 'images/categories/default.jpg', 9, 'hr', 0, 1, 0, 1, 'elektricni-ceoni', '2020-01-02 19:08:42', '2020-01-03 00:00:53');"
        );*/
    }
}
