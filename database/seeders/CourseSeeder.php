<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teacher1 = User::where('email', 'teacher1@lms.com')->first();
        $teacher2 = User::where('email', 'teacher2@lms.com')->first();

        Course::create([
            'title' => 'Introduction to Web Development',
            'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript. This comprehensive course will take you from beginner to intermediate level.',
            'teacher_id' => $teacher1->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Advanced PHP Programming',
            'description' => 'Master advanced PHP concepts including OOP, design patterns, and framework development. Perfect for developers looking to enhance their PHP skills.',
            'teacher_id' => $teacher1->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Database Design and Management',
            'description' => 'Learn how to design, implement, and manage databases effectively. Covers SQL, normalization, and database optimization techniques.',
            'teacher_id' => $teacher2->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Mobile App Development',
            'description' => 'Build mobile applications for iOS and Android platforms. Learn React Native and cross-platform development strategies.',
            'teacher_id' => $teacher2->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Python for Data Science',
            'description' => 'Discover the power of Python for data analysis, machine learning, and visualization. Learn pandas, numpy, matplotlib, and scikit-learn through practical projects.',
            'teacher_id' => $teacher1->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Digital Marketing Fundamentals',
            'description' => 'Master the essentials of digital marketing including SEO, social media marketing, content strategy, and analytics. Perfect for beginners and business owners.',
            'teacher_id' => $teacher2->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Graphic Design with Adobe Creative Suite',
            'description' => 'Learn professional graphic design using Photoshop, Illustrator, and InDesign. Create stunning visuals, logos, and marketing materials from scratch.',
            'teacher_id' => $teacher1->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Cybersecurity Essentials',
            'description' => 'Understand the fundamentals of cybersecurity, network security, ethical hacking, and how to protect systems from cyber threats in today\'s digital world.',
            'teacher_id' => $teacher2->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Project Management Professional',
            'description' => 'Learn project management methodologies, tools, and techniques. Prepare for PMP certification while gaining practical skills to lead successful projects.',
            'teacher_id' => $teacher1->id,
            'status' => 'enabled',
        ]);

        Course::create([
            'title' => 'Machine Learning Fundamentals',
            'description' => 'Introduction to machine learning algorithms, supervised and unsupervised learning, neural networks, and practical applications using Python and TensorFlow.',
            'teacher_id' => $teacher2->id,
            'status' => 'enabled',
        ]);
    }
}
