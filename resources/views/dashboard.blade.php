<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @if (auth()->user()->hasRole(1))
                <div class="grid grid-cols-2 gap-4">
                    <div><canvas id="myChart" class="bg-white rounded-lg shadow-md pr-4"></canvas></div>
                    <p>Appel</p>
                </div>
            @else
                {{ __('Hallo User') }}
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            const data = {
                labels: @json($userRegistrationData->pluck('date')), // Extract dates
                datasets: [{
                    label: 'Registered users in the last 30 days',
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: @json($userRegistrationData->pluck('aggregate')), // Extract aggregate counts
                }]
            };

            const config = {
                type: 'bar',
                data: data,
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

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        </script>
    @endpush



</x-app-layout>
