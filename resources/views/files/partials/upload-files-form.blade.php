<section>
    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="flex items-center gap-2">
        <div>
            <x-upload-file id="file" name="file" />
        </div>

            <x-primary-button>{{ __('Upload') }}</x-primary-button>

            @if (session('status') === 'files-uploaded')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Uploaded.') }}</p>
            @endif
        </div>
    </form>
</section>
