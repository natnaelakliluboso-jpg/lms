@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">
        Resources for: {{ $course->title }}
    </h1>

    {{-- Flash message --}}
    @if(session('message'))
        <div class="mb-4 text-green-600">
            {{ session('message') }}
        </div>
    @endif

    {{-- Add resource form --}}
    <div class="mb-8 bg-white p-4 rounded shadow">
        <form method="POST" action="{{ route('teacher.courses.resources.store', $course) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Type</label>
                <select name="type" id="resource-type" class="w-full border rounded px-3 py-2" required>
                    <option value="file">File (PDF/Word)</option>
                    <option value="link">External link</option>
                </select>
                @error('type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div id="file-input-wrapper">
                <label class="block text-sm font-medium mb-1">File</label>
                <input type="file" name="file" class="w-full border rounded px-3 py-2">
                @error('file') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div id="url-input-wrapper" class="hidden">
                <label class="block text-sm font-medium mb-1">URL</label>
                <input type="url" name="url" class="w-full border rounded px-3 py-2" placeholder="https://example.com/resource">
                @error('url') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Resource
            </button>
        </form>
    </div>

    {{-- Existing resources --}}
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-3">Existing Resources</h2>

        @if($resources->isEmpty())
            <p class="text-gray-500">No resources yet.</p>
        @else
            <ul class="space-y-2">
                @foreach($resources as $resource)
                    <li class="flex items-center justify-between border-b pb-2">
                        <div>
                            <p class="font-medium">{{ $resource->title }}</p>
                            @if($resource->type === 'file')
                                <a href="{{ asset('storage/'.$resource->file_path) }}" class="text-blue-600 text-sm" target="_blank">
                                    Download file
                                </a>
                            @else
                                <a href="{{ $resource->url }}" class="text-blue-600 text-sm" target="_blank">
                                    Open link
                                </a>
                            @endif
                        </div>
                        <form method="POST"
                              action="{{ route('teacher.courses.resources.destroy', [$course, $resource]) }}"
                              onsubmit="return confirm('Delete this resource?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold">
                                &times;
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

{{-- Very simple JS toggle --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('resource-type');
    const fileWrapper = document.getElementById('file-input-wrapper');
    const urlWrapper = document.getElementById('url-input-wrapper');

    function toggleInputs() {
        if (typeSelect.value === 'file') {
            fileWrapper.classList.remove('hidden');
            urlWrapper.classList.add('hidden');
        } else {
            fileWrapper.classList.add('hidden');
            urlWrapper.classList.remove('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleInputs);
    toggleInputs();
});
</script>
@endsection