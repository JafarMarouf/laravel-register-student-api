<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseTeacher extends Model
{
    use HasFactory;
	protected $fillable = [
		'teacher_id',
		'course_id'
	];
	
	
	/**
	 * My FK belongsTo
	 */
	
	 public function course(): BelongsTo
	 {
		return $this->belongsTo(Course::class);
	 }
	 
	 public function teacher(): BelongsTo
	 {
		return $this->belongsTo(Teacher::class);
	 }

	/**
	 * Who has My PK
	 */
	public function course_teacher_students(): HasMany
	{
		return $this->hasMany(CourseTeacherStudent::class);
	}
}
