<?php

use Illuminate\Database\Seeder;

class StudentinfosTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

      //  \DB::table('studentinfos')->delete();

        \DB::table('studentinfos')->insert([
            0 => [
                'id' => 2,
                'user_id' => 3,
                'fullname' => 'Ahia  Ahmed',
                'gender' => 'Male',
                'dateofbirth' => '2021-11-08',
                'religion' => 'Muslem',
                'denomination' => 'Christain',
                'placeofbirth' => 'Teshie',
                'nationality' => 'Ghanaian',
                'hometown' => 'Teshie',
                'region' => 'Greater Accra',
                'disability' => 'No',
                'postcode' => '00233',
                'address' => 'P. o. box ts 367',
                'email' => 'ogua@yahoo.com',
                'phone' => '0272185090',
                'maritalstutus' => 'Single',
                'entrylevel' => 'Level 100',
                'session' => 'Morning Session',
                'programme' => 'Bachelor of Science  in Information Technology Management',
                'type' => 'Degree Programme',
                'currentlevel' => 'Level 100',
                'indexnumber' => 'GES11112',
                'gurdianname' => 'Ahmed Amartei Kudjoe',
                'relationship' => 'Mother',
                'occupation' => 'Trader',
                'mobile' => '0272185090',
                'employed' => 'No',
                'status' => '1',
                'admitted' => 'AUG,2021',
                'completion' => 'AUG,2025',
                'academic_year' => '2020-2021',
                'progcode' => 'BITM',
                'duration' => '1',
                'completstatus' => 'Graduating',
                'title' => 'Mr',
            ],
            1 => [
                'id' => 14,
                'user_id' => 20,
                'fullname' => 'Zibit Amartey Junior',
                'gender' => 'Male',
                'dateofbirth' => '2021-11-17',
                'religion' => 'Accra',
                'denomination' => 'Accra',
                'placeofbirth' => 'Accra',
                'nationality' => 'Accra',
                'hometown' => 'Accra',
                'region' => 'Accra',
                'disability' => 'No',
                'postcode' => '00233',
                'address' => 'P. o. box ts 367',
                'email' => 'junior@yahoo.com',
                'phone' => '+233272185090',
                'maritalstutus' => 'Single',
                'entrylevel' => 'Level 100',
                'session' => 'Morning Session',
                'programme' => 'Bachelor of Science in Information Technology Management',
                'type' => 'Degree Programme',
                'currentlevel' => 'Level 100',
                'indexnumber' => 'GES43740',
                'gurdianname' => 'Abigai Agoa',
                'relationship' => 'Mother',
                'occupation' => 'Trader',
                'mobile' => '0208129151',
                'employed' => 'No',
                'status' => '1',
                'admitted' => 'AUG,2021',
                'completion' => 'AUG,2025',
                'academic_year' => '2020-2021',
                'progcode' => 'BITM',
                'duration' => '4',
                'completstatus' => null,
                'title' => 'Mr',
            ],
            2 => [
                'id' => 15,
                'user_id' => 21,
                'fullname' => 'Mamoud Billal Kidija',
                'gender' => 'Male',
                'dateofbirth' => '2021-12-03',
                'religion' => 'Christian',
                'denomination' => 'Christian',
                'placeofbirth' => 'Tesg=hie',
                'nationality' => 'Ghanaian',
                'hometown' => 'Accra',
                'region' => '',
                'disability' => 'No',
                'postcode' => '00233',
                'address' => 'minor stree
Suit',
                'email' => 'test@gmail.com',
                'phone' => '0272185091',
                'maritalstutus' => 'Single',
                'entrylevel' => 'Level 200',
                'session' => 'Morning Session',
                'programme' => 'Bachelor of Science in Information Technology Management ',
                'type' => ' Degree Programme',
                'currentlevel' => 'Level 200',
                'indexnumber' => 'GES26801',
                'gurdianname' => 'Akua Mason',
                'relationship' => 'MOTHER',
                'occupation' => 'STUDENT',
                'mobile' => '0272185091',
                'employed' => 'Yes',
                'status' => '1',
                'admitted' => 'AUG,2021',
                'completion' => 'AUG2024',
                'academic_year' => '2020-2021',
                'progcode' => ' BITM ',
                'duration' => '4',
                'completstatus' => null,
                'title' => 'Mr',
            ],
            3 => [
                'id' => 16,
                'user_id' => 22,
                'fullname' => 'Toure Ogua',
                'gender' => 'Male',
                'dateofbirth' => '2021-12-02',
                'religion' => 'Moslem',
                'denomination' => 'Christian',
                'placeofbirth' => 'Teshie',
                'nationality' => 'Ghanaian',
                'hometown' => 'Accra',
                'region' => '',
                'disability' => 'No',
                'postcode' => '00233',
                'address' => 'P. o. box ts 367',
                'email' => 'ogua@ogua.com',
                'phone' => '0272185091',
                'maritalstutus' => 'Single',
                'entrylevel' => 'Level 200',
                'session' => 'Morning Session',
                'programme' => 'Bachelor of Arts in Public Relations Management ',
                'type' => ' Degree Programme',
                'currentlevel' => 'Level 200',
                'indexnumber' => 'GES79152',
                'gurdianname' => 'AHMED',
                'relationship' => 'MOTHER',
                'occupation' => 'STUDENT',
                'mobile' => '+233272185090',
                'employed' => 'Yes',
                'status' => '1',
                'admitted' => 'AUG,2021',
                'completion' => 'AUG2024',
                'academic_year' => '2020-2021',
                'progcode' => ' BAPR ',
                'duration' => ' 4 ',
                'completstatus' => null,
                'title' => 'Mr',
            ],
            4 => [
                'id' => 17,
                'user_id' => 23,
                'fullname' => 'Abigai Agoe Adjie',
                'gender' => 'Female',
                'dateofbirth' => '2021-12-09',
                'religion' => 'Moslem',
                'denomination' => 'Christian',
                'placeofbirth' => 'Tesg=hie',
                'nationality' => 'Ghanaian',
                'hometown' => 'Accra',
                'region' => '',
                'disability' => 'Disabled',
                'postcode' => '00233',
                'address' => 'P. o. box ts 367',
                'email' => 'abi@gmail.com',
                'phone' => '0272185091',
                'maritalstutus' => 'Married',
                'entrylevel' => 'Level 300',
                'session' => 'Morning Session',
                'programme' => 'Diploma in Accounting ',
                'type' => ' Diploma Programme',
                'currentlevel' => 'Level 300',
                'indexnumber' => 'GES54920',
                'gurdianname' => 'Ahmed Ahia',
                'relationship' => 'MOTHER',
                'occupation' => 'STUDENT',
                'mobile' => '0272185090',
                'employed' => 'Yes',
                'status' => '1',
                'admitted' => 'AUG,2021',
                'completion' => 'AUG2024',
                'academic_year' => '2020-2021',
                'progcode' => ' DIAA ',
                'duration' => ' 3 ',
                'completstatus' => null,
                'title' => 'Mrs',
            ],
        ]);
    }
}
