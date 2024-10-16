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
            @if (auth()->user()->hasRole(1))
                <div class="grid grid-cols-1 w-full sm:grid-cols-2 gap-4">
                    <div><canvas id="registration_chart"
                            class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72 "></canvas></div>
                    <div><canvas id="fileTypesChart" class="bg-white rounded-lg shadow-md pr-4 pb-4 max-h-72"></canvas>
                    </div>

                </div>
            @else
                {{ __('Hallo User') }}
            @endif
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
                    label: 'File Types Distribution',
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
                            text: 'Distribution of File Types'
                        }
                    }
                }
            };

            const fileTypesChart = new Chart(
                document.getElementById('fileTypesChart'),
                fileTypesConfig
            );
        </script>
    @endpush






</x-app-layout>
