@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>
                
                @php
                    $totalCourses = \App\Models\Course::count();
                    $totalStudents = \App\Models\User::where('role', 'student')->count();
                    $totalTeachers = \App\Models\User::where('role', 'teacher')->count();
                    $pendingEnrollments = \App\Models\Enrollment::where('status', 'pending')->count();
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Total Courses</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalCourses }}</p>
                    </div>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Total Students</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $totalStudents }}</p>
                    </div>
                    <div class="bg-yellow-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-900 mb-2">Pending Enrollments</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingEnrollments }}</p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-900 mb-2">Total Teachers</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalTeachers }}</p>
                    </div>
                </div>

                <!-- Pending Enrollments Section -->
                @if($pendingEnrollments > 0)
                <div class="mb-8 bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-yellow-600">⚠️ Pending Enrollment Requests ({{ $pendingEnrollments }})</h2>
                    <div class="space-y-4">
                        @php
                            $pendingEnrollmentsList = \App\Models\Enrollment::where('status', 'pending')->with(['student', 'course'])->get();
                        @endphp
                        
                        @foreach($pendingEnrollmentsList as $enrollment)
                            <div class="border rounded-lg p-4 flex justify-between items-center bg-yellow-50 border-yellow-200">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ substr($enrollment->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $enrollment->student->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $enrollment->student->email }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-1">wants to enroll in: <strong class="text-blue-600">{{ $enrollment->course->title }}</strong></p>
                                    <p class="text-xs text-gray-500">Requested: {{ $enrollment->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <form method="POST" action="{{ route('admin.enrollment.approve', $enrollment->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.enrollment.deny', $enrollment->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Deny
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mb-8 bg-white border rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-green-600">✅ No Pending Enrollment Requests</h2>
                    <p class="text-gray-600">All enrollment requests have been processed.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection