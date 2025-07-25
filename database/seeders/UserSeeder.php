<?php

namespace Database\Seeders;

use App\Models\Mobile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['user_name' => 'Yasser', 'password' => '123456789'],
            ['user_name' => 'Amin', 'password' => '123456789'],
            ['user_name' => 'Amir', 'password' => '123456789'],
            ['user_name' => 'Ali', 'password' => '123456789'],
            ['user_name' => 'Sara', 'password' => '123456789'],
            ['user_name' => 'Dara', 'password' => '123456789'],
            ['user_name' => 'Mina', 'password' => '123456789'],
        ];
        foreach ($users as $data) {
            User::create([
                'user_name' => $data['user_name'],
                'password' => $data['password'],
                'created' => j_d_stamp_en(),
            ]);
        }
    }
}
