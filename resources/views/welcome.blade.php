<x-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome to D-Learning Management System</h1>
            <p class="text-xl mb-8">Your complete Learning Management System for modern education</p>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">System Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="text-4xl mb-4">👨‍🎓</div>
                    <h3 class="text-xl font-semibold mb-2">For Students</h3>
                    <p class="text-gray-600">Enroll in courses, track progress, and view grades</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="text-4xl mb-4">👨‍🏫</div>
                    <h3 class="text-xl font-semibold mb-2">For Teachers</h3>
                    <p class="text-gray-600">Manage courses, assign grades, and track student progress</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="text-4xl mb-4">👨‍💼</div>
                    <h3 class="text-xl font-semibold mb-2">For Admins</h3>
                    <p class="text-gray-600">Approve enrollments, create courses, and manage users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Accounts -->
    @guest
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Demo Accounts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg shadow text-center border border-blue-200">
                    <div class="text-3xl mb-4">👨‍💼</div>
                    <h3 class="text-xl font-semibold mb-4 text-blue-600">Admin</h3>
                    <p class="text-sm text-gray-600 mb-2">Email: admin@lms.com</p>
                    <p class="text-sm text-gray-600 mb-4">Password: password</p>
                    <p class="text-xs text-gray-500">Manage the entire system</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg shadow text-center border border-green-200">
                    <div class="text-3xl mb-4">👨‍🏫</div>
                    <h3 class="text-xl font-semibold mb-4 text-green-600">Teacher</h3>
                    <p class="text-sm text-gray-600 mb-2">Email: teacher1@lms.com</p>
                    <p class="text-sm text-gray-600 mb-4">Password: password</p>
                    <p class="text-xs text-gray-500">Assign grades and manage courses</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg shadow text-center border border-purple-200">
                    <div class="text-3xl mb-4">👨‍🎓</div>
                    <h3 class="text-xl font-semibold mb-4 text-purple-600">Student</h3>
                    <p class="text-sm text-gray-600 mb-2">Email: student1@lms.com</p>
                    <p class="text-sm text-gray-600 mb-4">Password: password</p>
                    <p class="text-xs text-gray-500">Enroll in courses and view grades</p>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <!-- Call to Action -->
    <div class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
            <p class="text-xl mb-8">Join thousands of students and teachers in our learning community</p>
            @guest
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">
                    Create Account
                </a>
            @endguest
        </div>
    </div>
</x-layout>
