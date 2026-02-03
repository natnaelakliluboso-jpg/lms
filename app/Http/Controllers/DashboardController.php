<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return view('dashboard.admin');
        } elseif ($user->isTeacher()) {
            return view('dashboard.teacher');
        } else {
            // Student dashboard - load available courses
            $availableCourses = Course::where('status', 'enabled')->with('teacher')->get();
            $enrolledCourses = $user->enrolledCourses;
            $myGrades = $user->grades;
            
            return view('dashboard.student', compact('availableCourses', 'enrolledCourses', 'myGrades'));
        }
    }
}