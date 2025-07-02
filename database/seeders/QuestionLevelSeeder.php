<?php

namespace Database\Seeders;

use App\Models\QuestionLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['title' => 'آسان'],
            ['title' => 'متوسط'],
            ['title' => 'سخت'],
        ];

        foreach ($levels as $level) {
            QuestionLevel::create($level);
        }
    }
}
