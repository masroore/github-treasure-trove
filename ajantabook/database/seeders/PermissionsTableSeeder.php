<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();

        DB::table('permissions')->insert([
            0 => [
                'id' => 1,
                'name' => 'order.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:28:29',
                'updated_at' => '2021-05-27 11:28:29',
            ],
            1 => [
                'id' => 2,
                'name' => 'order.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:28:58',
                'updated_at' => '2021-05-27 11:28:58',
            ],
            2 => [
                'id' => 3,
                'name' => 'order.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:06',
                'updated_at' => '2021-05-27 11:29:06',
            ],
            3 => [
                'id' => 4,
                'name' => 'order.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:13',
                'updated_at' => '2021-05-27 11:29:13',
            ],
            4 => [
                'id' => 5,
                'name' => 'login.can',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:29:24',
                'updated_at' => '2021-05-27 11:29:24',
            ],
            5 => [
                'id' => 6,
                'name' => 'roles.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:26',
                'updated_at' => '2021-05-27 11:30:26',
            ],
            6 => [
                'id' => 7,
                'name' => 'roles.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:32',
                'updated_at' => '2021-05-27 11:30:32',
            ],
            7 => [
                'id' => 8,
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:36',
                'updated_at' => '2021-05-27 11:30:36',
            ],
            8 => [
                'id' => 9,
                'name' => 'roles.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 11:30:40',
                'updated_at' => '2021-05-27 11:30:40',
            ],
            9 => [
                'id' => 10,
                'name' => 'users.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:02:40',
                'updated_at' => '2021-05-27 13:02:40',
            ],
            10 => [
                'id' => 11,
                'name' => 'users.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:02:45',
                'updated_at' => '2021-05-27 13:02:45',
            ],
            11 => [
                'id' => 12,
                'name' => 'users.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:03:08',
                'updated_at' => '2021-05-27 13:03:08',
            ],
            12 => [
                'id' => 13,
                'name' => 'users.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 13:03:11',
                'updated_at' => '2021-05-27 13:03:11',
            ],
            13 => [
                'id' => 14,
                'name' => 'dashboard.states',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:16:02',
                'updated_at' => '2021-05-28 14:16:02',
            ],
            14 => [
                'id' => 15,
                'name' => 'menu.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:07',
                'updated_at' => '2021-05-28 14:19:07',
            ],
            15 => [
                'id' => 16,
                'name' => 'menu.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:12',
                'updated_at' => '2021-05-28 14:19:12',
            ],
            16 => [
                'id' => 17,
                'name' => 'menu.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:19:17',
                'updated_at' => '2021-05-28 14:19:17',
            ],
            17 => [
                'id' => 18,
                'name' => 'menu.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:20:08',
                'updated_at' => '2021-05-28 14:20:08',
            ],
            18 => [
                'id' => 19,
                'name' => 'stores.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:38:57',
                'updated_at' => '2021-05-28 14:38:57',
            ],
            19 => [
                'id' => 20,
                'name' => 'stores.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:04',
                'updated_at' => '2021-05-28 14:39:04',
            ],
            20 => [
                'id' => 21,
                'name' => 'stores.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:09',
                'updated_at' => '2021-05-28 14:39:09',
            ],
            21 => [
                'id' => 22,
                'name' => 'stores.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:12',
                'updated_at' => '2021-05-28 14:39:12',
            ],
            22 => [
                'id' => 23,
                'name' => 'stores.accept.request',
                'guard_name' => 'web',
                'created_at' => '2021-05-28 14:39:26',
                'updated_at' => '2021-05-28 14:39:26',
            ],
            23 => [
                'id' => 24,
                'name' => 'review.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:35',
                'updated_at' => '2021-05-31 06:42:35',
            ],
            24 => [
                'id' => 25,
                'name' => 'review.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:42',
                'updated_at' => '2021-05-31 06:42:42',
            ],
            25 => [
                'id' => 26,
                'name' => 'review.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:42:47',
                'updated_at' => '2021-05-31 06:42:47',
            ],
            26 => [
                'id' => 27,
                'name' => 'brand.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:20',
                'updated_at' => '2021-05-31 06:49:20',
            ],
            27 => [
                'id' => 28,
                'name' => 'brand.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:29',
                'updated_at' => '2021-05-31 06:49:29',
            ],
            28 => [
                'id' => 29,
                'name' => 'brand.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:32',
                'updated_at' => '2021-05-31 06:49:32',
            ],
            29 => [
                'id' => 30,
                'name' => 'brand.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:49:47',
                'updated_at' => '2021-05-31 06:49:47',
            ],
            30 => [
                'id' => 31,
                'name' => 'category.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:54:58',
                'updated_at' => '2021-05-31 06:54:58',
            ],
            31 => [
                'id' => 32,
                'name' => 'category.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:01',
                'updated_at' => '2021-05-31 06:55:01',
            ],
            32 => [
                'id' => 33,
                'name' => 'category.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:05',
                'updated_at' => '2021-05-31 06:55:05',
            ],
            33 => [
                'id' => 34,
                'name' => 'category.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:55:09',
                'updated_at' => '2021-05-31 06:55:09',
            ],
            34 => [
                'id' => 35,
                'name' => 'subcategory.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 06:59:57',
                'updated_at' => '2021-05-31 06:59:57',
            ],
            35 => [
                'id' => 36,
                'name' => 'subcategory.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:02',
                'updated_at' => '2021-05-31 07:00:02',
            ],
            36 => [
                'id' => 37,
                'name' => 'subcategory.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:07',
                'updated_at' => '2021-05-31 07:00:07',
            ],
            37 => [
                'id' => 38,
                'name' => 'subcategory.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:00:17',
                'updated_at' => '2021-05-31 07:00:17',
            ],
            38 => [
                'id' => 39,
                'name' => 'childcategory.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:09',
                'updated_at' => '2021-05-31 07:14:09',
            ],
            39 => [
                'id' => 40,
                'name' => 'childcategory.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:14',
                'updated_at' => '2021-05-31 07:14:14',
            ],
            40 => [
                'id' => 41,
                'name' => 'childcategory.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:20',
                'updated_at' => '2021-05-31 07:14:20',
            ],
            41 => [
                'id' => 42,
                'name' => 'childcategory.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:14:24',
                'updated_at' => '2021-05-31 07:14:24',
            ],
            42 => [
                'id' => 43,
                'name' => 'products.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:15',
                'updated_at' => '2021-05-31 07:22:15',
            ],
            43 => [
                'id' => 44,
                'name' => 'products.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:20',
                'updated_at' => '2021-05-31 07:22:20',
            ],
            44 => [
                'id' => 45,
                'name' => 'products.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:25',
                'updated_at' => '2021-05-31 07:22:25',
            ],
            45 => [
                'id' => 46,
                'name' => 'products.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:22:29',
                'updated_at' => '2021-05-31 07:22:29',
            ],
            46 => [
                'id' => 47,
                'name' => 'products.import',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:23:32',
                'updated_at' => '2021-05-31 07:23:32',
            ],
            47 => [
                'id' => 48,
                'name' => 'attributes.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:30',
                'updated_at' => '2021-05-31 07:28:30',
            ],
            48 => [
                'id' => 49,
                'name' => 'attributes.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:37',
                'updated_at' => '2021-05-31 07:28:37',
            ],
            49 => [
                'id' => 50,
                'name' => 'attributes.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:40',
                'updated_at' => '2021-05-31 07:28:40',
            ],
            50 => [
                'id' => 51,
                'name' => 'attributes.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:28:44',
                'updated_at' => '2021-05-31 07:28:44',
            ],
            51 => [
                'id' => 52,
                'name' => 'coupans.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:30:48',
                'updated_at' => '2021-05-31 07:30:48',
            ],
            52 => [
                'id' => 53,
                'name' => 'coupans.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:30:52',
                'updated_at' => '2021-05-31 07:30:52',
            ],
            53 => [
                'id' => 54,
                'name' => 'coupans.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:31:01',
                'updated_at' => '2021-05-31 07:31:01',
            ],
            54 => [
                'id' => 55,
                'name' => 'coupans.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:31:11',
                'updated_at' => '2021-05-31 07:31:11',
            ],
            55 => [
                'id' => 56,
                'name' => 'returnpolicy.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:33:55',
                'updated_at' => '2021-05-31 07:33:55',
            ],
            56 => [
                'id' => 57,
                'name' => 'returnpolicy.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:33:59',
                'updated_at' => '2021-05-31 07:33:59',
            ],
            57 => [
                'id' => 58,
                'name' => 'returnpolicy.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:34:03',
                'updated_at' => '2021-05-31 07:34:03',
            ],
            58 => [
                'id' => 59,
                'name' => 'returnpolicy.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:34:07',
                'updated_at' => '2021-05-31 07:34:07',
            ],
            59 => [
                'id' => 60,
                'name' => 'units.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:36:26',
                'updated_at' => '2021-05-31 07:36:26',
            ],
            60 => [
                'id' => 61,
                'name' => 'units.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:36:35',
                'updated_at' => '2021-05-31 07:36:35',
            ],
            61 => [
                'id' => 62,
                'name' => 'units.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:37:01',
                'updated_at' => '2021-05-31 07:37:01',
            ],
            62 => [
                'id' => 63,
                'name' => 'units.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:37:05',
                'updated_at' => '2021-05-31 07:37:05',
            ],
            63 => [
                'id' => 64,
                'name' => 'specialoffer.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:50',
                'updated_at' => '2021-05-31 07:39:50',
            ],
            64 => [
                'id' => 65,
                'name' => 'specialoffer.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:54',
                'updated_at' => '2021-05-31 07:39:54',
            ],
            65 => [
                'id' => 66,
                'name' => 'specialoffer.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:39:59',
                'updated_at' => '2021-05-31 07:39:59',
            ],
            66 => [
                'id' => 67,
                'name' => 'specialoffer.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:40:02',
                'updated_at' => '2021-05-31 07:40:02',
            ],
            67 => [
                'id' => 68,
                'name' => 'invoicesetting.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:44:34',
                'updated_at' => '2021-05-31 07:44:34',
            ],
            68 => [
                'id' => 69,
                'name' => 'invoicesetting.update',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:44:39',
                'updated_at' => '2021-05-31 07:44:39',
            ],
            69 => [
                'id' => 70,
                'name' => 'hotdeals.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ],
            70 => [
                'id' => 71,
                'name' => 'hotdeals.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ],
            71 => [
                'id' => 72,
                'name' => 'hotdeals.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ],
            72 => [
                'id' => 73,
                'name' => 'hotdeals.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:52:16',
                'updated_at' => '2021-05-31 07:52:16',
            ],
            73 => [
                'id' => 74,
                'name' => 'blockadvertisments.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:21',
                'updated_at' => '2021-05-31 07:55:21',
            ],
            74 => [
                'id' => 75,
                'name' => 'blockadvertisments.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ],
            75 => [
                'id' => 76,
                'name' => 'blockadvertisments.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ],
            76 => [
                'id' => 77,
                'name' => 'blockadvertisments.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:22',
                'updated_at' => '2021-05-31 07:55:22',
            ],
            77 => [
                'id' => 78,
                'name' => 'advertisements.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ],
            78 => [
                'id' => 79,
                'name' => 'advertisements.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ],
            79 => [
                'id' => 80,
                'name' => 'advertisements.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ],
            80 => [
                'id' => 81,
                'name' => 'advertisements.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:55:58',
                'updated_at' => '2021-05-31 07:55:58',
            ],
            81 => [
                'id' => 82,
                'name' => 'testimonials.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:35',
                'updated_at' => '2021-05-31 07:56:35',
            ],
            82 => [
                'id' => 83,
                'name' => 'testimonials.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:35',
                'updated_at' => '2021-05-31 07:56:35',
            ],
            83 => [
                'id' => 84,
                'name' => 'testimonials.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:36',
                'updated_at' => '2021-05-31 07:56:36',
            ],
            84 => [
                'id' => 85,
                'name' => 'testimonials.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:56:36',
                'updated_at' => '2021-05-31 07:56:36',
            ],
            85 => [
                'id' => 86,
                'name' => 'offerpopup.setting',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:57:45',
                'updated_at' => '2021-05-31 07:57:45',
            ],
            86 => [
                'id' => 87,
                'name' => 'pushnotification.settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 07:58:16',
                'updated_at' => '2021-05-31 07:58:16',
            ],
            87 => [
                'id' => 88,
                'name' => 'location.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:19:03',
                'updated_at' => '2021-05-31 08:19:03',
            ],
            88 => [
                'id' => 89,
                'name' => 'shipping.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:24:03',
                'updated_at' => '2021-05-31 08:24:03',
            ],
            89 => [
                'id' => 90,
                'name' => 'taxsystem.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:24:27',
                'updated_at' => '2021-05-31 08:24:27',
            ],
            90 => [
                'id' => 91,
                'name' => 'commission.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:29:16',
                'updated_at' => '2021-05-31 08:29:16',
            ],
            91 => [
                'id' => 92,
                'name' => 'sellerpayout.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:31:59',
                'updated_at' => '2021-05-31 08:31:59',
            ],
            92 => [
                'id' => 93,
                'name' => 'currency.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 08:36:47',
                'updated_at' => '2021-05-31 08:36:47',
            ],
            93 => [
                'id' => 94,
                'name' => 'sliders.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:00:01',
                'updated_at' => '2021-05-31 09:00:01',
            ],
            94 => [
                'id' => 95,
                'name' => 'sellersubscription.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:16:44',
                'updated_at' => '2021-05-31 09:16:44',
            ],
            95 => [
                'id' => 96,
                'name' => 'affiliatesystem.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:20:57',
                'updated_at' => '2021-05-31 09:20:57',
            ],
            96 => [
                'id' => 97,
                'name' => 'faq.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ],
            97 => [
                'id' => 98,
                'name' => 'faq.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ],
            98 => [
                'id' => 99,
                'name' => 'faq.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ],
            99 => [
                'id' => 100,
                'name' => 'faq.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:24:43',
                'updated_at' => '2021-05-31 09:24:43',
            ],
            100 => [
                'id' => 101,
                'name' => 'pwasettings.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:28:39',
                'updated_at' => '2021-05-31 09:28:39',
            ],
            101 => [
                'id' => 102,
                'name' => 'terms-settings.update',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:37:19',
                'updated_at' => '2021-05-31 09:37:19',
            ],
            102 => [
                'id' => 103,
                'name' => 'color-options.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:39:55',
                'updated_at' => '2021-05-31 09:39:55',
            ],
            103 => [
                'id' => 104,
                'name' => 'payment-gateway.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:42:03',
                'updated_at' => '2021-05-31 09:42:03',
            ],
            104 => [
                'id' => 105,
                'name' => 'manual-payment.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ],
            105 => [
                'id' => 106,
                'name' => 'manual-payment.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ],
            106 => [
                'id' => 107,
                'name' => 'manual-payment.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ],
            107 => [
                'id' => 108,
                'name' => 'manual-payment.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:45:04',
                'updated_at' => '2021-05-31 09:45:04',
            ],
            108 => [
                'id' => 109,
                'name' => 'widget-settings.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:51:31',
                'updated_at' => '2021-05-31 09:51:31',
            ],
            109 => [
                'id' => 110,
                'name' => 'wallet.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 10:57:25',
                'updated_at' => '2021-05-31 10:57:25',
            ],
            110 => [
                'id' => 111,
                'name' => 'support-ticket.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:22:27',
                'updated_at' => '2021-05-31 11:22:27',
            ],
            111 => [
                'id' => 112,
                'name' => 'reported-products.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:25:09',
                'updated_at' => '2021-05-31 11:25:09',
            ],
            112 => [
                'id' => 113,
                'name' => 'addon-manager.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:26:31',
                'updated_at' => '2021-05-31 11:26:31',
            ],
            113 => [
                'id' => 114,
                'name' => 'reports.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:28:50',
                'updated_at' => '2021-05-31 11:28:50',
            ],
            114 => [
                'id' => 115,
                'name' => 'others.systemstatus',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:24',
                'updated_at' => '2021-05-31 11:31:24',
            ],
            115 => [
                'id' => 116,
                'name' => 'others.importdemo',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:30',
                'updated_at' => '2021-05-31 11:31:30',
            ],
            116 => [
                'id' => 117,
                'name' => 'others.database-backup',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 11:31:46',
                'updated_at' => '2021-05-31 11:31:46',
            ],
            117 => [
                'id' => 118,
                'name' => 'site-settings.genral-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:33:53',
                'updated_at' => '2021-05-31 12:33:53',
            ],
            118 => [
                'id' => 119,
                'name' => 'site-settings.language',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:17',
                'updated_at' => '2021-05-31 12:34:17',
            ],
            119 => [
                'id' => 120,
                'name' => 'site-settings.mail-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:27',
                'updated_at' => '2021-05-31 12:34:27',
            ],
            120 => [
                'id' => 121,
                'name' => 'site-settings.social-login-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:39',
                'updated_at' => '2021-05-31 12:34:39',
            ],
            121 => [
                'id' => 122,
                'name' => 'site-settings.sms-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:48',
                'updated_at' => '2021-05-31 12:34:48',
            ],
            122 => [
                'id' => 123,
                'name' => 'site-settings.dashboard-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:34:58',
                'updated_at' => '2021-05-31 12:34:58',
            ],
            123 => [
                'id' => 124,
                'name' => 'site-settings.maintenance-mode',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:17',
                'updated_at' => '2021-05-31 12:35:17',
            ],
            124 => [
                'id' => 125,
                'name' => 'site-settings.style-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:47',
                'updated_at' => '2021-05-31 12:35:47',
            ],
            125 => [
                'id' => 126,
                'name' => 'site-settings.footer-customize',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:35:58',
                'updated_at' => '2021-05-31 12:35:58',
            ],
            126 => [
                'id' => 127,
                'name' => 'site-settings.social-handle',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:36:11',
                'updated_at' => '2021-05-31 12:36:11',
            ],
            127 => [
                'id' => 128,
                'name' => 'site-settings.bank-settings',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:36:31',
                'updated_at' => '2021-05-31 12:36:31',
            ],
            128 => [
                'id' => 129,
                'name' => 'seo.manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:01',
                'updated_at' => '2021-05-31 12:37:01',
            ],
            129 => [
                'id' => 130,
                'name' => 'pages.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ],
            130 => [
                'id' => 131,
                'name' => 'pages.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ],
            131 => [
                'id' => 132,
                'name' => 'pages.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:21',
                'updated_at' => '2021-05-31 12:37:21',
            ],
            132 => [
                'id' => 133,
                'name' => 'pages.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:22',
                'updated_at' => '2021-05-31 12:37:22',
            ],
            133 => [
                'id' => 134,
                'name' => 'blog.view',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ],
            134 => [
                'id' => 135,
                'name' => 'blog.create',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ],
            135 => [
                'id' => 136,
                'name' => 'blog.edit',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:24',
                'updated_at' => '2021-05-31 12:37:24',
            ],
            136 => [
                'id' => 137,
                'name' => 'blog.delete',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:37:25',
                'updated_at' => '2021-05-31 12:37:25',
            ],
            137 => [
                'id' => 138,
                'name' => 'others.abuse-word-manage',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:38:13',
                'updated_at' => '2021-05-31 12:38:13',
            ],
            138 => [
                'id' => 139,
                'name' => 'digital-products.view',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ],
            139 => [
                'id' => 140,
                'name' => 'digital-products.create',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ],
            140 => [
                'id' => 141,
                'name' => 'digital-products.edit',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:14',
                'updated_at' => '2021-06-07 10:14:14',
            ],
            141 => [
                'id' => 142,
                'name' => 'digital-products.delete',
                'guard_name' => 'web',
                'created_at' => '2021-06-07 10:14:15',
                'updated_at' => '2021-06-07 10:14:15',
            ],
            142 => [
                'id' => 143,
                'name' => 'mediamanager.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:09:23',
                'updated_at' => '2021-11-22 18:09:23',
            ],
            143 => [
                'id' => 144,
                'name' => 'chat.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:10:34',
                'updated_at' => '2021-11-22 18:10:34',
            ],
            144 => [
                'id' => 145,
                'name' => 'sizechart.manage',
                'guard_name' => 'web',
                'created_at' => '2021-11-22 18:10:46',
                'updated_at' => '2021-11-22 18:10:46',
            ],
        ]);
    }
}