<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'text' => 'کدام زبان برنامه‌نویسی سطح بالا و همه‌منظوره است؟',
                'description' => 'زبان برنامه نویسی پایتون به دلیل شباهت به زبان انگلیسی سطح بالاست.',
                'level_id' => 1,
                'type_id' => 1,
                'updated' => j_d_stamp_en(),
                'options' => [
                    ['text' => 'HTML', 'created' => j_d_stamp_en()],
                    ['text' => 'CSS', 'created' => j_d_stamp_en()],
                    ['text' => 'Python', 'is_correct' => true, 'created' => j_d_stamp_en()],
                    ['text' => 'SQL', 'created' => j_d_stamp_en()],
                ],
            ],
            [
                'text' => 'خروجی دستور echo در PHP چیست؟',
                'description' => 'در PHP خروجی چاپی با echo انجام می شود.',
                'level_id' => 2,
                'type_id' => 1,
                'updated' => null,
                'options' => [
                    ['text' => 'نمایش مقدار در مرورگر', 'is_correct' => true, 'created' => j_d_stamp_en()],
                    ['text' => 'تعریف متغیر', 'created' => j_d_stamp_en()],
                    ['text' => 'خواندن فایل', 'created' => j_d_stamp_en()],
                    ['text' => 'اتصال به پایگاه داده', 'created' => j_d_stamp_en()],
                ],
            ],

            [
                'text' => 'آیا پایتون هنگام مواجه با شناسه های زبانی حساس به حروف بزرگ و کوچک است؟',
                'description' => 'پایتون نسبت به حروف بزرگ و کوچک در شناسه ها حساس است.',
                'level_id' => 1,
                'type_id' => 1,
                'updated' => j_d_stamp_en(),
                'options' => [
                    ['text' => 'بله', 'is_correct' => true, 'created' => j_d_stamp_en()],
                    ['text' => 'خیر', 'created' => j_d_stamp_en()],
                    ['text' => 'بستگی به ماشین دارد.', 'created' => j_d_stamp_en()],
                    ['text' => 'هیچکدام', 'created' => j_d_stamp_en()],
                ],
            ],
        ];

        foreach ($questions as $data) {
            $question = Question::create([
                'text' => $data['text'],
                'description' => $data['description'],
                'level_id' => $data['level_id'],
                'type_id' => $data['type_id'],
                'created' => j_d_stamp_en(),
                'updated' => $data['updated'],
            ]);

            foreach ($data['options'] as $option) {
                $question->options()->create($option);
            }
        }
    }
}
