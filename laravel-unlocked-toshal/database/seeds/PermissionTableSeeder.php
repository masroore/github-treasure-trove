<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'role-list', 'group_name' => 'Roles'],
            ['name' => 'role-create', 'group_name' => 'Roles'],
            ['name' => 'role-edit', 'group_name' => 'Roles'],
            ['name' => 'role-delete', 'group_name' => 'Roles'],
            ['name' => 'permission-list', 'group_name' => 'Permissions'],
            ['name' => 'permission-create', 'group_name' => 'Permissions'],
            ['name' => 'permission-edit', 'group_name' => 'Permissions'],
            ['name' => 'permission-delete', 'group_name' => 'Permissions'],
            ['name' => 'company-list', 'group_name' => 'Companies'],
            ['name' => 'company-create', 'group_name' => 'Companies'],
            ['name' => 'company-edit', 'group_name' => 'Companies'],
            ['name' => 'company-delete', 'group_name' => 'Companies'],
            ['name' => 'user-list', 'group_name' => 'Users'],
            ['name' => 'user-create', 'group_name' => 'Users'],
            ['name' => 'user-edit', 'group_name' => 'Users'],
            ['name' => 'user-delete', 'group_name' => 'Users'],
            ['name' => 'category-list', 'group_name' => 'Categories'],
            ['name' => 'category-create', 'group_name' => 'Categories'],
            ['name' => 'category-edit', 'group_name' => 'Categories'],
            ['name' => 'category-delete', 'group_name' => 'Categories'],
            ['name' => 'service-list', 'group_name' => 'Services'],
            ['name' => 'service-create', 'group_name' => 'Services'],
            ['name' => 'service-edit', 'group_name' => 'Services'],
            ['name' => 'service-delete', 'group_name' => 'Services'],
            ['name' => 'tag-list', 'group_name' => 'Tags'],
            ['name' => 'tag-create', 'group_name' => 'Tags'],
            ['name' => 'tag-edit', 'group_name' => 'Tags'],
            ['name' => 'tag-delete', 'group_name' => 'Tags'],
            ['name' => 'currency-list', 'group_name' => 'Currencies'],
            ['name' => 'currency-create', 'group_name' => 'Currencies'],
            ['name' => 'currency-edit', 'group_name' => 'Currencies'],
            ['name' => 'currency-delete', 'group_name' => 'Currencies'],
            ['name' => 'gateway-list', 'group_name' => 'Payment Gateways'],
            ['name' => 'gateway-create', 'group_name' => 'Payment Gateways'],
            ['name' => 'gateway-edit', 'group_name' => 'Payment Gateways'],
            ['name' => 'gateway-delete', 'group_name' => 'Payment Gateways'],
            ['name' => 'method-list', 'group_name' => 'Payment Methods'],
            ['name' => 'method-create', 'group_name' => 'Payment Methods'],
            ['name' => 'method-edit', 'group_name' => 'Payment Methods'],
            ['name' => 'method-delete', 'group_name' => 'Payment Methods'],
            ['name' => 'plan-list', 'group_name' => 'Membership Plans'],
            ['name' => 'plan-create', 'group_name' => 'Membership Plans'],
            ['name' => 'plan-edit', 'group_name' => 'Membership Plans'],
            ['name' => 'plan-delete', 'group_name' => 'Membership Plans'],
            ['name' => 'cmspage-list', 'group_name' => 'CMS Pages'],
            ['name' => 'cmspage-create', 'group_name' => 'CMS Pages'],
            ['name' => 'cmspage-edit', 'group_name' => 'CMS Pages'],
            ['name' => 'cmspage-delete', 'group_name' => 'CMS Pages'],
            ['name' => 'smtp-list', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-create', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-edit', 'group_name' => 'SMTP Details'],
            ['name' => 'smtp-delete', 'group_name' => 'SMTP Details'],
            ['name' => 'responder-list', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-create', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-edit', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'responder-delete', 'group_name' => 'Autoresponder Templates'],
            ['name' => 'emaillogs-list', 'group_name' => 'Email Logs'],
        ];

        foreach ($permissions as $permission) {
            $usercount = Permission::where(['name' => $permission['name'], 'group_name' => $permission['group_name']])->count();
            if ($usercount == 0) {
                Permission::create(['name' => $permission['name'], 'group_name' => $permission['group_name']]);
            }
        }
    }
}
