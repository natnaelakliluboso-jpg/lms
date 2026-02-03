<div class="shadow-xl rounded-lg shadow-slate-600 overflow-hidden hover:shadow-slate-900">
    <a href="{{ route('courses.show', $course->id) }}" class="group">
        <div class='aspect-h-1 aspect-w-1 w-full overflow-hidden'>
            <div class="h-64 w-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <h3 class="text-white text-xl font-bold text-center px-4">{{ $course->title }}</h3>
            </div>
        </div>

        <div class="px-6 py-2">
            <x-courses.card-content :course="$course" />
        </div>
    </a>
</div>
