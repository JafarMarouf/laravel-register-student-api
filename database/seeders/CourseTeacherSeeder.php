<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseTeacher;

class CourseTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'English')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name' ,'=' , 'Gary Cabrera')->first()['id'],
		]);

		CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'English')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name', '=', 'James Vance')->first()['id'],
		]);

		CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'French')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name', '=', 'Aliza Vance')->first()['id'],
		]);

		CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'French')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name', '=', 'Averie Carter')->first()['id'],
		]);

		CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'ICDL')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name', '=', 'James Vance')->first()['id'],
		]);
		
		CourseTeacher::query()->create([
			'course_id' => Course::query()->where('title', '=', 'Communication Skills')->first()['id'],
			'teacher_id' => Teacher::query()->where('teacher_name', '=', 'Aliza Vance')->first()['id'],
		]);
    }
}
