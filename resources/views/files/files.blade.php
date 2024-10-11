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

                                <form action="{{ route('files.download') }}" method="POST">
                                    @csrf
                                    <p>{{ $file->file_name }}</p>
                                    <input type="hidden" name="path" value="{{ $file->path }}">
                                    <input type="hidden" name="file_name" value="{{ $file->file_name }}">
                                </form>

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
                                        <form action="{{ route('files.download') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="path" value="{{ $file->path }}">
                                            <input type="hidden" name="file_name" value="{{ $file->file_name }}">

                                            <x-dropdown-link :href="route('files.download')"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class="fas fa-download mr-2"></i>{{ __('Download') }}
                                            </x-dropdown-link>
                                        </form>

                                        <x-dropdown-link>
                                            <i class="fa-solid fa-user-plus mr-2"></i>Share
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('files.delete', $file->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="path" value="{{ $file->path }}">

                                            <x-dropdown-link :href="route('files.delete', $file->id)"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>

                                    </x-slot>
                                </x-dropdown>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
