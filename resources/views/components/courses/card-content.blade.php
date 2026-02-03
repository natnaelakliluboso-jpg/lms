<div>
    <h3 class="mt-4 text-md font-semibold text-gray-700">{{ $course->title }}</h3>

    <div class="mt-2">
        <p class="text-sm text-gray-600">
            <strong>Instructor:</strong> {{ $course->teacher ? $course->teacher->name : 'Not assigned' }}
        </p>
    </div>

    <div class="mt-2">
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold 
                     {{ $course->status === 'enabled' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ ucfirst($course->status) }}
        </span>
    </div>

    <div class="mt-3">
        <p class="text-sm text-gray-600 line-clamp-3">
            {{ Str::limit(strip_tags($course->description), 100) }}
        </p>
    </div>
</div>
{{ $slot }}
