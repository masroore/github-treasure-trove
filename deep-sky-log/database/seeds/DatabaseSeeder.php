<?php

/**
 * Seeder for the database.
 * Fills the database with random values.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

use Database\Seeders\AddTargetNameSeeder;
use Database\Seeders\updateCometNames;
use EyepieceBrandSeeder;
use EyepieceTableSeeder;
use EyepieceTypeSeeder;
use FilterTableSeeder;
use Illuminate\Database\Seeder;
use InstrumentTableSeeder;
use LensTableSeeder;
use LocationTableSeeder;
use MessagesTableSeeder;
use MoonSeeder;
use ObservationListSeeder;
use SbObjSeeder;
use TargetNameTableSeeder;
use TargetPartOfTableSeeder;
use TargetTableSeeder;
use UsersTableSeeder;

/**
 * Seeder for the database.
 * Fills the database with random values.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                UsersTableSeeder::class, LensTableSeeder::class,
                FilterTableSeeder::class, EyepieceTableSeeder::class,
                EyepieceBrandSeeder::class, EyepieceTypeSeeder::class,
                MessagesTableSeeder::class, InstrumentTableSeeder::class,
                LocationTableSeeder::class, TargetTableSeeder::class,
                TargetNameTableSeeder::class, TargetPartOfTableSeeder::class,
                MoonSeeder::class, SbObjSeeder::class, AddTargetNameSeeder::class,
                ObservationListSeeder::class,
                updateCometNames::class, ]
        );
    }
}
