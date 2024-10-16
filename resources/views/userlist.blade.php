<x-app-layout>
    @if (auth()->user()->hasRole(1))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Shared') }}
            </h2>
        </x-slot>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
                @if ($users->isEmpty())
                    <div
                        class="bg-white dark:bg-gray-800 mt-4 p-5 w-full text-center rounded-lg border-5 border-indigo-800 shadow">
                        <p>No users available.</p>
                        <p>Please invite people to register</p>
                    </div>
                @else
                    <div class="mb-4">
                        {{ $users->links() }}
                        <p>{!! 'Currently we have: <strong>' . $usercount . '</strong> users' !!}</p>
                        <p>{!! 'Who save all together: <strong>' . $filecount . '</strong> files'!!}</p>
                    </div>
                    <table class="min-w-full table-auto rounded-lg shadow">
                        <thead class="bg-gray-800 dark:bg-gray-500 text-white font-semibold rounded-t-lg">
                            <tr class="bg-gray-800 dark:bg-gray-500 text-white font-semibold">
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Registerd At</th>
                                <th class="p-3 text-left">E-Mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user => $data)
                                <tr class="bg-gray-800 dark:bg-gray-500 text-white hover:!bg-gray-700">
                                    <td class="p-3">{{ $data->name }}</td>
                                    <td class="p-3">{{ $data->created_at->format('d-m-Y') }}</td>
                                    <td class="p-3">{{ $data->email }}</td>
                                </tr>
                        </tbody>
                @endforeach
                </table>
    @endif
    </div>
    </div>
@else
    {{ abort(404) }}
    @endif
</x-app-layout>
