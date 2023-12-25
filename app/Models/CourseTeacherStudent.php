<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTeacherStudent extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'student_id',
		'course_teacher_id'
	];
	
	/**
	 * My FK belongsTo
	 */
	
	 public function student(): BelongsTo
	 {
		return $this->belongsTo(Student::class);
	 }
	 
	 public function course_teacher(): BelongsTo
	 {
		return $this->belongsTo(CourseTeacher::class);
	 }
}
