<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            ClusterSeeder::class,
            FieldSeeder::class,
            SkillStandardSeeder::class,
            QuestionLevelSeeder::class,
            QuestionTypeSeeder::class,
            QuestionSeeder::class,
            InstituteSeeder::class,
        ]);
    }
}
