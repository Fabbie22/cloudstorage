<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('files.partials.upload-files-form')
                        </div>
                    </div>
            @if ($files->isEmpty())
                <p>No files available.</p>
            @else
                @foreach ($files as $file)
                    <div class="flex items-center justify-between">
                        <p>{{ $file->path }}</p>
                        <form action="{{ route('files.delete', $file->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
