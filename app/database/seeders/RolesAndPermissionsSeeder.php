<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'vigilante', 'guard_name' => 'web'],
            ['name' => 'cgm', 'guard_name' => 'web']
        ];

        $permissions = [
            ['name' => 'create_ocurrence', 'guard_name' => 'web'],
            ['name' => 'edit_ocurrence', 'guard_name' => 'web'],
            ['name' => 'view_ocurrence', 'guard_name' => 'web'],
            ['name' => 'create_secretary', 'guard_name' => 'web'],
            ['name' => 'view_secretary', 'guard_name' => 'web'],
            ['name' => 'edit_secretary', 'guard_name' => 'web'],
            ['name' => 'create_ocurrence_category', 'guard_name' => 'web'],
            ['name' => 'edit_ocurrence_category', 'guard_name' => 'web'],
            ['name' => 'view_ocurrence_category', 'guard_name' => 'web'],
            ['name' => 'create_building', 'guard_name' => 'web'],
            ['name' => 'edit_building', 'guard_name' => 'web'],
            ['name' => 'view_building', 'guard_name' => 'web'],
            ['name' => 'create_followup', 'guard_name' => 'web'],
            ['name' => 'edit_followup', 'guard_name' => 'web'],
            ['name' => 'view_followup', 'guard_name' => 'web'],
            ['name' => 'create_role', 'guard_name' => 'web'],
            ['name' => 'edit_role', 'guard_name' => 'web'],
            ['name' => 'view_role', 'guard_name' => 'web'],
            ['name' => 'create_user', 'guard_name' => 'web'],
            ['name' => 'edit_user', 'guard_name' => 'web'],
            ['name' => 'view_user', 'guard_name' => 'web'],
            ['name' => 'change_passwords', 'guard_name' => 'web']            
        ];

        DB::table('roles')->insert($roles);
        DB::table('permissions')->insert($permissions);

        $roleAdmin = \Spatie\Permission\Models\Role::where('name', 'admin')->get();

        foreach($permissions as $permission)
        {
            $roleAdmin[0]->givePermissionTo($permission['name']);
        }
    }
}
