<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-col">
                            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center justify-center">Hello, {{Auth::User()->name}}!</h1>
                            <div class="flex items-center justify-center mt-3">
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="w-20 h-20 object-cover rounded-full">
                            </div>
                            <h1 class="font-semibold text-m text-gray-800 dark:text-gray-200 leading-tight mt-4 flex items-center justify-center">This is Lab 7 Laravel!</h1>
                            <p class="flex items-center justify-center">{{ __("You're logged in!") }}</p>
                        </div>
            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>