<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            ['title' => 'فناوری اطلاعات', 'cluster_id' => 1, 'created' => j_d_stamp_en()],
            ['title' => 'امور مالی و بازرگانی', 'cluster_id' => 1, 'created' => j_d_stamp_en()],
            ['title' => 'هنرهای تجسمی', 'cluster_id' => 3, 'created' => j_d_stamp_en()],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }
    }
}
