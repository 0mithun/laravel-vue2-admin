<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        $admin = Role::whereName('admin')->first();
        $admin->permissions()->sync($permissions->pluck('id')->toArray());

        $editorPermissions = $permissions->whereIn('name', [
            'view_users',
            'edit_users',
            'view_roles',
            'view_orders',
            'edit_orders',
            'edit_products',
            'view_products',
        ])->pluck('id')->toArray();
        $editor = Role::whereName('editor')->first();
        $editor->permissions()->sync($editorPermissions);


        $viewerPermissions = $permissions->whereIn('name', [
            'view_users',
            'view_roles',
            'view_orders',
            'view_products',
        ])->pluck('id')->toArray();
        $viewer = Role::whereName('viewer')->first();
        $viewer->permissions()->sync($viewerPermissions);
    }
}
