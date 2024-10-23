<section>
    @php
        $status = session('status');
    @endphp

    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
        @switch($status)
            @case('file-shared')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File Shared!') }}</p>
                </div>
            @break

            @case('already-shared')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File is already shared with the user!') }}</p>
                </div>
            @break

            @case('own-email')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('You cannot share with yourself') }}</p>
                </div>
            @break

            @case('files-uploaded')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File uploaded!') }}</p>
                </div>
            @break

            @case('files-deleted')
                <div class="w-full bg-green-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('File deleted successfully!') }}</p>
                </div>
            @break

            @case('no-files-found')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('No files found!') }}</p>
                </div>
            @break

            @case('recipient-not-found')
                <div class="w-full bg-red-500 p-5 rounded-lg mb-4">
                    <p class="text-lg font-semibold text-white">{{ __('This email does not exist!') }}</p>
                </div>
            @break

            @default
                {{-- Optionally handle a default case here if needed --}}
        @endswitch
    </div>
</section>
