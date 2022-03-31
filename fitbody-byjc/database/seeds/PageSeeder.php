<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Categories
        DB::insert(
            "INSERT INTO `pages` (`id`, `category_id`, `name`, `slug`, `description`, `seo_title`, `meta_description`, `meta_keywords`, `image`, `group`, `viewed`, `publish_date`, `lang`, `status`, `created_at`, `updated_at`)
                    VALUES
                        (1, 1, 'O nama', 'o-nama', '<p>O nama opis.</p>', 'O nama', 'O nama meta opis', 'O nama, meta, keys', 'images/pattern.png', '', 0, '0000-00-00 00:00:00', 'hr', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (2, 3, 'Kontakt', 'kontakt', '<p>Kontakt opis</p>', 'Kontakt', 'Kontakt meta opis', 'Kontakt, meta, keys', 'images/pattern.png', '', 0, '0000-00-00 00:00:00', 'hr', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:09'),
                        (3, 2, 'Novost 1', 'novost-1', '<p>Novost 1 opis</p>', 'Novost 1', 'Novost 1 meta opis', 'Novost 1, meta, keys', 'media/images/news.jpeg', '', 0, '0000-00-00 00:00:00', 'hr', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:09'),
                        (4, 2, 'Novost 2', 'novost-2', '<p>Novost 2 opis</p>', 'Novost 2', 'Novost 2 meta opis', 'Novost 2, meta, keys', 'media/images/news.jpeg', '', 0, '0000-00-00 00:00:00', 'hr', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:09');"
        );
    }
}
