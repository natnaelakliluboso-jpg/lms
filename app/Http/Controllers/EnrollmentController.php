<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();

        if (!$user->isStudent()) {
            return redirect()->back()->with('error', 'Only students can enroll in courses.');
        }

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('info', 'You have already requested enrollment in this course.');
        }

        Enrollment::create([
            'student_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Enrollment request submitted! Please wait for admin approval.');
    }

    public function approve(Enrollment $enrollment)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $enrollment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Enrollment approved successfully!');
    }

    public function deny(Enrollment $enrollment)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $enrollment->update(['status' => 'denied']);

        return redirect()->back()->with('success', 'Enrollment denied.');
    }
}