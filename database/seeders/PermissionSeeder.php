<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run() : void{
        // Can
        Permission::create([
            'name' => 'canLogin',
        ]);

        Permission::create([
            'name' => 'canBan',
        ]);

        Permission::create([
            'name' => 'canReport',
        ]);

        Permission::create([
            'name' => 'canManage',
        ]);

        // Is
        Permission::create([
            'name' => 'isVerified', // Given separately
        ]);

        Permission::create([
            'name' => 'isAdmin',
        ]);

        Permission::create([
            'name' => 'isModerator',
        ]);

        Permission::create([
            'name' => 'isManagement',
        ]);

        Permission::create([
            'name' => 'isImportant', // Given separately
        ]);
    }
}
