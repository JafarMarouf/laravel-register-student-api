<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['English', 'French', 'ICDL', 'Communication Skills'];
		for ($i = 0; $i < count($data); $i++) {
			Course::query()->create([
				'title' => $data[$i],
			]);
		}
    }
}
