<x-app-layout>
    <x-slot name="header">
        @if (auth()->user()->hasRole(1))
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Statistics Dashboard') }}
            </h2>
        @else
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            <div class="font-bold text-2xl mb-3">{{ __('Welcome, ' . auth()->user()->name) }}</div>
            @if (auth()->user()->hasRole(1))
                <div class="grid grid-cols-1 w-full sm:grid-cols-2 gap-4">
                    <div><canvas id="registration_chart"
                            class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72 "></canvas></div>
                    <div><canvas id="fileTypesChart" class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72"></canvas>
                    </div>

                    <div class="mt-4"><canvas id="fileAgesChart"
                            class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72"></canvas>
                    </div>
                    <div class="mt-4"><canvas id="savedDeletedChart"
                            class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72"></canvas>
                    </div>
                    <div class="mt-4"><canvas id="fileCountsChart"
                            class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72"></canvas>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        <h2>Total File Size Used: {{ number_format($totalFileSizeMB, 2) }} KB</h2>
                    </div>

                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                        <div class="font-bold text-xl text-black dark:text-white mb-2">Recently Uploaded</div>
                        <div class="mb-4">{{ $recentFiles->links() }}</div>
                        @if ($recentFiles->isEmpty())
                            <div class="">No Recent Files</div>
                        @else
                            @foreach ($recentFiles as $file)
                                <div
                                    class=" flex justify-between p-4 bg-gray-800 dark:bg-gray-500 text-white font-semibold dark:hover:!bg-gray-700 hover:bg-gray-400 hover:text-black dark:hover:text-white rounded-lg mb-2">
                                    <p>{{ basename($file->path) }} - {{ $file->created_at->format('d-m-Y H:i') }}
                                    </p>
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
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endforeach
                        @endif
            @endif
        </div>
    </div>
    </div>
    @include('partials.statistics-charts')
</x-app-layout>
