<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @include('files.partials.notification-info')
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex max-w-xl items-center">
                    @include('files.partials.upload-files-form')
                @if ($files->isNotEmpty())
                    <div class="flex items-center">
                        <x-input-label for="extension" class="ml-4 mr-4">Filter by Extension:</x-input-label>
                        <select name="extension" id="extension" onchange="fileFilter()"
                            class="border border-gray-300 rounded px-8 bg-white text-black dark:bg-gray-800 dark:text-white dark:border-gray-600">
                            <option class="text-black dark:text-white" value="">All</option>
                            @foreach ($files as $extension)
                                {{ $extension_name = pathinfo($extension->path, PATHINFO_EXTENSION) }}
                                <option class="text-black dark:text-white" value="{{ $extension_name }}">
                                    {{ $extension_name }}</option>
                            @endforeach
                        </select>

                    </div>
                @endif
                </div>

            </div>

            <div class="mt-4">{{ $files->links() }}</div>

            <div class="block sm:flex sm:flex-wrap gap-4">
                @if ($files->isEmpty())
                    <div
                        class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                        <p>No files available.</p>
                        <p>Start uploading files to this amazing app</p>
                    </div>
                @else
                    @foreach ($files as $file)
                        <div class="file-item sm:flex-2 block items-center justify-between mt-3"
                            data-extension="{{ pathinfo($file->path, PATHINFO_EXTENSION) }}">
                            <div
                                class="flex justify-between bg-gray-800 dark:bg-gray-500 p-3 rounded-lg text-white font-semibold dark:hover:!bg-gray-700 hover:bg-gray-400 hover:text-black dark:hover:text-white">
                                <p>{{ basename($file->path) }}</p>

                                <x-dropdown width="32">
                                    <x-slot name="trigger">
                                        <div class="ms-1 cursor-pointer">
                                            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="2" />
                                                <circle cx="12" cy="12" r="2" />
                                                <circle cx="12" cy="19" r="2" />
                                            </svg>
                                        </div>
                                    </x-slot>

                                    <x-slot name="content">
                                        @include('files.partials.download-files-form')

                                        <x-dropdown-link class="cursor-pointer" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', '{{ basename($file->path) }}')">
                                            <i class="fa-solid fa-user-plus mr-2"></i>{{ 'Share' }}
                                        </x-dropdown-link>

                                        @include('files.partials.delete-files-form')
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    @endforeach
                @endif

                @foreach ($files as $file => $data)
                    @include('files.partials.share-files-form')
                @endforeach

                @foreach ($files as $file => $data )
                    @include('files.partials.delete-files-confirmation')
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
