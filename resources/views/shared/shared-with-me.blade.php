<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shared with me') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @if ($shared_with_me->isEmpty())
                <div
                    class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                    <p>No files available.</p>
                    <p>When people share with you, you will see files!</p>
                </div>
            @else
                <table class="min-w-full table-auto rounded-lg shadow">
                    <thead class="bg-gray-800 dark:bg-gray-500 text-white font-semibold rounded-t-lg">
                        <tr class="bg-gray-800 dark:bg-gray-500 text-white font-semibold">
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Shared At</th>
                            <th class="p-3 text-left">Shared By</th>
                            <th class="p-3 text-left">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="5" r="2" />
                                    <circle cx="12" cy="12" r="2" />
                                    <circle cx="12" cy="19" r="2" />
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shared_with_me as $shared => $data)
                            <tr class="bg-gray-800 dark:bg-gray-500 text-white hover:!bg-gray-700">
                                <td class="p-3">{{ basename($data->file->path) }}</td>
                                <td class="p-3">{{ $data->created_at->format('d-m-Y') }}</td>
                                <td class="p-3">{{ $data->owner_email }}</td>
                                <td class="p-3 text-right">
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
                                            @include('shared.partials.download-shared-files-form')
                                        </x-slot>
                                    </x-dropdown>
                                </td>
                            </tr>
                    </tbody>
            @endforeach
            </table>
            @endif
        </div>
    </div>

</x-app-layout>
