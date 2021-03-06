<?php
/**
 * Seeder for the Users table of the database.
 * Fills the database with the users of the old database.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

use App\Models\ObserversOld;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder for the Users table of the database.
 * Fills the database with the users from the old database.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return None
     */
    public function run()
    {
        $accountData = ObserversOld::all();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        foreach ($accountData as $accountSingle) {
            if ($accountSingle->role == 0) {
                $type = 'admin';
            } else {
                $type = 'default';
            }

            if ($accountSingle->id === 'vvs04478'
                || $accountSingle->id === 'Eric VdJ'
                || $accountSingle->id === 'vvs03296'
                || $accountSingle->id === 'wvreeven'
                || $accountSingle->id === 'Jef De Wit'
                || $accountSingle->id === 'Bob Hogeveen'
                || $accountSingle->id === 'yann_admin'
            ) {
                $type = 'admin';
            }

            if ($accountSingle->language == 'en') {
                $language = 'en_US';
            } elseif ($accountSingle->language == 'de') {
                $language = 'de_DE';
            } elseif ($accountSingle->language == 'fr') {
                $language = 'fr_FR';
            } elseif ($accountSingle->language == 'nl') {
                $language = 'nl_NL';
            } elseif ($accountSingle->language == 'sv') {
                $language = 'sv_SV';
            } elseif ($accountSingle->language == 'es') {
                $language = 'es_ES';
            } else {
                $language = 'en_US';
            }

            [$year, $month, $day, $hour, $minute]
                  = sscanf($accountSingle->registrationDate, '%4d%2d%2d %2d:%2d');
            $date = date(
                'Y-m-d H:i:s',
                mktime($hour, $minute, 0, $month, $day, $year)
            );

            $name = html_entity_decode($accountSingle->firstname)
                        . ' ' . html_entity_decode($accountSingle->name);

            if ($accountSingle->id === 'admin') {
                $name = 'Administrator';
            }

            if ($accountSingle->standardAtlasCode == '') {
                $atlas = 'sky';
            } else {
                $atlas = $accountSingle->standardAtlasCode;
            }

            if ($accountSingle->stdlocation == 0) {
                $stdlocation = null;
            } else {
                $stdlocation = $accountSingle->stdlocation;
            }

            if ($accountSingle->stdtelescope == 0) {
                $stdtelescope = null;
            } else {
                $stdtelescope = $accountSingle->stdtelescope;
            }

            if ($accountSingle->id !== 'vvs04478Admin'
                && $accountSingle->id !== 'evdjadmin'
                && $accountSingle->id !== 'TomC_developer'
                && $accountSingle->id !== 'wvreeven-admin'
                && $accountSingle->id !== 'Jef Admin'
                && $accountSingle->id !== 'adminbob'
                && $accountSingle->id !== 'yann_admin'
            ) {
                $user = User::create(
                    [
                        'username' => html_entity_decode($accountSingle->id),
                        'name' => $name,
                        'email' => $accountSingle->email,
                        'email_verified_at' => $date,
                        'type' => $type,
                        'stdlocation' => $stdlocation,
                        'stdtelescope' => $stdtelescope,
                        'language' => $language,
                        'icqname' => $accountSingle->icqname,
                        'observationlanguage' => $accountSingle->observationlanguage,
                        'standardAtlasCode' => $atlas,
                        'fstOffset' => $accountSingle->fstOffset,
                        'copyright' => $accountSingle->copyright,
                        'overviewdsos' => $accountSingle->overviewdsos,
                        'lookupdsos' => $accountSingle->lookupdsos,
                        'detaildsos' => $accountSingle->detaildsos,
                        'overviewstars' => $accountSingle->overviewstars,
                        'lookupstars' => $accountSingle->lookupstars,
                        'detailstars' => $accountSingle->detailstars,
                        'atlaspagefont' => $accountSingle->atlaspagefont,
                        'photosize1' => $accountSingle->photosize1,
                        'overviewFoV' => $accountSingle->overviewFoV,
                        'photosize2' => $accountSingle->photosize2,
                        'lookupFoV' => $accountSingle->lookupFoV,
                        'detailFoV' => $accountSingle->detailFoV,
                        'sendMail' => $accountSingle->sendMail,
                        'version' => $accountSingle->version,
                        'showInches' => $accountSingle->showInches,
                        'created_at' => $date,
                    ]
                );
                $user->setMd5Password($accountSingle->password);
                $user->save();

                // TODO: Make sure to make a link to the correct directory!
                $filename = 'observer_pics/'
                    . $user->username . '.jpg';

                if (file_exists($filename)) {
                    $user
                        ->copyMedia($filename)
                        ->usingFileName($user->username . '.png')
                        ->toMediaCollection('observer');
                }
            }
        }
    }
}
