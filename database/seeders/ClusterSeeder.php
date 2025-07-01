<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            ['title' => 'خدمات', 'created' => j_d_stamp_en()],
            ['title' => 'صنعت', 'created' => j_d_stamp_en()],
            ['title' => 'فرهنگ و هنر', 'created' => j_d_stamp_en()],
            ['title' => 'کشاورزی', 'created' => j_d_stamp_en()],
        ];
        foreach ($clusters as $cluster) {
            Cluster::create($cluster);
        }
    }
}
