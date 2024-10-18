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
                        <div class="mb-4">{{ $recent_files->links() }}</div>
                        @if ($recent_files->isEmpty())
                            <div class="">No Recent Files</div>
                        @else
                            @foreach ($recent_files as $file)
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

    @push('scripts')
        <script>
            // Data for the registration chart (bar chart)
            const registrationData = {
                labels: @json($userRegistrationData->pluck('date')), // Extract dates
                datasets: [{
                    label: 'Registered users in the last 30 days',
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: @json($userRegistrationData->pluck('aggregate')), // Extract aggregate counts
                }]
            };

            const registrationConfig = {
                type: 'bar',
                data: registrationData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Registrations'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Registration Dates'
                            }
                        }
                    }
                }
            };

            const registrationChart = new Chart(
                document.getElementById('registration_chart'),
                registrationConfig
            );

            // Data for the file types distribution chart (pie chart)
            const fileTypesData = {
                labels: @json($fileTypesData->pluck('file_type')), // Extract file types
                datasets: [{
                    label: 'File Type',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.3)',
                        'rgba(54, 162, 235, 0.3)',
                        'rgba(255, 206, 86, 0.3)',
                        'rgba(75, 192, 192, 0.3)',
                        'rgba(153, 102, 255, 0.3)',
                        'rgba(255, 159, 64, 0.3)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: @json($fileTypesData->pluck('total')), // Extract total counts for each file type
                }]
            };

            const fileTypesConfig = {
                type: 'pie', // Use 'pie' for the pie chart
                data: fileTypesData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'File Types Used'
                        }
                    }
                }
            };

            const fileTypesChart = new Chart(
                document.getElementById('fileTypesChart'),
                fileTypesConfig
            );

            const savedDeletedData = {
                labels: ['Saved Files', 'Deleted Files'],
                datasets: [{
                    label: 'Saved vs Deleted',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.3)', // Color for saved files
                        'rgba(54, 162, 235, 0.3)' // Color for deleted files
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Border color for saved files
                        'rgba(54, 162, 235, 1)' // Border color for deleted files
                    ],
                    data: [{{ $savedFilesCount }}, {{ $removedFilesCount }}], // Counts for saved and deleted files
                }]
            };

            const savedDeletedConfig = {
                type: 'doughnut', // Specify donut chart type
                data: savedDeletedData, // Data for the chart
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'File Status: Saved vs Deleted'
                        }
                    }
                }
            };

            const savedDeletedChart = new Chart(
                document.getElementById('savedDeletedChart'),
                savedDeletedConfig // Use the correct variable name
            );

            // Data for the file ages chart (bar chart example)
            const fileAgesData = {
                labels: @json($ageLabels), // Extract file names or IDs
                datasets: [{
                    label: 'File Age in Days',
                    backgroundColor: 'rgba(75, 192, 192, 0.3)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: @json($ageValues), // Extract age in days
                }]
            };

            const fileAgesConfig = {
                type: 'bar', // Change to 'pie', 'line', etc. as needed
                data: fileAgesData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Age (Days)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ages of Files'
                        }
                    }
                }
            };

            const fileAgesChart = new Chart(
                document.getElementById('fileAgesChart'),
                fileAgesConfig
            );
// Data for the file count chart (bar chart example)
const fileCountsData = {
    labels: @json($userLabels), // Extract user names from the updated PHP code
    datasets: [{
        label: 'Number of Files per User',
        backgroundColor: 'rgba(75, 192, 192, 0.3)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        data: @json($fileCounts), // Extract number of files per user
    }]
};

const fileCountsConfig = {
    type: 'bar', // Change to 'pie', 'line', etc. as needed
    data: fileCountsData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Files'
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Number of Files per User'
            }
        }
    }
};

const fileCountsChart = new Chart(
    document.getElementById('fileCountsChart'),
    fileCountsConfig
);

        </script>
    @endpush






</x-app-layout>
