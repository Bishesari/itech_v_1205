<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name_en' => 'user_create', 'created'=>j_d_stamp_en()],
            ['name_en' => 'user_update', 'created'=>j_d_stamp_en()],
            ['name_en' => 'user_update', 'created' => j_d_stamp_en()],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
