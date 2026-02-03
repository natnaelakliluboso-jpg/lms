<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
                    
                    <div class="mb-6">
                        <p class="text-gray-600 mb-2">
                            <strong>Instructor:</strong> {{ $course->teacher ? $course->teacher->name : 'Not assigned' }}
                        </p>
                        <p class="text-gray-600 mb-4">
                            <strong>Status:</strong> 
                            <span class="px-2 py-1 text-xs rounded {{ $course->status === 'enabled' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="prose max-w-none mb-8">
                        <h2 class="text-xl font-semibold mb-4">Course Description</h2>
                        <div class="text-gray-700">
                            {!! $course->description !!}
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isStudent())
                            <div class="text-center">
                                <button onclick="enrollInCourse({{ $course->id }})" 
                                        class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                    Enroll in Course
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <a href="{{ route('login') }}" 
                               class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold inline-block">
                                Login to Enroll
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <script>
        async function enrollInCourse(courseId) {
            const token = localStorage.getItem('auth_token');
            
            if (!token) {
                alert('Please login first');
                window.location.href = '/login';
                return;
            }

            try {
                const response = await fetch('/api/enrollments', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ course_id: courseId })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Enrollment request submitted successfully! Please wait for admin approval.');
                } else {
                    alert(data.message || 'Error enrolling in course');
                }
            } catch (error) {
                console.error('Error enrolling:', error);
                alert('Error enrolling in course');
            }
        }
    </script>
</x-layout>
