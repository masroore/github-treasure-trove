<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

       // \DB::table('permissions')->delete();

        \DB::table('permissions')->insert([
            0 => [
                'id' => 6,
                'name' => 'view Front Desk',
                'guard_name' => 'web',
            ],
            1 => [
                'id' => 7,
                'name' => 'view Admission Enquiry',
                'guard_name' => 'web',
            ],
            2 => [
                'id' => 8,
                'name' => 'create Admission Enquiry',
                'guard_name' => 'web',
            ],
            3 => [
                'id' => 9,
                'name' => 'edit Admission Enquiry',
                'guard_name' => 'web',
            ],
            4 => [
                'id' => 10,
                'name' => 'delete Admission Enquiry',
                'guard_name' => 'web',
            ],
            5 => [
                'id' => 11,
                'name' => 'view Visitors Book',
                'guard_name' => 'web',
            ],
            6 => [
                'id' => 12,
                'name' => 'create Visitors Book',
                'guard_name' => 'web',
            ],
            7 => [
                'id' => 13,
                'name' => 'edit Visitors Book',
                'guard_name' => 'web',
            ],
            8 => [
                'id' => 14,
                'name' => 'delete Visitors Book',
                'guard_name' => 'web',
            ],
            9 => [
                'id' => 15,
                'name' => 'view Phone call log',
                'guard_name' => 'web',
            ],
            10 => [
                'id' => 16,
                'name' => 'create Phone call log',
                'guard_name' => 'web',
            ],
            11 => [
                'id' => 17,
                'name' => 'edit Phone call log',
                'guard_name' => 'web',
            ],
            12 => [
                'id' => 18,
                'name' => 'delete Phone call log',
                'guard_name' => 'web',
            ],
            13 => [
                'id' => 19,
                'name' => 'view Postal Dispatch',
                'guard_name' => 'web',
            ],
            14 => [
                'id' => 20,
                'name' => 'create Postal Dispatch',
                'guard_name' => 'web',
            ],
            15 => [
                'id' => 21,
                'name' => 'edit Postal Dispatch',
                'guard_name' => 'web',
            ],
            16 => [
                'id' => 22,
                'name' => 'delete Postal Dispatch',
                'guard_name' => 'web',
            ],
            17 => [
                'id' => 23,
                'name' => 'view Postal receive',
                'guard_name' => 'web',
            ],
            18 => [
                'id' => 24,
                'name' => 'create Postal receive',
                'guard_name' => 'web',
            ],
            19 => [
                'id' => 25,
                'name' => 'edit Postal receive',
                'guard_name' => 'web',
            ],
            20 => [
                'id' => 26,
                'name' => 'delete Postal receive',
                'guard_name' => 'web',
            ],
            21 => [
                'id' => 27,
                'name' => 'view Academics Year',
                'guard_name' => 'web',
            ],
            22 => [
                'id' => 28,
                'name' => 'view Add Academic Year',
                'guard_name' => 'web',
            ],
            23 => [
                'id' => 29,
                'name' => 'create Add Academic Year',
                'guard_name' => 'web',
            ],
            24 => [
                'id' => 30,
                'name' => 'edit Add Academic Year',
                'guard_name' => 'web',
            ],
            25 => [
                'id' => 31,
                'name' => 'delete Add Academic Year',
                'guard_name' => 'web',
            ],
            26 => [
                'id' => 32,
                'name' => 'view Academic Calendar',
                'guard_name' => 'web',
            ],
            27 => [
                'id' => 33,
                'name' => 'view Create Event',
                'guard_name' => 'web',
            ],
            28 => [
                'id' => 34,
                'name' => 'create Create Event',
                'guard_name' => 'web',
            ],
            29 => [
                'id' => 35,
                'name' => 'edit Create Event',
                'guard_name' => 'web',
            ],
            30 => [
                'id' => 36,
                'name' => 'delete Create Event',
                'guard_name' => 'web',
            ],
            31 => [
                'id' => 37,
                'name' => 'view All Event',
                'guard_name' => 'web',
            ],
            32 => [
                'id' => 38,
                'name' => 'create All Event',
                'guard_name' => 'web',
            ],
            33 => [
                'id' => 39,
                'name' => 'edit All Event',
                'guard_name' => 'web',
            ],
            34 => [
                'id' => 40,
                'name' => 'delete All Event',
                'guard_name' => 'web',
            ],
            35 => [
                'id' => 41,
                'name' => 'view Pre Admission',
                'guard_name' => 'web',
            ],
            36 => [
                'id' => 42,
                'name' => 'view Online Admissions',
                'guard_name' => 'web',
            ],
            37 => [
                'id' => 43,
                'name' => 'create Online Admissions',
                'guard_name' => 'web',
            ],
            38 => [
                'id' => 44,
                'name' => 'edit Online Admissions',
                'guard_name' => 'web',
            ],
            39 => [
                'id' => 45,
                'name' => 'delete Online Admissions',
                'guard_name' => 'web',
            ],
            40 => [
                'id' => 46,
                'name' => 'view Level 100',
                'guard_name' => 'web',
            ],
            41 => [
                'id' => 47,
                'name' => 'create Level 100',
                'guard_name' => 'web',
            ],
            42 => [
                'id' => 48,
                'name' => 'edit Level 100',
                'guard_name' => 'web',
            ],
            43 => [
                'id' => 49,
                'name' => 'delete Level 100',
                'guard_name' => 'web',
            ],
            44 => [
                'id' => 50,
                'name' => 'view Level 200',
                'guard_name' => 'web',
            ],
            45 => [
                'id' => 51,
                'name' => 'create Level 200',
                'guard_name' => 'web',
            ],
            46 => [
                'id' => 52,
                'name' => 'edit Level 200',
                'guard_name' => 'web',
            ],
            47 => [
                'id' => 53,
                'name' => 'delete Level 200',
                'guard_name' => 'web',
            ],
            48 => [
                'id' => 54,
                'name' => 'view Level 300',
                'guard_name' => 'web',
            ],
            49 => [
                'id' => 55,
                'name' => 'create Level 300',
                'guard_name' => 'web',
            ],
            50 => [
                'id' => 56,
                'name' => 'edit Level 300',
                'guard_name' => 'web',
            ],
            51 => [
                'id' => 57,
                'name' => 'delete Level 300',
                'guard_name' => 'web',
            ],
            52 => [
                'id' => 65,
                'name' => 'view Confirm Admission',
                'guard_name' => 'web',
            ],
            53 => [
                'id' => 66,
                'name' => 'view Confirm Admissions',
                'guard_name' => 'web',
            ],
            54 => [
                'id' => 67,
                'name' => 'create Confirm Admissions',
                'guard_name' => 'web',
            ],
            55 => [
                'id' => 68,
                'name' => 'edit Confirm Admissions',
                'guard_name' => 'web',
            ],
            56 => [
                'id' => 69,
                'name' => 'delete Confirm Admissions',
                'guard_name' => 'web',
            ],
            57 => [
                'id' => 70,
                'name' => 'view All Confirmed Admission',
                'guard_name' => 'web',
            ],
            58 => [
                'id' => 71,
                'name' => 'create All Confirmed Admission',
                'guard_name' => 'web',
            ],
            59 => [
                'id' => 72,
                'name' => 'edit All Confirmed Admission',
                'guard_name' => 'web',
            ],
            60 => [
                'id' => 73,
                'name' => 'delete All Confirmed Admission',
                'guard_name' => 'web',
            ],
            61 => [
                'id' => 74,
                'name' => 'view Student Portal',
                'guard_name' => 'web',
            ],
            62 => [
                'id' => 75,
                'name' => 'view Course Registration',
                'guard_name' => 'web',
            ],
            63 => [
                'id' => 76,
                'name' => 'create Course Registration',
                'guard_name' => 'web',
            ],
            64 => [
                'id' => 77,
                'name' => 'edit Course Registration',
                'guard_name' => 'web',
            ],
            65 => [
                'id' => 78,
                'name' => 'delete Course Registration',
                'guard_name' => 'web',
            ],
            66 => [
                'id' => 79,
                'name' => 'view My results',
                'guard_name' => 'web',
            ],
            67 => [
                'id' => 80,
                'name' => 'create My results',
                'guard_name' => 'web',
            ],
            68 => [
                'id' => 81,
                'name' => 'edit My results',
                'guard_name' => 'web',
            ],
            69 => [
                'id' => 82,
                'name' => 'delete My results',
                'guard_name' => 'web',
            ],
            70 => [
                'id' => 83,
                'name' => 'view Timetable',
                'guard_name' => 'web',
            ],
            71 => [
                'id' => 84,
                'name' => 'create Timetable',
                'guard_name' => 'web',
            ],
            72 => [
                'id' => 85,
                'name' => 'edit Timetable',
                'guard_name' => 'web',
            ],
            73 => [
                'id' => 86,
                'name' => 'delete Timetable',
                'guard_name' => 'web',
            ],
            74 => [
                'id' => 87,
                'name' => 'view All Support Tickets',
                'guard_name' => 'web',
            ],
            75 => [
                'id' => 88,
                'name' => 'create All Support Tickets',
                'guard_name' => 'web',
            ],
            76 => [
                'id' => 89,
                'name' => 'edit All Support Tickets',
                'guard_name' => 'web',
            ],
            77 => [
                'id' => 90,
                'name' => 'delete All Support Tickets',
                'guard_name' => 'web',
            ],
            78 => [
                'id' => 91,
                'name' => 'view Create New Ticket',
                'guard_name' => 'web',
            ],
            79 => [
                'id' => 92,
                'name' => 'create Create New Ticket',
                'guard_name' => 'web',
            ],
            80 => [
                'id' => 93,
                'name' => 'edit Create New Ticket',
                'guard_name' => 'web',
            ],
            81 => [
                'id' => 94,
                'name' => 'delete Create New Ticket',
                'guard_name' => 'web',
            ],
            82 => [
                'id' => 95,
                'name' => 'view Online Polls',
                'guard_name' => 'web',
            ],
            83 => [
                'id' => 96,
                'name' => 'create Online Polls',
                'guard_name' => 'web',
            ],
            84 => [
                'id' => 97,
                'name' => 'edit Online Polls',
                'guard_name' => 'web',
            ],
            85 => [
                'id' => 98,
                'name' => 'delete Online Polls',
                'guard_name' => 'web',
            ],
            86 => [
                'id' => 99,
                'name' => 'view View Polls Results',
                'guard_name' => 'web',
            ],
            87 => [
                'id' => 100,
                'name' => 'create View Polls Results',
                'guard_name' => 'web',
            ],
            88 => [
                'id' => 101,
                'name' => 'edit View Polls Results',
                'guard_name' => 'web',
            ],
            89 => [
                'id' => 102,
                'name' => 'delete View Polls Results',
                'guard_name' => 'web',
            ],
            90 => [
                'id' => 103,
                'name' => 'view Lecturer',
                'guard_name' => 'web',
            ],
            91 => [
                'id' => 104,
                'name' => 'view Profile',
                'guard_name' => 'web',
            ],
            92 => [
                'id' => 105,
                'name' => 'create Profile',
                'guard_name' => 'web',
            ],
            93 => [
                'id' => 106,
                'name' => 'edit Profile',
                'guard_name' => 'web',
            ],
            94 => [
                'id' => 107,
                'name' => 'delete Profile',
                'guard_name' => 'web',
            ],
            95 => [
                'id' => 108,
                'name' => 'view Enter results',
                'guard_name' => 'web',
            ],
            96 => [
                'id' => 109,
                'name' => 'create Enter results',
                'guard_name' => 'web',
            ],
            97 => [
                'id' => 110,
                'name' => 'edit Enter results',
                'guard_name' => 'web',
            ],
            98 => [
                'id' => 111,
                'name' => 'delete Enter results',
                'guard_name' => 'web',
            ],
            99 => [
                'id' => 112,
                'name' => 'view Request Leave',
                'guard_name' => 'web',
            ],
            100 => [
                'id' => 113,
                'name' => 'create Request Leave',
                'guard_name' => 'web',
            ],
            101 => [
                'id' => 114,
                'name' => 'edit Request Leave',
                'guard_name' => 'web',
            ],
            102 => [
                'id' => 115,
                'name' => 'delete Request Leave',
                'guard_name' => 'web',
            ],
            103 => [
                'id' => 116,
                'name' => 'view LMS',
                'guard_name' => 'web',
            ],
            104 => [
                'id' => 117,
                'name' => 'create LMS',
                'guard_name' => 'web',
            ],
            105 => [
                'id' => 118,
                'name' => 'edit LMS',
                'guard_name' => 'web',
            ],
            106 => [
                'id' => 119,
                'name' => 'delete LMS',
                'guard_name' => 'web',
            ],
            107 => [
                'id' => 120,
                'name' => 'view Admission Doc',
                'guard_name' => 'web',
            ],
            108 => [
                'id' => 121,
                'name' => 'create Admission Doc',
                'guard_name' => 'web',
            ],
            109 => [
                'id' => 122,
                'name' => 'edit Admission Doc',
                'guard_name' => 'web',
            ],
            110 => [
                'id' => 123,
                'name' => 'delete Admission Doc',
                'guard_name' => 'web',
            ],
            111 => [
                'id' => 124,
                'name' => 'view Revert Admission',
                'guard_name' => 'web',
            ],
            112 => [
                'id' => 125,
                'name' => 'create Revert Admission',
                'guard_name' => 'web',
            ],
            113 => [
                'id' => 126,
                'name' => 'edit Revert Admission',
                'guard_name' => 'web',
            ],
            114 => [
                'id' => 127,
                'name' => 'delete Revert Admission',
                'guard_name' => 'web',
            ],
            115 => [
                'id' => 128,
                'name' => 'view Add Student',
                'guard_name' => 'web',
            ],
            116 => [
                'id' => 129,
                'name' => 'create Add Student',
                'guard_name' => 'web',
            ],
            117 => [
                'id' => 130,
                'name' => 'edit Add Student',
                'guard_name' => 'web',
            ],
            118 => [
                'id' => 131,
                'name' => 'delete Add Student',
                'guard_name' => 'web',
            ],
            119 => [
                'id' => 132,
                'name' => 'view Accounts',
                'guard_name' => 'web',
            ],
            120 => [
                'id' => 133,
                'name' => 'view Mandatory Fees',
                'guard_name' => 'web',
            ],
            121 => [
                'id' => 134,
                'name' => 'create Mandatory Fees',
                'guard_name' => 'web',
            ],
            122 => [
                'id' => 135,
                'name' => 'edit Mandatory Fees',
                'guard_name' => 'web',
            ],
            123 => [
                'id' => 136,
                'name' => 'delete Mandatory Fees',
                'guard_name' => 'web',
            ],
            124 => [
                'id' => 137,
                'name' => 'view Other Fees',
                'guard_name' => 'web',
            ],
            125 => [
                'id' => 138,
                'name' => 'create Other Fees',
                'guard_name' => 'web',
            ],
            126 => [
                'id' => 139,
                'name' => 'edit Other Fees',
                'guard_name' => 'web',
            ],
            127 => [
                'id' => 140,
                'name' => 'delete Other Fees',
                'guard_name' => 'web',
            ],
            128 => [
                'id' => 141,
                'name' => 'view Fee Mater',
                'guard_name' => 'web',
            ],
            129 => [
                'id' => 142,
                'name' => 'create Fee Mater',
                'guard_name' => 'web',
            ],
            130 => [
                'id' => 143,
                'name' => 'edit Fee Mater',
                'guard_name' => 'web',
            ],
            131 => [
                'id' => 144,
                'name' => 'delete Fee Mater',
                'guard_name' => 'web',
            ],
            132 => [
                'id' => 145,
                'name' => 'view View Fees',
                'guard_name' => 'web',
            ],
            133 => [
                'id' => 146,
                'name' => 'create View Fees',
                'guard_name' => 'web',
            ],
            134 => [
                'id' => 147,
                'name' => 'edit View Fees',
                'guard_name' => 'web',
            ],
            135 => [
                'id' => 148,
                'name' => 'delete View Fees',
                'guard_name' => 'web',
            ],
            136 => [
                'id' => 149,
                'name' => 'view Dispatch Fees',
                'guard_name' => 'web',
            ],
            137 => [
                'id' => 150,
                'name' => 'create Dispatch Fees',
                'guard_name' => 'web',
            ],
            138 => [
                'id' => 151,
                'name' => 'edit Dispatch Fees',
                'guard_name' => 'web',
            ],
            139 => [
                'id' => 152,
                'name' => 'delete Dispatch Fees',
                'guard_name' => 'web',
            ],
            140 => [
                'id' => 153,
                'name' => 'view Transactions',
                'guard_name' => 'web',
            ],
            141 => [
                'id' => 154,
                'name' => 'create Transactions',
                'guard_name' => 'web',
            ],
            142 => [
                'id' => 155,
                'name' => 'edit Transactions',
                'guard_name' => 'web',
            ],
            143 => [
                'id' => 156,
                'name' => 'delete Transactions',
                'guard_name' => 'web',
            ],
            144 => [
                'id' => 157,
                'name' => 'view Student',
                'guard_name' => 'web',
            ],
            145 => [
                'id' => 158,
                'name' => 'create Student',
                'guard_name' => 'web',
            ],
            146 => [
                'id' => 159,
                'name' => 'edit Student',
                'guard_name' => 'web',
            ],
            147 => [
                'id' => 160,
                'name' => 'delete Student',
                'guard_name' => 'web',
            ],
            148 => [
                'id' => 161,
                'name' => 'view Human Resource',
                'guard_name' => 'web',
            ],
            149 => [
                'id' => 162,
                'name' => 'view Add Staff',
                'guard_name' => 'web',
            ],
            150 => [
                'id' => 163,
                'name' => 'create Add Staff',
                'guard_name' => 'web',
            ],
            151 => [
                'id' => 164,
                'name' => 'edit Add Staff',
                'guard_name' => 'web',
            ],
            152 => [
                'id' => 165,
                'name' => 'delete Add Staff',
                'guard_name' => 'web',
            ],
            153 => [
                'id' => 166,
                'name' => 'view All Staff',
                'guard_name' => 'web',
            ],
            154 => [
                'id' => 167,
                'name' => 'create All Staff',
                'guard_name' => 'web',
            ],
            155 => [
                'id' => 168,
                'name' => 'edit All Staff',
                'guard_name' => 'web',
            ],
            156 => [
                'id' => 169,
                'name' => 'delete All Staff',
                'guard_name' => 'web',
            ],
            157 => [
                'id' => 170,
                'name' => 'view Staff Attendance',
                'guard_name' => 'web',
            ],
            158 => [
                'id' => 171,
                'name' => 'create Staff Attendance',
                'guard_name' => 'web',
            ],
            159 => [
                'id' => 172,
                'name' => 'edit Staff Attendance',
                'guard_name' => 'web',
            ],
            160 => [
                'id' => 173,
                'name' => 'delete Staff Attendance',
                'guard_name' => 'web',
            ],
            161 => [
                'id' => 174,
                'name' => 'view Payroll',
                'guard_name' => 'web',
            ],
            162 => [
                'id' => 175,
                'name' => 'create Payroll',
                'guard_name' => 'web',
            ],
            163 => [
                'id' => 176,
                'name' => 'edit Payroll',
                'guard_name' => 'web',
            ],
            164 => [
                'id' => 177,
                'name' => 'delete Payroll',
                'guard_name' => 'web',
            ],
            165 => [
                'id' => 178,
                'name' => 'view Approved Leave',
                'guard_name' => 'web',
            ],
            166 => [
                'id' => 179,
                'name' => 'create Approved Leave',
                'guard_name' => 'web',
            ],
            167 => [
                'id' => 180,
                'name' => 'edit Approved Leave',
                'guard_name' => 'web',
            ],
            168 => [
                'id' => 181,
                'name' => 'delete Approved Leave',
                'guard_name' => 'web',
            ],
            169 => [
                'id' => 182,
                'name' => 'view Lecturer Rating',
                'guard_name' => 'web',
            ],
            170 => [
                'id' => 183,
                'name' => 'create Lecturer Rating',
                'guard_name' => 'web',
            ],
            171 => [
                'id' => 184,
                'name' => 'edit Lecturer Rating',
                'guard_name' => 'web',
            ],
            172 => [
                'id' => 185,
                'name' => 'delete Lecturer Rating',
                'guard_name' => 'web',
            ],
            173 => [
                'id' => 186,
                'name' => 'view Disable Staff',
                'guard_name' => 'web',
            ],
            174 => [
                'id' => 187,
                'name' => 'create Disable Staff',
                'guard_name' => 'web',
            ],
            175 => [
                'id' => 188,
                'name' => 'edit Disable Staff',
                'guard_name' => 'web',
            ],
            176 => [
                'id' => 189,
                'name' => 'delete Disable Staff',
                'guard_name' => 'web',
            ],
            177 => [
                'id' => 190,
                'name' => 'view Add Hall',
                'guard_name' => 'web',
            ],
            178 => [
                'id' => 191,
                'name' => 'create Add Hall',
                'guard_name' => 'web',
            ],
            179 => [
                'id' => 192,
                'name' => 'edit Add Hall',
                'guard_name' => 'web',
            ],
            180 => [
                'id' => 193,
                'name' => 'delete Add Hall',
                'guard_name' => 'web',
            ],
            181 => [
                'id' => 194,
                'name' => 'view Add Timetable',
                'guard_name' => 'web',
            ],
            182 => [
                'id' => 195,
                'name' => 'create Add Timetable',
                'guard_name' => 'web',
            ],
            183 => [
                'id' => 196,
                'name' => 'edit Add Timetable',
                'guard_name' => 'web',
            ],
            184 => [
                'id' => 197,
                'name' => 'delete Add Timetable',
                'guard_name' => 'web',
            ],
            185 => [
                'id' => 198,
                'name' => 'view Generate Timetable',
                'guard_name' => 'web',
            ],
            186 => [
                'id' => 199,
                'name' => 'create Generate Timetable',
                'guard_name' => 'web',
            ],
            187 => [
                'id' => 200,
                'name' => 'edit Generate Timetable',
                'guard_name' => 'web',
            ],
            188 => [
                'id' => 201,
                'name' => 'delete Generate Timetable',
                'guard_name' => 'web',
            ],
            189 => [
                'id' => 202,
                'name' => 'view Upload Timetable',
                'guard_name' => 'web',
            ],
            190 => [
                'id' => 203,
                'name' => 'create Upload Timetable',
                'guard_name' => 'web',
            ],
            191 => [
                'id' => 204,
                'name' => 'edit Upload Timetable',
                'guard_name' => 'web',
            ],
            192 => [
                'id' => 205,
                'name' => 'delete Upload Timetable',
                'guard_name' => 'web',
            ],
            193 => [
                'id' => 206,
                'name' => 'view Student Grouping',
                'guard_name' => 'web',
            ],
            194 => [
                'id' => 207,
                'name' => 'view Group Student',
                'guard_name' => 'web',
            ],
            195 => [
                'id' => 208,
                'name' => 'create Group Student',
                'guard_name' => 'web',
            ],
            196 => [
                'id' => 209,
                'name' => 'edit Group Student',
                'guard_name' => 'web',
            ],
            197 => [
                'id' => 210,
                'name' => 'delete Group Student',
                'guard_name' => 'web',
            ],
            198 => [
                'id' => 211,
                'name' => 'view View Grouping',
                'guard_name' => 'web',
            ],
            199 => [
                'id' => 212,
                'name' => 'create View Grouping',
                'guard_name' => 'web',
            ],
            200 => [
                'id' => 213,
                'name' => 'edit View Grouping',
                'guard_name' => 'web',
            ],
            201 => [
                'id' => 214,
                'name' => 'delete View Grouping',
                'guard_name' => 'web',
            ],
            202 => [
                'id' => 215,
                'name' => 'view Results Management',
                'guard_name' => 'web',
            ],
            203 => [
                'id' => 216,
                'name' => 'view Release Results',
                'guard_name' => 'web',
            ],
            204 => [
                'id' => 217,
                'name' => 'create Release Results',
                'guard_name' => 'web',
            ],
            205 => [
                'id' => 218,
                'name' => 'edit Release Results',
                'guard_name' => 'web',
            ],
            206 => [
                'id' => 219,
                'name' => 'delete Release Results',
                'guard_name' => 'web',
            ],
            207 => [
                'id' => 220,
                'name' => 'view Cancel Results Session',
                'guard_name' => 'web',
            ],
            208 => [
                'id' => 221,
                'name' => 'create Cancel Results Session',
                'guard_name' => 'web',
            ],
            209 => [
                'id' => 222,
                'name' => 'edit Cancel Results Session',
                'guard_name' => 'web',
            ],
            210 => [
                'id' => 223,
                'name' => 'delete Cancel Results Session',
                'guard_name' => 'web',
            ],
            211 => [
                'id' => 224,
                'name' => 'view Cancel Results Student',
                'guard_name' => 'web',
            ],
            212 => [
                'id' => 225,
                'name' => 'create Cancel Results Student',
                'guard_name' => 'web',
            ],
            213 => [
                'id' => 226,
                'name' => 'edit Cancel Results Student',
                'guard_name' => 'web',
            ],
            214 => [
                'id' => 227,
                'name' => 'delete Cancel Results Student',
                'guard_name' => 'web',
            ],
            215 => [
                'id' => 228,
                'name' => 'view Polls Management',
                'guard_name' => 'web',
            ],
            216 => [
                'id' => 229,
                'name' => 'view Add Polls',
                'guard_name' => 'web',
            ],
            217 => [
                'id' => 230,
                'name' => 'create Add Polls',
                'guard_name' => 'web',
            ],
            218 => [
                'id' => 231,
                'name' => 'edit Add Polls',
                'guard_name' => 'web',
            ],
            219 => [
                'id' => 232,
                'name' => 'delete Add Polls',
                'guard_name' => 'web',
            ],
            220 => [
                'id' => 233,
                'name' => 'view Manage Polls',
                'guard_name' => 'web',
            ],
            221 => [
                'id' => 234,
                'name' => 'create Manage Polls',
                'guard_name' => 'web',
            ],
            222 => [
                'id' => 235,
                'name' => 'edit Manage Polls',
                'guard_name' => 'web',
            ],
            223 => [
                'id' => 236,
                'name' => 'delete Manage Polls',
                'guard_name' => 'web',
            ],
            224 => [
                'id' => 237,
                'name' => 'view Manage Candidate',
                'guard_name' => 'web',
            ],
            225 => [
                'id' => 238,
                'name' => 'create Manage Candidate',
                'guard_name' => 'web',
            ],
            226 => [
                'id' => 239,
                'name' => 'edit Manage Candidate',
                'guard_name' => 'web',
            ],
            227 => [
                'id' => 240,
                'name' => 'delete Manage Candidate',
                'guard_name' => 'web',
            ],
            228 => [
                'id' => 241,
                'name' => 'view Release Polls Results',
                'guard_name' => 'web',
            ],
            229 => [
                'id' => 242,
                'name' => 'create Release Polls Results',
                'guard_name' => 'web',
            ],
            230 => [
                'id' => 243,
                'name' => 'edit Release Polls Results',
                'guard_name' => 'web',
            ],
            231 => [
                'id' => 244,
                'name' => 'delete Release Polls Results',
                'guard_name' => 'web',
            ],
            232 => [
                'id' => 245,
                'name' => 'view Polls Results',
                'guard_name' => 'web',
            ],
            233 => [
                'id' => 246,
                'name' => 'create Polls Results',
                'guard_name' => 'web',
            ],
            234 => [
                'id' => 247,
                'name' => 'edit Polls Results',
                'guard_name' => 'web',
            ],
            235 => [
                'id' => 248,
                'name' => 'delete Polls Results',
                'guard_name' => 'web',
            ],
            236 => [
                'id' => 249,
                'name' => 'view Support Tickets',
                'guard_name' => 'web',
            ],
            237 => [
                'id' => 250,
                'name' => 'view Communicate',
                'guard_name' => 'web',
            ],
            238 => [
                'id' => 251,
                'name' => 'view Send Nail',
                'guard_name' => 'web',
            ],
            239 => [
                'id' => 252,
                'name' => 'create Send Nail',
                'guard_name' => 'web',
            ],
            240 => [
                'id' => 253,
                'name' => 'edit Send Nail',
                'guard_name' => 'web',
            ],
            241 => [
                'id' => 254,
                'name' => 'delete Send Nail',
                'guard_name' => 'web',
            ],
            242 => [
                'id' => 255,
                'name' => 'view Send Sms',
                'guard_name' => 'web',
            ],
            243 => [
                'id' => 256,
                'name' => 'create Send Sms',
                'guard_name' => 'web',
            ],
            244 => [
                'id' => 257,
                'name' => 'edit Send Sms',
                'guard_name' => 'web',
            ],
            245 => [
                'id' => 258,
                'name' => 'delete Send Sms',
                'guard_name' => 'web',
            ],
            246 => [
                'id' => 259,
                'name' => 'view Online Meetings',
                'guard_name' => 'web',
            ],
            247 => [
                'id' => 260,
                'name' => 'view Schedule Meeting',
                'guard_name' => 'web',
            ],
            248 => [
                'id' => 261,
                'name' => 'create Schedule Meeting',
                'guard_name' => 'web',
            ],
            249 => [
                'id' => 262,
                'name' => 'edit Schedule Meeting',
                'guard_name' => 'web',
            ],
            250 => [
                'id' => 263,
                'name' => 'delete Schedule Meeting',
                'guard_name' => 'web',
            ],
            251 => [
                'id' => 264,
                'name' => 'view Staff Meeting',
                'guard_name' => 'web',
            ],
            252 => [
                'id' => 265,
                'name' => 'create Staff Meeting',
                'guard_name' => 'web',
            ],
            253 => [
                'id' => 266,
                'name' => 'edit Staff Meeting',
                'guard_name' => 'web',
            ],
            254 => [
                'id' => 267,
                'name' => 'delete Staff Meeting',
                'guard_name' => 'web',
            ],
            255 => [
                'id' => 268,
                'name' => 'view User Management',
                'guard_name' => 'web',
            ],
            256 => [
                'id' => 269,
                'name' => 'view Add Role',
                'guard_name' => 'web',
            ],
            257 => [
                'id' => 270,
                'name' => 'create Add Role',
                'guard_name' => 'web',
            ],
            258 => [
                'id' => 271,
                'name' => 'edit Add Role',
                'guard_name' => 'web',
            ],
            259 => [
                'id' => 272,
                'name' => 'delete Add Role',
                'guard_name' => 'web',
            ],
            260 => [
                'id' => 273,
                'name' => 'view Force Logout',
                'guard_name' => 'web',
            ],
            261 => [
                'id' => 274,
                'name' => 'create Force Logout',
                'guard_name' => 'web',
            ],
            262 => [
                'id' => 275,
                'name' => 'edit Force Logout',
                'guard_name' => 'web',
            ],
            263 => [
                'id' => 276,
                'name' => 'delete Force Logout',
                'guard_name' => 'web',
            ],
            264 => [
                'id' => 281,
                'name' => 'view Graduated Students',
                'guard_name' => 'web',
            ],
            265 => [
                'id' => 282,
                'name' => 'create Graduated Students',
                'guard_name' => 'web',
            ],
            266 => [
                'id' => 283,
                'name' => 'edit Graduated Students',
                'guard_name' => 'web',
            ],
            267 => [
                'id' => 284,
                'name' => 'delete Graduated Students',
                'guard_name' => 'web',
            ],
            268 => [
                'id' => 285,
                'name' => 'view Student Punishment',
                'guard_name' => 'web',
            ],
            269 => [
                'id' => 286,
                'name' => 'view Add Fine',
                'guard_name' => 'web',
            ],
            270 => [
                'id' => 287,
                'name' => 'create Add Fine',
                'guard_name' => 'web',
            ],
            271 => [
                'id' => 288,
                'name' => 'edit Add Fine',
                'guard_name' => 'web',
            ],
            272 => [
                'id' => 289,
                'name' => 'delete Add Fine',
                'guard_name' => 'web',
            ],
            273 => [
                'id' => 290,
                'name' => 'view Fine Student',
                'guard_name' => 'web',
            ],
            274 => [
                'id' => 291,
                'name' => 'create Fine Student',
                'guard_name' => 'web',
            ],
            275 => [
                'id' => 292,
                'name' => 'edit Fine Student',
                'guard_name' => 'web',
            ],
            276 => [
                'id' => 293,
                'name' => 'delete Fine Student',
                'guard_name' => 'web',
            ],
            277 => [
                'id' => 294,
                'name' => 'view Student Promotion',
                'guard_name' => 'web',
            ],
            278 => [
                'id' => 295,
                'name' => 'view Promote Student',
                'guard_name' => 'web',
            ],
            279 => [
                'id' => 296,
                'name' => 'create Promote Student',
                'guard_name' => 'web',
            ],
            280 => [
                'id' => 297,
                'name' => 'edit Promote Student',
                'guard_name' => 'web',
            ],
            281 => [
                'id' => 298,
                'name' => 'delete Promote Student',
                'guard_name' => 'web',
            ],
            282 => [
                'id' => 299,
                'name' => 'view Graduation List',
                'guard_name' => 'web',
            ],
            283 => [
                'id' => 300,
                'name' => 'create Graduation List',
                'guard_name' => 'web',
            ],
            284 => [
                'id' => 301,
                'name' => 'edit Graduation List',
                'guard_name' => 'web',
            ],
            285 => [
                'id' => 302,
                'name' => 'delete Graduation List',
                'guard_name' => 'web',
            ],
            286 => [
                'id' => 303,
                'name' => 'view Disable Student',
                'guard_name' => 'web',
            ],
            287 => [
                'id' => 304,
                'name' => 'view Dismiss Student',
                'guard_name' => 'web',
            ],
            288 => [
                'id' => 305,
                'name' => 'create Dismiss Student',
                'guard_name' => 'web',
            ],
            289 => [
                'id' => 306,
                'name' => 'edit Dismiss Student',
                'guard_name' => 'web',
            ],
            290 => [
                'id' => 307,
                'name' => 'delete Dismiss Student',
                'guard_name' => 'web',
            ],
            291 => [
                'id' => 308,
                'name' => 'view Rusticate Student',
                'guard_name' => 'web',
            ],
            292 => [
                'id' => 309,
                'name' => 'create Rusticate Student',
                'guard_name' => 'web',
            ],
            293 => [
                'id' => 310,
                'name' => 'edit Rusticate Student',
                'guard_name' => 'web',
            ],
            294 => [
                'id' => 311,
                'name' => 'delete Rusticate Student',
                'guard_name' => 'web',
            ],
            295 => [
                'id' => 312,
                'name' => 'view Defer Student',
                'guard_name' => 'web',
            ],
            296 => [
                'id' => 313,
                'name' => 'create Defer Student',
                'guard_name' => 'web',
            ],
            297 => [
                'id' => 314,
                'name' => 'edit Defer Student',
                'guard_name' => 'web',
            ],
            298 => [
                'id' => 315,
                'name' => 'delete Defer Student',
                'guard_name' => 'web',
            ],
            299 => [
                'id' => 316,
                'name' => 'view All studentds',
                'guard_name' => 'web',
            ],
            300 => [
                'id' => 317,
                'name' => 'view All Students',
                'guard_name' => 'web',
            ],
            301 => [
                'id' => 318,
                'name' => 'create All Students',
                'guard_name' => 'web',
            ],
            302 => [
                'id' => 319,
                'name' => 'edit All Students',
                'guard_name' => 'web',
            ],
            303 => [
                'id' => 320,
                'name' => 'delete All Students',
                'guard_name' => 'web',
            ],
            304 => [
                'id' => 321,
                'name' => 'view Student Info Level 100',
                'guard_name' => 'web',
            ],
            305 => [
                'id' => 322,
                'name' => 'create Student Info Level 100',
                'guard_name' => 'web',
            ],
            306 => [
                'id' => 323,
                'name' => 'edit Student Info Level 100',
                'guard_name' => 'web',
            ],
            307 => [
                'id' => 324,
                'name' => 'delete Student Info Level 100',
                'guard_name' => 'web',
            ],
            308 => [
                'id' => 325,
                'name' => 'view Student Info Level 200',
                'guard_name' => 'web',
            ],
            309 => [
                'id' => 326,
                'name' => 'create Student Info Level 200',
                'guard_name' => 'web',
            ],
            310 => [
                'id' => 327,
                'name' => 'edit Student Info Level 200',
                'guard_name' => 'web',
            ],
            311 => [
                'id' => 328,
                'name' => 'delete Student Info Level 200',
                'guard_name' => 'web',
            ],
            312 => [
                'id' => 329,
                'name' => 'view Student Info Level 300',
                'guard_name' => 'web',
            ],
            313 => [
                'id' => 330,
                'name' => 'create Student Info Level 300',
                'guard_name' => 'web',
            ],
            314 => [
                'id' => 331,
                'name' => 'edit Student Info Level 300',
                'guard_name' => 'web',
            ],
            315 => [
                'id' => 332,
                'name' => 'delete Student Info Level 300',
                'guard_name' => 'web',
            ],
            316 => [
                'id' => 333,
                'name' => 'view Level 400',
                'guard_name' => 'web',
            ],
            317 => [
                'id' => 334,
                'name' => 'view Student Info Level 400',
                'guard_name' => 'web',
            ],
            318 => [
                'id' => 335,
                'name' => 'create Student Info Level 400',
                'guard_name' => 'web',
            ],
            319 => [
                'id' => 336,
                'name' => 'edit Student Info Level 400',
                'guard_name' => 'web',
            ],
            320 => [
                'id' => 337,
                'name' => 'delete Student Info Level 400',
                'guard_name' => 'web',
            ],
            321 => [
                'id' => 338,
                'name' => 'view Add Programme',
                'guard_name' => 'web',
            ],
            322 => [
                'id' => 339,
                'name' => 'create Add programme',
                'guard_name' => 'web',
            ],
            323 => [
                'id' => 340,
                'name' => 'edit Add programme',
                'guard_name' => 'web',
            ],
            324 => [
                'id' => 341,
                'name' => 'delete Add programme',
                'guard_name' => 'web',
            ],
            325 => [
                'id' => 342,
                'name' => 'view Add Faculty',
                'guard_name' => 'web',
            ],
            326 => [
                'id' => 343,
                'name' => 'create Add Faculty',
                'guard_name' => 'web',
            ],
            327 => [
                'id' => 344,
                'name' => 'edit Add Faculty',
                'guard_name' => 'web',
            ],
            328 => [
                'id' => 345,
                'name' => 'delete Add Faculty',
                'guard_name' => 'web',
            ],
            329 => [
                'id' => 346,
                'name' => 'view Add Course',
                'guard_name' => 'web',
            ],
            330 => [
                'id' => 347,
                'name' => 'view Add Course Degree Level 100',
                'guard_name' => 'web',
            ],
            331 => [
                'id' => 348,
                'name' => 'create Add Course Degree Level 100',
                'guard_name' => 'web',
            ],
            332 => [
                'id' => 349,
                'name' => 'edit Add Course Degree Level 100',
                'guard_name' => 'web',
            ],
            333 => [
                'id' => 350,
                'name' => 'delete Add Course Degree Level 100',
                'guard_name' => 'web',
            ],
            334 => [
                'id' => 351,
                'name' => 'view Add Course Degree Level 200',
                'guard_name' => 'web',
            ],
            335 => [
                'id' => 352,
                'name' => 'create Add Course Degree Level 200',
                'guard_name' => 'web',
            ],
            336 => [
                'id' => 353,
                'name' => 'edit Add Course Degree Level 200',
                'guard_name' => 'web',
            ],
            337 => [
                'id' => 354,
                'name' => 'delete Add Course Degree Level 200',
                'guard_name' => 'web',
            ],
            338 => [
                'id' => 355,
                'name' => 'view Add Course Degree Level 300',
                'guard_name' => 'web',
            ],
            339 => [
                'id' => 356,
                'name' => 'create Add Course Degree Level 300',
                'guard_name' => 'web',
            ],
            340 => [
                'id' => 357,
                'name' => 'edit Add Course Degree Level 300',
                'guard_name' => 'web',
            ],
            341 => [
                'id' => 358,
                'name' => 'delete Add Course Degree Level 300',
                'guard_name' => 'web',
            ],
            342 => [
                'id' => 359,
                'name' => 'view Add Course Degree Level 400',
                'guard_name' => 'web',
            ],
            343 => [
                'id' => 360,
                'name' => 'create Add Course Degree Level 400',
                'guard_name' => 'web',
            ],
            344 => [
                'id' => 361,
                'name' => 'edit Add Course Degree Level 400',
                'guard_name' => 'web',
            ],
            345 => [
                'id' => 362,
                'name' => 'delete Add Course Degree Level 400',
                'guard_name' => 'web',
            ],
            346 => [
                'id' => 363,
                'name' => 'view Add Course Diploma Level 100',
                'guard_name' => 'web',
            ],
            347 => [
                'id' => 364,
                'name' => 'create Add Course Diploma Level 100',
                'guard_name' => 'web',
            ],
            348 => [
                'id' => 365,
                'name' => 'edit Add Course Diploma Level 100',
                'guard_name' => 'web',
            ],
            349 => [
                'id' => 366,
                'name' => 'delete Add Course Diploma Level 100',
                'guard_name' => 'web',
            ],
            350 => [
                'id' => 367,
                'name' => 'view Add Course Diploma Level 200',
                'guard_name' => 'web',
            ],
            351 => [
                'id' => 368,
                'name' => 'create Add Course Diploma Level 200',
                'guard_name' => 'web',
            ],
            352 => [
                'id' => 369,
                'name' => 'edit Add Course Diploma Level 200',
                'guard_name' => 'web',
            ],
            353 => [
                'id' => 370,
                'name' => 'delete Add Course Diploma Level 200',
                'guard_name' => 'web',
            ],
            354 => [
                'id' => 371,
                'name' => 'view All Degree',
                'guard_name' => 'web',
            ],
            355 => [
                'id' => 372,
                'name' => 'view All Degree Courses',
                'guard_name' => 'web',
            ],
            356 => [
                'id' => 373,
                'name' => 'create All Degree Courses',
                'guard_name' => 'web',
            ],
            357 => [
                'id' => 374,
                'name' => 'edit All Degree Courses',
                'guard_name' => 'web',
            ],
            358 => [
                'id' => 375,
                'name' => 'delete All Degree Courses',
                'guard_name' => 'web',
            ],
            359 => [
                'id' => 376,
                'name' => 'view All Diploma',
                'guard_name' => 'web',
            ],
            360 => [
                'id' => 377,
                'name' => 'view All Diploma Courses',
                'guard_name' => 'web',
            ],
            361 => [
                'id' => 378,
                'name' => 'create All Diploma Courses',
                'guard_name' => 'web',
            ],
            362 => [
                'id' => 379,
                'name' => 'edit All Diploma Courses',
                'guard_name' => 'web',
            ],
            363 => [
                'id' => 380,
                'name' => 'delete All Diploma Courses',
                'guard_name' => 'web',
            ],
            364 => [
                'id' => 381,
                'name' => 'view Programmes and Courses',
                'guard_name' => 'web',
            ],
            365 => [
                'id' => 382,
                'name' => 'view Programs and Courses',
                'guard_name' => 'web',
            ],
            366 => [
                'id' => 383,
                'name' => 'create Programs and Courses',
                'guard_name' => 'web',
            ],
            367 => [
                'id' => 384,
                'name' => 'edit Programs and Courses',
                'guard_name' => 'web',
            ],
            368 => [
                'id' => 385,
                'name' => 'delete Programs and Courses',
                'guard_name' => 'web',
            ],
        ]);
    }
}
