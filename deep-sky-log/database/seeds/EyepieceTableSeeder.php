<?php
/**
 * Seeder for the Eyepiece table of the database.
 * Fills the database with the eyepieces from the old database.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

use App\Models\Eyepiece;
use App\Models\EyepieceOld;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder for the eyepiece table of the database.
 * Fills the database with the eyepieces from the old database.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class EyepieceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eyepieceData = EyepieceOld::all();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('eyepieces')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($eyepieceData as $eyepiece) {
            $observer = User::where('username', $eyepiece->observer)->pluck('id');
            if (count($observer) > 0) {
                if ($eyepiece->timestamp == '') {
                    $date = date('Y-m-d H:i:s');
                } else {
                    [$year, $month, $day, $hour, $minute, $second]
                        = sscanf($eyepiece->timestamp, '%4d%2d%2d%2d%2d%d');
                    $date = date(
                        'Y-m-d H:i:s',
                        mktime($hour, $minute, $second, $month, $day, $year)
                    );
                }

                $newEyepiece = Eyepiece::create(
                    [
                        'id' => $eyepiece->id,
                        'name' => html_entity_decode($eyepiece->name),
                        'focalLength' => $eyepiece->focalLength,
                        'apparentFOV' => $eyepiece->apparentFOV,
                        'user_id' => $observer[0],
                        'active' => $eyepiece->eyepieceactive,
                        'created_at' => $date,
                    ]
                );

                if ($eyepiece->maxFocalLength > 0
                    && $eyepiece->maxFocalLength != $eyepiece->focalLength
                ) {
                    $newEyepiece->maxFocalLength = $eyepiece->maxFocalLength;
                    $newEyepiece->save();
                }
            }
        }
    }
}
