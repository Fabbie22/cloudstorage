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
            <div class="flex flex-wrap gap-4">
                @if ($files->isEmpty())
                    <div
                        class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                        <p>No files available.</p>
                        <p>Start uploading files to this amazing app</p>
                    </div>
                @else
                    @foreach ($files as $file)
                        <div class="flex-2 items-center justify-between mt-3">
                            <div
                                class="flex justify-between bg-gray-800 dark:bg-gray-500 p-3 rounded-lg text-white font-semibold">

                                <p>{{ $file->file_name }}</p>
                                {{$file->id}}

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

                                        <x-dropdown-link x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', {{ $file->id }})">
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

            </div>
        </div>
    </div>
</x-app-layout>
