<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel LMS') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">D-Learning Management System</h1>
            <div class="space-x-4">
                @auth
                    <span>Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-500 px-4 py-2 rounded hover:bg-green-700">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Set up CSRF token for API calls
        window.axios = {
            defaults: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        };
    </script>
</body>
</html>