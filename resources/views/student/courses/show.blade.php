<x-student.layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overview') }}
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <x-courses.course-overview :course=$course :lessons=$lessons />
            </div>
            @if(isset($resources) && $resources->isNotEmpty())
                <div class="mt-6 bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Course Resources') }}</h3>
                    <ul class="space-y-2">
                        @foreach($resources as $resource)
                            <li class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <p class="font-medium">{{ $resource->title }}</p>
                                    @if($resource->type === 'file')
                                        <a href="{{ asset('storage/'.$resource->file_path) }}" class="text-blue-600 text-sm" target="_blank">
                                            {{ __('Download file') }}
                                        </a>
                                    @else
                                        <a href="{{ $resource->url }}" class="text-blue-600 text-sm" target="_blank">
                                            {{ __('Open link') }}
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-student.layout>
