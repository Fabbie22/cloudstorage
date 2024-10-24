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
                    plugins: {
                        title: {
                            display: true,
                            text: 'Registration Overview',
                        }
                    },
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
