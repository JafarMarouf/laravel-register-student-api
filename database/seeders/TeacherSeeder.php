<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Gary Cabrera', 'James Vance', 'Aliza Vance', 'Averie Carter'];
		for( $i = 0; $i < count($data); $i++ ) {
			Teacher::query()->create([
				'teacher_name' => $data[$i],
			]);
		}
    }
}
