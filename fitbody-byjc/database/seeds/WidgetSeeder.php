<?php

use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Widget groups
        DB::insert(
            "INSERT INTO `widget_groups` (`id`, `section_id`, `title`, `slug`, `width`, `status`, `created_at`, `updated_at`)
                    VALUES
                        (1, 1, 'Promo 1', 'promo-1', '12', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (2, 1, 'Promo 2', 'promo-2', '12', 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03');"
        );

        // Create Widgets
        DB::insert(
            "INSERT INTO `widgets` (`id`, `group_id`, `title`, `subtitle`, `description`, `image`, `link`, `link_id`, `url`, `badge`, `width`, `sort_order`, `status`, `created_at`, `updated_at`)
                    VALUES
                        (1, 1, 'Mogu li svoju ideju financirati iz EU fondova i kojih?', 'Imate ideju i nedostaje Vam sredstava? Poduzetnik ste, poljoprivrednik, udruga, javna ustanova? Posjetite nas da popričamo o tome kako možete koristiti EU fondove za ostvarenje svojih razvojnih ciljeva', '', '', '', '', '', '', '12', 0, 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (2, 2, 'WHY CHOOSE US', 'Transform, agency working families thinkers who make change happen communities. Developing nations legal aid public sector our ambitions future aid The Elders economic security Rosa.', '', '', '', '', '', '', '4', 0, 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (3, 2, 'OUR MISSION', 'Frontline respond, visionary collaborative cities advancement overcome injustice, UNHCR public-private partnerships cause. Giving, country educate rights-based approach; leverage disrupt solution.', '', '', '', '', '', '', '4', 1, 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03'),
                        (4, 2, 'WHAT YOU GET', 'Sustainability involvement fundraising campaign connect carbon rights, collaborative cities convener truth. Synthesize change lives treatment fluctuation participatory monitoring underprivileged equal.', '', '', '', '', '', '', '4', 2, 1, '2020-01-02 19:08:42', '2020-01-03 00:00:03');"
        );
    }
}
