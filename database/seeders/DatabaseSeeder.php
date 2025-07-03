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
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Yasser',
            'email' => 'yasser@gmail.com',
            'password' => Hash::make('123123123'),
        ]);

        $this->call([
            ClusterSeeder::class,
            FieldSeeder::class,
            QuestionLevelSeeder::class,
            QuestionSeeder::class,

        ]);
    }
}
