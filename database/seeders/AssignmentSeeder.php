<?php

namespace Database\Seeders;

use App\Courses\Models\Assignment;
use App\Courses\Models\Course;
use App\Users\Models\User;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 50;

        $data[] = [
            [
                'student_id' => 1,
                'course_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'student_id' => 2,
                'course_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ];
        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'student_id' => User::get('user_id')->random()->user_id,
                'course_id' => rand(1,5),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Assignment::insert($chunk);
        }
    }
}
