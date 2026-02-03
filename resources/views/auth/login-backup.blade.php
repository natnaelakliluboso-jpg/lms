<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-white">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                    Sign in to D-Learning
                </h2>
                <p class="mt-2 text-center text-sm text-blue-100">
                    Choose your role and access your dashboard
                </p>
            </div>

            <!-- Role Selection Tabs -->
            <div class="bg-white rounded-lg p-1 grid grid-cols-3 gap-1 mb-4">
                <label class="role-tab-label">
                    <input type="radio" name="role" value="student" class="sr-only role-radio" checked>
                    <span class="role-tab-span px-3 py-2 text-sm font-medium rounded-md text-center transition-colors cursor-pointer bg-blue-600 text-white">
                        Student
                    </span>
                </label>
                <label class="role-tab-label">
                    <input type="radio" name="role" value="teacher" class="sr-only role-radio">
                    <span class="role-tab-span px-3 py-2 text-sm font-medium rounded-md text-center transition-colors cursor-pointer text-gray-500 hover:text-gray-700">
                        Teacher
                    </span>
                </label>
                <label class="role-tab-label">
                    <input type="radio" name="role" value="admin" class="sr-only role-radio">
                    <span class="role-tab-span px-3 py-2 text-sm font-medium rounded-md text-center transition-colors cursor-pointer text-gray-500 hover:text-gray-700">
                        Admin
                    </span>
                </label>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Demo Account Info -->
                    <div id="demo-info" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Demo Account:</h4>
                        <p class="text-sm text-blue-600" id="demo-email">student1@lms.com</p>
                        <p class="text-sm text-blue-600">Password: password</p>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('email') }}" placeholder="Enter your email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Sign in
                        </button>
                    </div>

                    <div class="text-center">
                        <span class="text-sm text-gray-600">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium ml-1">
                            Sign up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const demoAccounts = {
            student: 'student1@lms.com',
            teacher: 'teacher1@lms.com',
            admin: 'admin@lms.com'
        };

        // Handle role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('.role-radio');
            const demoEmail = document.getElementById('demo-email');
            const emailInput = document.getElementById('email');

            roleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Update visual state
                    document.querySelectorAll('.role-tab-span').forEach(span => {
                        span.classList.remove('bg-blue-600', 'text-white');
                        span.classList.add('text-gray-500', 'hover:text-gray-700');
                    });
                    
                    this.parentElement.querySelector('.role-tab-span').classList.remove('text-gray-500', 'hover:text-gray-700');
                    this.parentElement.querySelector('.role-tab-span').classList.add('bg-blue-600', 'text-white');
                    
                    // Update demo info
                    const role = this.value;
                    demoEmail.textContent = demoAccounts[role];
                    emailInput.value = demoAccounts[role];
                });
            });

            // Set initial demo email
            emailInput.value = demoAccounts.student;
        });
    </script>
</x-layout>
