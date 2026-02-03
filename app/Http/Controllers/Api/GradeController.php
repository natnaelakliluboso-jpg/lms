<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isStudent()) {
            $grades = $user->grades()->with(['course', 'course.teacher'])->get();
        } elseif ($user->isTeacher()) {
            $courseIds = $user->teachingCourses()->pluck('id');
            $grades = Grade::whereIn('course_id', $courseIds)
                ->with(['student', 'course'])
                ->get();
        } else {
            $grades = Grade::with(['student', 'course', 'course.teacher'])->get();
        }

        return response()->json([
            'grades' => $grades,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'assignment_name' => 'required|string|max:255',
            'grade' => 'required|numeric|min:0',
            'max_grade' => 'required|numeric|min:0',
            'comments' => 'nullable|string',
        ]);

        $user = $request->user();

        // Check if user is teacher of this course or admin
        $course = Course::findOrFail($request->course_id);
        if (!$user->isAdmin() && $course->teacher_id !== $user->id) {
            return response()->json([
                'message' => 'You can only assign grades to your own courses',
            ], 403);
        }

        // Check if student is enrolled in the course
        $isEnrolled = $course->students()->where('users.id', $request->student_id)->exists();
        if (!$isEnrolled) {
            return response()->json([
                'message' => 'Student is not enrolled in this course',
            ], 400);
        }

        $grade = Grade::create($request->all());

        return response()->json([
            'message' => 'Grade assigned successfully',
            'grade' => $grade->load(['student', 'course']),
        ], 201);
    }

    public function show(Grade $grade)
    {
        return response()->json([
            'grade' => $grade->load(['student', 'course']),
        ]);
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'assignment_name' => 'sometimes|required|string|max:255',
            'grade' => 'sometimes|required|numeric|min:0',
            'max_grade' => 'sometimes|required|numeric|min:0',
            'comments' => 'nullable|string',
        ]);

        $user = $request->user();

        // Check if user is teacher of this course or admin
        if (!$user->isAdmin() && $grade->course->teacher_id !== $user->id) {
            return response()->json([
                'message' => 'You can only update grades for your own courses',
            ], 403);
        }

        $grade->update($request->all());

        return response()->json([
            'message' => 'Grade updated successfully',
            'grade' => $grade->load(['student', 'course']),
        ]);
    }

    public function destroy(Grade $grade)
    {
        $user = request()->user();

        // Check if user is teacher of this course or admin
        if (!$user->isAdmin() && $grade->course->teacher_id !== $user->id) {
            return response()->json([
                'message' => 'You can only delete grades for your own courses',
            ], 403);
        }

        $grade->delete();

        return response()->json([
            'message' => 'Grade deleted successfully',
        ]);
    }

    public function myGrades(Request $request)
    {
        $user = $request->user();

        if (!$user->isStudent()) {
            return response()->json([
                'message' => 'Only students have grades',
            ], 403);
        }

        $grades = $user->grades()->with(['course', 'course.teacher'])->get();

        return response()->json([
            'grades' => $grades,
        ]);
    }

    public function courseGrades(Request $request, Course $course)
    {
        $user = $request->user();

        // Check if user is teacher of this course or admin
        if (!$user->isAdmin() && $course->teacher_id !== $user->id) {
            return response()->json([
                'message' => 'You can only view grades for your own courses',
            ], 403);
        }

        $grades = $course->grades()->with('student')->get();

        return response()->json([
            'grades' => $grades,
        ]);
    }
}