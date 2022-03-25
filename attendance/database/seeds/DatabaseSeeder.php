<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(Releaseresultsseeder::class);
        // $this->call(Releasepollsresultsseeder::class);
        $this->call(Academicseeder::class);

        //$this->call(StarterSeeder::class);

        //$this->call(Programseeder::class);
        // $this->call(OsdcodeSeeder::class);

        //$this->call(Studentinfoseeder::class);
        //$this->call(PaymentDeadlineseeder::class);

        $this->call(CoureregistrationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(OtherservicesFeesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MenupermissionsTableSeeder::class);
        $this->call(MandatoryFeesTableSeeder::class);
        $this->call(LecCourcesTableSeeder::class);
        $this->call(HallsTableSeeder::class);
        $this->call(ExamresultsTableSeeder::class);
        $this->call(PaymentdeadlinesTableSeeder::class);
        $this->call(PaystacklogsTableSeeder::class);
        $this->call(PaystackmodelsTableSeeder::class);
        $this->call(ProgrammecoursesTableSeeder::class);
        $this->call(ProgrammesTableSeeder::class);
        $this->call(RegacademicyearsTableSeeder::class);
        $this->call(ResultsreleasesTableSeeder::class);
        $this->call(SemesterfeesTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(StudentfeesTableSeeder::class);
        $this->call(StudentgroupingsTableSeeder::class);
        $this->call(StudentinfosTableSeeder::class);
        $this->call(SubMenusTableSeeder::class);
        $this->call(TimetablegroupsTableSeeder::class);
        $this->call(TimetablesTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(UploadedtimetablesTableSeeder::class);
    }
}
