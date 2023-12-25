<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseTeacher;
use App\Models\CourseTeacherStudent;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
	public function index()
	{
		$students = Student::query()
			->select('id', 'student_name')
			->with([
				'course_teacher_students:id,student_id,course_teacher_id', 'course_teacher_students.course_teacher:id,course_id,teacher_id',
				'course_teacher_students.course_teacher.course:id,title',
				'course_teacher_students.course_teacher.teacher:id,teacher_name'
			])->get();

		return response()->json([
			'status' => true,
			'data' => $students,
			'message' => 'Fetched All Students with their registered courses'
		]);
	}
	
	public function store(Request $request): JsonResponse
	{
		$request->validate([
			'student_name' => ['required', 'unique:students,student_name'],
			'student_courses' => ['array', 'present'],
			'student_courses.*.teacher' => ['required'],
			'student_courses.*.course' => ['required'],
		]);

		$student = Student::query()->create([
			'student_name' => $request['student_name']
		]);
		$students_courses = [];
		
		foreach ($request['student_courses'] as $student_courses) {
			$teacher_name = $student_courses['teacher'];
			$course_name = $student_courses['course'];

			$teacher = Teacher::query()->where('teacher_name', '=', $teacher_name)->first();
			if (is_null($teacher)) {
				$teacher = Teacher::query()->create([
					'teacher_name' => $teacher_name,
				]);
			}
			
			$course = Course::query()->where('title', '=', $course_name)->first();
			if (is_null($course)) {
				$course = Course::query()->create([
					'title' => $course_name,
				]);
			}
			
			$course_teacher = CourseTeacher::query()
				->where('course_id', '=', $course['id'])
				->where('teacher_id', '=', $teacher['id'])
				->first();

			if (is_null($course_teacher)) {
				$course_teacher = CourseTeacher::query()->create([
					'course_id' => $course['id'],
					'teacher_id' => $teacher['id']
				]);
			}
			//dd($course_teacher);

			$student_course = CourseTeacherStudent::query()->create([
				'student_id' => $student['id'],
				'course_teacher_id' => $course_teacher['id']
			]);
			//return response()->json([
			//	'data' => $student_course
			//]);
			$students_courses[] = CourseTeacherStudent::query()
				->select('student_id', 'course_teacher_id')
				->with(
					['course_teacher:id,teacher_id,course_id', 'student:id,student_name', 'course_teacher.course:id,title', 'course_teacher.teacher:id,teacher_name']
				)->find($student_course['id']);
		}
		return response()->json([
			'status' => true,
			'data' => $students_courses,
			'message' => 'Student Stored Successfully'
		]);
	}


	public function update(Request $request, $id)
	{
		$request->validate([
			'student_courses' => ['array', 'present'],
			'student_courses.*.teacher' => ['required'],
			'student_courses.*.course' => ['required'],
		]);

		//$student = Student::query()->create([
		//	'student_name' => $request['student_name']
		//]);
		$student = Student::query()->find($id);
		if(is_null($student)){
			return response()->json([
				'status'=> false,
				'data' => [],
				'message'=> 'Student not Found in System'
			]);
		}
		$students_courses = [];
		$student->course_teacher_students()->delete();
		return $student;

		foreach ($request['student_courses'] as $student_courses) {
			$teacher_name = $student_courses['teacher'];
			$course_name = $student_courses['course'];

			$teacher = Teacher::query()->where('teacher_name', '=', $teacher_name)->first();
			if (is_null($teacher)) {
				$teacher = Teacher::query()->create([
					'teacher_name' => $teacher_name,
				]);
			}

			$course = Course::query()->where('title', '=', $course_name)->first();
			if (is_null($course)) {
				$course = Course::query()->create([
					'title' => $course_name,
				]);
			}

			$course_teacher = CourseTeacher::query()
			->where('course_id', '=', $course['id'])
			->where('teacher_id', '=', $teacher['id'])
			->first();

			if (is_null($course_teacher)) {
				$course_teacher = CourseTeacher::query()->create([
					'course_id' => $course['id'],
					'teacher_id' => $teacher['id']
				]);
			}
			//dd($course_teacher);

			$student_course = CourseTeacherStudent::query()->create([
				'student_id' => $student['id'],
				'course_teacher_id' => $course_teacher['id']
			]);
			//return response()->json([
			//	'data' => $student_course
			//]);
			$students_courses[] = CourseTeacherStudent::query()
			->select('student_id', 'course_teacher_id')
			->with(
				['course_teacher:id,teacher_id,course_id', 'student:id,student_name', 'course_teacher.course:id,title', 'course_teacher.teacher:id,teacher_name']
			)->find($student_course['id']);
		}
		return response()->json([
			'status' => true,
			'data' => $students_courses,
			'message' => 'Student Updated Successfully'
		]);
	}
}
