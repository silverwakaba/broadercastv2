<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        Role::create([
            'name' => 'Admin',
        ])->givePermissionTo(['canLogin', 'canManage', 'isAdmin']);

        Role::create([
            'name' => 'Moderator',
        ])->givePermissionTo(['canLogin', 'canManage', 'isModerator']);

        Role::create([
            'name' => 'Management',
        ])->givePermissionTo(['canLogin', 'canManage', 'isManagement']);

        Role::create([
            'name' => 'Creator',
        ])->givePermissionTo(['canLogin', 'canManage']);

        Role::create([
            'name' => 'User',
        ])->givePermissionTo(['canLogin']);
    }
}
