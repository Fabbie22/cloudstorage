<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shared') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @foreach ($shared_with_me as $share)
                        <p class="text-white">{{ $share->file->file_name }}</p>
                        <p class="text-white">Shared with: {{ $share->recipient_email }}</p>
                        <p class="text-white">{{ $share->file->path }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
