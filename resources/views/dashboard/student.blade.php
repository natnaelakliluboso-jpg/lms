@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Student Dashboard</h1>
                
                @php
                    $enrolledCourses = $enrolledCourses ?? collect();
                    $myGrades = $myGrades ?? collect();
                    $averageGrade = $myGrades->count() > 0 ? $myGrades->avg('grade') : 0;
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">My Courses</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $enrolledCourses->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Completed Assignments</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $myGrades->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-900 mb-2">Average Grade</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $averageGrade > 0 ? number_format($averageGrade, 1) : '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8">
                    <!-- Available Courses -->
                    <div class="bg-white border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">📚 Available Courses</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($availableCourses as $course)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <h3 class="font-semibold text-lg mb-2">
                                        {{ $course->title }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($course->description, 120) }}</p>
                                    <p class="text-sm text-gray-500 mb-3">👨‍🏫 {{ $course->teacher ? $course->teacher->name : 'Not assigned' }}</p>
                                    
                                    @php
                                        $isEnrolled = auth()->user()->enrollments()->where('course_id', $course->id)->exists();
                                    @endphp
                                    
                                    @if($isEnrolled)
                                        @php
                                            $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();
                                        @endphp
                                        @if($enrollment->status === 'pending')
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                                                ⏳ Pending Approval
                                            </span>
                                        @elseif($enrollment->status === 'approved')
                                            <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">✓ Enrolled</span>
                                            <div class="mt-2">
                                                <a href="{{ route('student.courses.show', $course->slug) }}"
                                                   class="text-sm text-blue-600 hover:underline">
                                                    View course & resources
                                                </a>
                                            </div>

                                        @else
                                            <span class="inline-block bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">❌ Denied</span>
                                        @endif
                                    @else
                                        <form method="POST" action="{{ route('enrollment.store', $course) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm font-medium transition-colors">
                                                📚 Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <p class="text-gray-500 text-lg">No courses available</p>
                                    <p class="text-gray-400 text-sm">Check back later for new courses!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- My Enrolled Courses -->
                    @if($enrolledCourses->count() > 0)
                    <div class="bg-white border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">🎓 My Enrolled Courses</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($enrolledCourses as $course)
                                <a href="{{ route('student.courses.show', $course->slug) }}"
                                   class="border rounded-lg p-4 bg-green-50 border-green-200 block hover:shadow-md transition-shadow">
                                    <h3 class="font-semibold text-lg mb-2">{{ $course->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($course->description, 100) }}</p>
                                    <p class="text-sm text-gray-500 mb-2">👨‍🏫 {{ $course->teacher ? $course->teacher->name : 'Not assigned' }}</p>
                                    <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">✓ Enrolled</span>
                                </a>
                            @endforeach

                        </div>
                    </div>
                    @endif
                </div>

                <!-- Recent Grades -->
                <div class="mt-8 bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Recent Grades</h2>
                    <div class="overflow-x-auto">
                        @if($myGrades->count() > 0)
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left">Course</th>
                                        <th class="px-4 py-2 text-left">Assignment</th>
                                        <th class="px-4 py-2 text-left">Grade</th>
                                        <th class="px-4 py-2 text-left">Comments</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myGrades->sortByDesc('created_at')->take(10) as $grade)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">{{ $grade->course->title }}</td>
                                            <td class="px-4 py-2">{{ $grade->assignment_name }}</td>
                                            <td class="px-4 py-2">{{ $grade->grade }}/{{ $grade->max_grade }}</td>
                                            <td class="px-4 py-2">{{ $grade->comments ?: '-' }}</td>
                                            <td class="px-4 py-2">{{ $grade->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500">No grades available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection