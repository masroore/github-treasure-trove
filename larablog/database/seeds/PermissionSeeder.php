<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'display_name' => 'Update Users',
            'slug' => 'update-users',
            'description' => 'Allow user to Update Users',
        ]);
        Permission::create([
            'display_name' => 'View Users',
            'slug' => 'view-users',
            'description' => 'Allow user to View Users',
        ]);
        Permission::create([
            'display_name' => 'Delete Users',
            'slug' => 'delete-users',
            'description' => 'Allow user to Delete Users',
        ]);

        Permission::create([
            'display_name' => 'View Posts',
            'slug' => 'view-posts',
            'description' => 'Allow user to View Posts',
        ]);
        Permission::create([
            'display_name' => 'Update Posts',
            'slug' => 'update-posts',
            'description' => 'Allow user to Update Posts',
        ]);
        Permission::create([
            'display_name' => 'Delete Posts',
            'slug' => 'delete-posts',
            'description' => 'Allow user to Delete Posts',
        ]);

        Permission::create([
            'display_name' => 'Create Category',
            'slug' => 'create-category',
            'description' => 'Allow user to Create Category',
        ]);
        Permission::create([
            'display_name' => 'View Category',
            'slug' => 'view-category',
            'description' => 'Allow user to View Category',
        ]);
        Permission::create([
            'display_name' => 'Update Category',
            'slug' => 'update-category',
            'description' => 'Allow user to Update Category',
        ]);
        Permission::create([
            'display_name' => 'Delete Category',
            'slug' => 'delete-category',
            'description' => 'Allow user to Delete Category',
        ]);

        Permission::create([
            'display_name' => 'Create Tags',
            'slug' => 'create-tags',
            'description' => 'Allow user to Create Tags',
        ]);
        Permission::create([
            'display_name' => 'View Tags',
            'slug' => 'view-tags',
            'description' => 'Allow user to View Tags',
        ]);
        Permission::create([
            'display_name' => 'Update Tags',
            'slug' => 'update-tags',
            'description' => 'Allow user to Update Tags',
        ]);
        Permission::create([
            'display_name' => 'Delete Tags',
            'slug' => 'delete-tags',
            'description' => 'Allow user to Delete Tags',
        ]);

        Permission::create([
            'display_name' => 'Create Roles',
            'slug' => 'create-roles',
            'description' => 'Allow user to Create Roles',
        ]);
        Permission::create([
            'display_name' => 'View Roles',
            'slug' => 'view-roles',
            'description' => 'Allow user to View Roles',
        ]);
        Permission::create([
            'display_name' => 'Update Roles',
            'slug' => 'update-roles',
            'description' => 'Allow user to Update Roles',
        ]);
        Permission::create([
            'display_name' => 'Delete Roles',
            'slug' => 'delete-roles',
            'description' => 'Allow user to Delete Roles',
        ]);

        Permission::create([
            'display_name' => 'Create Permissions',
            'slug' => 'create-permissions',
            'description' => 'Allow user to Create Permissions',
        ]);
        Permission::create([
            'display_name' => 'View Permissions',
            'slug' => 'view-permissions',
            'description' => 'Allow user to View Permissions',
        ]);
        Permission::create([
            'display_name' => 'Update Permissions',
            'slug' => 'update-permissions',
            'description' => 'Allow user to Update Permissions',
        ]);
        Permission::create([
            'display_name' => 'Delete Permissions',
            'slug' => 'delete-permissions',
            'description' => 'Allow user to Delete Permissions',
        ]);
    }
}
