<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;
	protected $fillable = [
		'teacher_name','mobile'
	];
	
	/**
	 * Who has my PK
	 */
	
	 
	 public function course_teachers(): HasMany
	 {
		return $this->hasMany(CourseTeacher::class);
	 }
}
