<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name_en' => 'Super-Admin', 'name_fa' => 'سوپر ادمین'],
            ['name_en' => 'Originator', 'name_fa' => 'موسس'],
            ['name_en' => 'Manager', 'name_fa' => 'مدیر'],
            ['name_en' => 'Assistant', 'name_fa' => 'منشی'],
            ['name_en' => 'Accountant', 'name_fa' => 'حسابدار'],
            ['name_en' => 'Teacher', 'name_fa' => 'مربی'],
            ['name_en' => 'Student', 'name_fa' => 'کارآموز'],
            ['name_en' => 'JobSeeker', 'name_fa' => 'کارجو'],
            ['name_en' => 'Examiner', 'name_fa' => 'آزمونگر'],
            ['name_en' => 'Marketer', 'name_fa' => 'بازاریاب'],
            ['name_en' => 'QuestionMaker', 'name_fa' => 'طراح سوال'],
            ['name_en' => 'QuestionAuditor', 'name_fa' => 'ممیز سوال']
        ];

        foreach ($roles as $data) {
            Role::create([
                'name_en' => $data['name_en'],
                'name_fa' => $data['name_fa'],
                'created' => j_d_stamp_en(),
            ]);
        }
    }
}
