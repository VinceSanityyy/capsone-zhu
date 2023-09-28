<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'accept-student']);
        Permission::create(['name' => 'view-dashboard']);

        $admin = Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        $student = Role::create(['name' => 'student']);
        $faculty = Role::create(['name' => 'faculty']);
        $panel = Role::create(['name' => 'panel']);
        $adviser = Role::create(['name' => 'adviser']);
    }
}