<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class TestEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::where('status', 'enabled')->get();

        if ($students->count() > 0 && $courses->count() > 0) {
            // Create some test enrollments
            foreach ($students->take(3) as $student) {
                foreach ($courses->take(2) as $course) {
                    // Check if enrollment already exists
                    $exists = Enrollment::where('student_id', $student->id)
                        ->where('course_id', $course->id)
                        ->exists();
                    
                    if (!$exists) {
                        Enrollment::create([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'status' => 'pending'
                        ]);
                    }
                }
            }
        }
    }
}