<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('courses.index', [
            'courses' => Course::where('status', 'enabled')->with('teacher')->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        if ($course->status !== 'enabled') {
            abort(404);
        }

        return view('courses.show', [
            'course' => $course->load('teacher'),
        ]);
    }
}
