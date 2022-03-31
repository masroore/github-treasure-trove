<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'basic_c_r_m_access',
            ],
            [
                'id'    => 18,
                'title' => 'crm_status_create',
            ],
            [
                'id'    => 19,
                'title' => 'crm_status_edit',
            ],
            [
                'id'    => 20,
                'title' => 'crm_status_show',
            ],
            [
                'id'    => 21,
                'title' => 'crm_status_delete',
            ],
            [
                'id'    => 22,
                'title' => 'crm_status_access',
            ],
            [
                'id'    => 23,
                'title' => 'crm_customer_create',
            ],
            [
                'id'    => 24,
                'title' => 'crm_customer_edit',
            ],
            [
                'id'    => 25,
                'title' => 'crm_customer_show',
            ],
            [
                'id'    => 26,
                'title' => 'crm_customer_delete',
            ],
            [
                'id'    => 27,
                'title' => 'crm_customer_access',
            ],
            [
                'id'    => 28,
                'title' => 'crm_note_create',
            ],
            [
                'id'    => 29,
                'title' => 'crm_note_edit',
            ],
            [
                'id'    => 30,
                'title' => 'crm_note_show',
            ],
            [
                'id'    => 31,
                'title' => 'crm_note_delete',
            ],
            [
                'id'    => 32,
                'title' => 'crm_note_access',
            ],
            [
                'id'    => 33,
                'title' => 'crm_document_create',
            ],
            [
                'id'    => 34,
                'title' => 'crm_document_edit',
            ],
            [
                'id'    => 35,
                'title' => 'crm_document_show',
            ],
            [
                'id'    => 36,
                'title' => 'crm_document_delete',
            ],
            [
                'id'    => 37,
                'title' => 'crm_document_access',
            ],
            [
                'id'    => 38,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 39,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 40,
                'title' => 'property_management_access',
            ],
            [
                'id'    => 41,
                'title' => 'category_create',
            ],
            [
                'id'    => 42,
                'title' => 'category_edit',
            ],
            [
                'id'    => 43,
                'title' => 'category_show',
            ],
            [
                'id'    => 44,
                'title' => 'category_delete',
            ],
            [
                'id'    => 45,
                'title' => 'category_access',
            ],
            [
                'id'    => 46,
                'title' => 'property_create',
            ],
            [
                'id'    => 47,
                'title' => 'property_edit',
            ],
            [
                'id'    => 48,
                'title' => 'property_show',
            ],
            [
                'id'    => 49,
                'title' => 'property_delete',
            ],
            [
                'id'    => 50,
                'title' => 'property_access',
            ],
            [
                'id'    => 51,
                'title' => 'amenity_create',
            ],
            [
                'id'    => 52,
                'title' => 'amenity_edit',
            ],
            [
                'id'    => 53,
                'title' => 'amenity_show',
            ],
            [
                'id'    => 54,
                'title' => 'amenity_delete',
            ],
            [
                'id'    => 55,
                'title' => 'amenity_access',
            ],
            [
                'id'    => 56,
                'title' => 'property_tag_create',
            ],
            [
                'id'    => 57,
                'title' => 'property_tag_edit',
            ],
            [
                'id'    => 58,
                'title' => 'property_tag_show',
            ],
            [
                'id'    => 59,
                'title' => 'property_tag_delete',
            ],
            [
                'id'    => 60,
                'title' => 'property_tag_access',
            ],
            [
                'id'    => 61,
                'title' => 'propoerty_inquiry_create',
            ],
            [
                'id'    => 62,
                'title' => 'propoerty_inquiry_edit',
            ],
            [
                'id'    => 63,
                'title' => 'propoerty_inquiry_show',
            ],
            [
                'id'    => 64,
                'title' => 'propoerty_inquiry_delete',
            ],
            [
                'id'    => 65,
                'title' => 'propoerty_inquiry_access',
            ],
            [
                'id'    => 66,
                'title' => 'property_review_create',
            ],
            [
                'id'    => 67,
                'title' => 'property_review_edit',
            ],
            [
                'id'    => 68,
                'title' => 'property_review_show',
            ],
            [
                'id'    => 69,
                'title' => 'property_review_delete',
            ],
            [
                'id'    => 70,
                'title' => 'property_review_access',
            ],
            [
                'id'    => 71,
                'title' => 'page_access',
            ],
            [
                'id'    => 72,
                'title' => 'about_us_create',
            ],
            [
                'id'    => 73,
                'title' => 'about_us_edit',
            ],
            [
                'id'    => 74,
                'title' => 'about_us_show',
            ],
            [
                'id'    => 75,
                'title' => 'about_us_delete',
            ],
            [
                'id'    => 76,
                'title' => 'about_us_access',
            ],
            [
                'id'    => 77,
                'title' => 'faq_create',
            ],
            [
                'id'    => 78,
                'title' => 'faq_edit',
            ],
            [
                'id'    => 79,
                'title' => 'faq_show',
            ],
            [
                'id'    => 80,
                'title' => 'faq_delete',
            ],
            [
                'id'    => 81,
                'title' => 'faq_access',
            ],
            [
                'id'    => 82,
                'title' => 'system_setting_access',
            ],
            [
                'id'    => 83,
                'title' => 'contact_us_message_create',
            ],
            [
                'id'    => 84,
                'title' => 'contact_us_message_edit',
            ],
            [
                'id'    => 85,
                'title' => 'contact_us_message_show',
            ],
            [
                'id'    => 86,
                'title' => 'contact_us_message_delete',
            ],
            [
                'id'    => 87,
                'title' => 'contact_us_message_access',
            ],
            [
                'id'    => 88,
                'title' => 'blog_create',
            ],
            [
                'id'    => 89,
                'title' => 'blog_edit',
            ],
            [
                'id'    => 90,
                'title' => 'blog_show',
            ],
            [
                'id'    => 91,
                'title' => 'blog_delete',
            ],
            [
                'id'    => 92,
                'title' => 'blog_access',
            ],
            [
                'id'    => 93,
                'title' => 'seach_create',
            ],
            [
                'id'    => 94,
                'title' => 'seach_edit',
            ],
            [
                'id'    => 95,
                'title' => 'seach_show',
            ],
            [
                'id'    => 96,
                'title' => 'seach_delete',
            ],
            [
                'id'    => 97,
                'title' => 'seach_access',
            ],
            [
                'id'    => 98,
                'title' => 'our_partner_create',
            ],
            [
                'id'    => 99,
                'title' => 'our_partner_edit',
            ],
            [
                'id'    => 100,
                'title' => 'our_partner_show',
            ],
            [
                'id'    => 101,
                'title' => 'our_partner_delete',
            ],
            [
                'id'    => 102,
                'title' => 'our_partner_access',
            ],
            [
                'id'    => 103,
                'title' => 'subscriber_create',
            ],
            [
                'id'    => 104,
                'title' => 'subscriber_edit',
            ],
            [
                'id'    => 105,
                'title' => 'subscriber_show',
            ],
            [
                'id'    => 106,
                'title' => 'subscriber_delete',
            ],
            [
                'id'    => 107,
                'title' => 'subscriber_access',
            ],
            [
                'id'    => 108,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
