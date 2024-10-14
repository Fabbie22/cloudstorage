<section>
    @if (session('status') === 'file-shared')
        <div class="w-full bg-green-500 p-5 rounded-lg mb-4" x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2000)">
            <p class="text-lg font-semibold text-white">{{ __('File Shared!') }}</p>
        </div>
    @endif
    @if (session('status') === 'already-shared')
        <div class="w-full bg-red-500 p-5 rounded-lg mb-4" x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2000)">
            <p class="text-lg font-semibold text-white">{{ __('File is already shared with the user!') }}</p>
        </div>
    @endif
    @if (session('status') === 'files-uploaded')
        <div class="w-full bg-green-500 p-5 rounded-lg mb-4" x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2000)">
            <p class="text-lg font-semibold text-white">{{ __('File uploaded!') }}</p>
        </div>
    @endif
        @if (session('status') === 'files-deleted')
        <div class="w-full bg-green-500 p-5 rounded-lg mb-4" x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2000)">
            <p class="text-lg font-semibold text-white">{{ __('File deleted successfully!') }}</p>
        </div>
    @endif
</section>
