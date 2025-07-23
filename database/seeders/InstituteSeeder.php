<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutes = [
            ['short_name' => 'آی تک', 'full_name' => 'آموزشگاه فنی و حرفه ای آزاد آی تک', 'abb' => 'ITC', 'remain_credit' => 1000, 'created' => j_d_stamp_en()],
        ];

        foreach ($institutes as $institute) {
            Institute::create($institute);
        }

    }
}
