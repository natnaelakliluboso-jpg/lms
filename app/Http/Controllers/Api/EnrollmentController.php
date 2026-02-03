<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $enrollments = Enrollment::with(['student', 'course'])->get();
        } elseif ($user->isStudent()) {
            $enrollments = $user->enrollments()->with('course')->get();
        } else {
            // Teachers can see enrollments for their courses
            $courseIds = $user->teachingCourses()->pluck('id');
            $enrollments = Enrollment::whereIn('course_id', $courseIds)
                ->with(['student', 'course'])
                ->get();
        }

        return response()->json([
            'enrollments' => $enrollments,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = $request->user();

        if (!$user->isStudent()) {
            return response()->json([
                'message' => 'Only students can enroll in courses',
            ], 403);
        }

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'message' => 'Already enrolled in this course',
                'enrollment' => $existingEnrollment,
            ], 409);
        }

        $enrollment = Enrollment::create([
            'student_id' => $user->id,
            'course_id' => $request->course_id,
            'status' => Enrollment::STATUS_PENDING,
        ]);

        return response()->json([
            'message' => 'Enrollment request submitted successfully',
            'enrollment' => $enrollment->load(['course', 'student']),
        ], 201);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json([
            'enrollment' => $enrollment->load(['student', 'course']),
        ]);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,denied',
        ]);

        $user = $request->user();

        // Only admins can approve/deny enrollments
        if (!$user->isAdmin()) {
            return response()->json([
                'message' => 'Only admins can update enrollment status',
            ], 403);
        }

        $enrollment->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Enrollment status updated successfully',
            'enrollment' => $enrollment->load(['student', 'course']),
        ]);
    }

    public function destroy(Enrollment $enrollment)
    {
        $user = request()->user();

        // Students can only delete their own enrollments, admins can delete any
        if (!$user->isAdmin() && $enrollment->student_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $enrollment->delete();

        return response()->json([
            'message' => 'Enrollment deleted successfully',
        ]);
    }

    public function myEnrollments(Request $request)
    {
        $user = $request->user();

        if (!$user->isStudent()) {
            return response()->json([
                'message' => 'Only students have enrollments',
            ], 403);
        }

        $enrollments = $user->enrollments()->with('course')->get();

        return response()->json([
            'enrollments' => $enrollments,
        ]);
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();

        if (!$user->isStudent()) {
            return response()->json([
                'message' => 'Only students have enrolled courses',
            ], 403);
        }

        $courses = $user->enrolledCourses()->with('teacher')->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }
}