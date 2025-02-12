<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_teacher_students', function (Blueprint $table) {
            $table->id();
			$table->foreignId('student_id')
				  ->constrained()
				  ->cascadeOnDelete()
				  ->cascadeOnUpdate();
		  $table->foreignId('course_teacher_id')
			  	->constrained('course_teachers')
			  	->cascadeOnDelete()
			  	->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_teacher_students');
    }
};
