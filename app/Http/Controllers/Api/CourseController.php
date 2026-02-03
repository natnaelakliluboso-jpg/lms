<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isTeacher()) {
            $courses = $user->teachingCourses()->with('enrollments.student')->get();
        } elseif ($user->isStudent()) {
            $courses = Course::where('status', 'active')->get();
        } else {
            $courses = Course::with(['teacher', 'enrollments'])->get();
        }

        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $course = Course::create($request->all());

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course->load('teacher'),
        ], 201);
    }

    public function show(Course $course)
    {
        return response()->json([
            'course' => $course->load(['teacher', 'students', 'grades']),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $course->update($request->all());

        return response()->json([
            'message' => 'Course updated successfully',
            'course' => $course->load('teacher'),
        ]);
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully',
        ]);
    }

    public function enrolledStudents(Course $course)
    {
        $this->authorize('view', $course);

        $students = $course->students()->with('grades')->get();

        return response()->json([
            'students' => $students,
        ]);
    }
}