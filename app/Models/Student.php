<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
	protected $fillable = [
		'student_name', 'mobile'
	];
	
	/**
	 * Who has My PK
	 */
	
	public function course_teacher_students():HasMany
	{
		return $this->hasMany(CourseTeacherStudent::class);
	}
}