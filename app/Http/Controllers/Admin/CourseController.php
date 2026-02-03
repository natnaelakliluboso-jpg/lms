<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(10);

        $courses->withPath('/admin/courses');

        return view('admin.courses.index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('role', User::ROLE_TEACHER)->get();

        return view('admin.courses.create', [
            'course_levels' => config('enums.course_level'),
            'course_status' => config('enums.course_status'),
            'teachers' => $teachers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'excerpt' => ['required', 'string', 'max:255'],
            'imagePath' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slug' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'audio' => ['required', 'string', 'max:255'],
            'subtitles' => ['required', 'string', 'max:255'],
            'access' => ['required', 'string', 'max:255'],
            'teacher_id' => ['required', 'exists:users,id'],
        ]);

        $fileName = 'thumbnail.' . $request->imagePath->extension();
        $folderPath = public_path('/images/courses/' . $request->slug);

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath);
        }

        $request->imagePath->move($folderPath, $fileName);

        $course = new Course;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->excerpt = $request->excerpt;
        $course->image_path = '/images/courses/' . $request->slug . DIRECTORY_SEPARATOR . $fileName;
        $course->slug = $request->slug;
        $course->price = $request->price;
        $course->level = $request->level;
        $course->status = strtolower($request->status);
        $course->audio = $request->audio;
        $course->subtitles = $request->subtitles;
        $course->access = $request->access;
        $course->teacher_id = $request->teacher_id;

        //dd($course, $request);

        $course->save();

        return Redirect::route('dashboard')->with('message', 'Course created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::where('slug', $id)->first();

        $lessons = $course->lessons()->paginate(10);

        $teachers = User::where('role', User::ROLE_TEACHER)->get();

        return view('admin.courses.edit', [
            'course' => $course,
            'lessons' => $lessons,
            'course_levels' => config('enums.course_level'),
            'course_status' => config('enums.course_status'),
            'teachers' => $teachers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'excerpt' => ['required', 'string', 'max:255'],
            'imagePath' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slug' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'audio' => ['required', 'string', 'max:255'],
            'subtitles' => ['required', 'string', 'max:255'],
            'teacher_id' => ['required', 'exists:users,id'],
        ]);

        $course = Course::where('slug', $id)->first();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->excerpt = $request->excerpt;

        if ($request->hasFile('imagePath')) {
            $fileName = 'thumbnail.' . $request->imagePath->extension();
            $folderPath = public_path('/images/courses/' . $request->slug);
            $request->imagePath->move($folderPath, $fileName);

            $course->image_path = '/images/courses/' . $request->slug . DIRECTORY_SEPARATOR . $fileName;
        }

        $course->slug = $request->slug;
        $course->price = $request->price;
        $course->level = $request->level;
        $course->status = strtolower($request->status);
        $course->audio = $request->audio;
        $course->subtitles = $request->subtitles;
        $course->access = $request->access;

        $course->save();

        return Redirect::route('admin.courses')->with('message', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::where('slug', $id)->first();
        // First detach any user that was enrolled on the course
        // $course->users()->detach();
        // Then delete the course
        $course->delete();

        // Delete folder with thumbnail image in the public/courses folder
        $folderPath = public_path('/images/courses/' . $course->slug);

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        return Redirect::route('dashboard')->with('message', 'Course deleted successfully');
    }
}
