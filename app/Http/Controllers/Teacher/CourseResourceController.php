<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CourseResourceController extends Controller
{
    public function index(Request $request, Course $course)
    {
        $user = $request->user();

        // Only the teacher of this course (or admin) can manage resources
        if (! $user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403);
        }

        $resources = $course->resources()->latest()->get();

        return view('teacher.courses.resources', compact('course', 'resources'));
    }

    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        if (! $user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type'  => ['required', 'in:file,link'],
            'file'  => ['required_if:type,file', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'url'   => ['required_if:type,link', 'url'],
        ]);

        $data = [
            'course_id'  => $course->id,
            'created_by' => $user->id,
            'title'      => $request->title,
            'type'       => $request->type,
        ];

        if ($request->type === 'file' && $request->hasFile('file')) {
            $path = $request->file('file')->store("course-resources/{$course->id}", 'public');
            $data['file_path'] = $path;
        }

        if ($request->type === 'link') {
            $data['url'] = $request->url;
        }

        CourseResource::create($data);

        return Redirect::route('teacher.courses.resources.index', $course)
            ->with('message', 'Resource added successfully.');
    }

    public function destroy(Request $request, Course $course, CourseResource $resource)
    {
        $user = $request->user();

        if (! $user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403);
        }

        // Ensure resource belongs to this course
        if ($resource->course_id !== $course->id) {
            abort(404);
        }

        if ($resource->type === 'file' && $resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return Redirect::route('teacher.courses.resources.index', $course)
            ->with('message', 'Resource deleted successfully.');
    }
}