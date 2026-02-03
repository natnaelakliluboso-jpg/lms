@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Teacher Dashboard</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">My Courses</h3>
                        <p class="text-3xl font-bold text-blue-600" id="my-courses-count">{{ auth()->user()->teachingCourses->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Total Students</h3>
                        <p class="text-3xl font-bold text-green-600" id="total-students">0</p>
                    </div>
                    <div class="bg-yellow-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-900 mb-2">Assignments Graded</h3>
                        <p class="text-3xl font-bold text-yellow-600" id="assignments-graded">{{ auth()->user()->teachingCourses->sum(function($course) { return $course->grades->count(); }) }}</p>
                    </div>
                </div>

                <!-- My Courses -->
                <div class="mb-8 bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">📚 My Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse(auth()->user()->teachingCourses as $course)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h3 class="font-semibold text-lg mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($course->description, 120) }}</p>
                                
                                @php
                                    $approvedStudents = $course->students; // This gets approved students only
                                    $pendingCount = $course->enrollments()->where('status', 'pending')->count();
                                @endphp
                                
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm text-blue-600">👥 {{ $approvedStudents->count() }} Students</span>
                                    @if($pendingCount > 0)
                                        <span class="text-sm text-yellow-600">⏳ {{ $pendingCount }} Pending</span>
                                    @endif
                                </div>

                                <div class="mt-4 flex justify-end">
    <a href="{{ route('teacher.courses.resources.index', $course) }}"
       class="text-sm text-blue-600 hover:underline">
        Manage resources
    </a>
</div>
                                
                                @if($approvedStudents->count() > 0)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500 mb-2">Enrolled Students:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($approvedStudents->take(4) as $student)
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $student->name }}</span>
                                            @endforeach
                                            @if($approvedStudents->count() > 4)
                                                <span class="text-xs text-gray-500 px-2 py-1">+{{ $approvedStudents->count() - 4 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No enrolled students yet</p>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">No courses assigned</p>
                                <p class="text-gray-400 text-sm">Contact admin to get courses assigned to you</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Simple Grade Assignment Form -->
                <div class="mb-8 bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Assign Grade</h2>
                    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select name="course_id" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Course</option>
                                @foreach(auth()->user()->teachingCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Email</label>
                            <input type="email" name="student_email" class="w-full border rounded px-3 py-2" placeholder="student@example.com" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assignment Name</label>
                            <input type="text" name="assignment_name" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Grade / Max Grade</label>
                            <div class="flex space-x-2">
                                <input type="number" name="grade" class="w-full border rounded px-3 py-2" step="0.01" required>
                                <span class="self-center">/</span>
                                <input type="number" name="max_grade" class="w-full border rounded px-3 py-2" step="0.01" value="100" required>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
                            <textarea name="comments" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                                Assign Grade
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Recent Grades -->
                <div class="bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Recent Grades</h2>
                    <div class="overflow-x-auto">
                        @php
                            $recentGrades = auth()->user()->teachingCourses->flatMap->grades->sortByDesc('created_at')->take(10);
                        @endphp
                        
                        @if($recentGrades->count() > 0)
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left">Student</th>
                                        <th class="px-4 py-2 text-left">Course</th>
                                        <th class="px-4 py-2 text-left">Assignment</th>
                                        <th class="px-4 py-2 text-left">Grade</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentGrades as $grade)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">{{ $grade->student->name }}</td>
                                            <td class="px-4 py-2">{{ $grade->course->title }}</td>
                                            <td class="px-4 py-2">{{ $grade->assignment_name }}</td>
                                            <td class="px-4 py-2">{{ $grade->grade }}/{{ $grade->max_grade }}</td>
                                            <td class="px-4 py-2">{{ $grade->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500">No grades assigned yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection