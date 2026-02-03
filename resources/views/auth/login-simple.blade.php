<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                    Sign in to D-Learning
                </h2>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Login as:</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex items-center">
                                <input type="radio" name="role" value="student" class="mr-2" checked>
                                <span class="text-sm">Student</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="role" value="teacher" class="mr-2">
                                <span class="text-sm">Teacher</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="role" value="admin" class="mr-2">
                                <span class="text-sm">Admin</span>
                            </label>
                        </div>
                    </div>

                    <!-- Demo Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Demo Accounts:</h4>
                        <p class="text-xs text-blue-600">Student: student1@lms.com</p>
                        <p class="text-xs text-blue-600">Teacher: teacher1@lms.com</p>
                        <p class="text-xs text-blue-600">Admin: admin@lms.com</p>
                        <p class="text-xs text-blue-600">Password: password</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Sign in
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-500">
                            Don't have an account? Sign up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>