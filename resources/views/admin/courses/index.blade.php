<x-admin.layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="bg-white">
        <div class="container mx-auto">
            <!-- ADD COURSE -->
            <div class="flex gap-4 justify-end mb-2">
                <a href="{{ route('admin.courses.create') }}"
                    class="bg-green-500 hover:bg-green-700 px-4 py-2 ont-semibold text-xs text-white uppercase rounded-lg">Add</a>
            </div>
            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="w-full border break-words text-xs md:text-sm text-left">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">{{ __('ID') }}</th>
                            <th class="px-4 py-2">{{ __('Title') }}</th>
                            <th class="px-4 py-2">{{ __('Slug') }}</th>
                            <th class="px-4 py-2">{{ __('Teacher') }}</th>
                            <th class="px-4 py-2">{{ __('Price') }}</th>
                            <th class="px-4 py-2">{{ __('Level') }}</th>
                            <th class="px-4 py-2">{{ __('Status') }}</th>
                            <th class="px-4 py-2">{{ __('Access') }}</th>
                            <th class="px-4 py-2">{{ __('Duration [min]') }}</th>
                        <th class="px-4 py-2">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
    @php $canEdit = !empty($course->slug); @endphp

    <tr class="odd:bg-white even:bg-gray-200 hover:bg-slate-100 hover:cursor-pointer"
        @if($canEdit)
            onclick="window.location='{{ route('admin.courses.edit', $course->slug) }}';"
        @endif
    >
        <td class="px-4 py-2">{{ $course->id }}</td>
        <td class="px-4 py-2">{{ $course->title }}</td>
        <td class="px-4 py-2">{{ $course->slug ?? '-' }}</td>
        <td class="px-4 py-2">{{ optional($course->teacher)->name }}</td>
        <td class="px-4 py-2">{{ $course->price }}</td>
        <td class="px-4 py-2">{{ $course->level }}</td>
        <td class="px-4 py-2">{{ $course->status }}</td>
        <td class="px-4 py-2">{{ $course->access }}</td>
        <td class="px-4 py-2">{{ $course->duration }}</td>
        <td class="px-4 py-2 text-center">
    <form method="POST"
          action="{{ route('admin.courses.destroy', $course->slug) }}"
          onsubmit="return confirm('Are you sure you want to delete this course?');">
        @csrf
        @method('DELETE')

        <button type="submit" class="text-red-600 hover:text-red-800 font-bold">
            &times; {{-- X icon --}}
        </button>
    </form>
</td>
    </tr>
@endforeach
                    </tbody>
                </table>
                <div class="m-8">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>

<x-flash-message />
