<x-startuse-layout>
    <div class="py-12">
<div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">

            <div class="flex justify-center mb-8">
                        <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </div>

            <div class="text-center mb-8">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
                    Welcome to {{ config('app.name', 'Laravel') }}
                </h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    Please log in or register to continue.
                </p>
            </div>

            <div class="flex justify-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                            class="rounded-md px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                            class="rounded-md px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 transition">
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                                class="rounded-md px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</x-startuse-layout>