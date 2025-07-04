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
            ['title' => 'خدمات'],
            ['title' => 'صنعت'],
            ['title' => 'فرهنگ و هنر'],
            ['title' => 'کشاورزی'],
        ];
        foreach ($clusters as $cluster) {
            Cluster::create($cluster);
        }
    }
}
