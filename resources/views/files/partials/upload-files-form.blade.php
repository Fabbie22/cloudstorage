<section>
    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="flex items-center gap-2">
        <div>
            <x-upload-file id="file" name="files[]" multiple />
        </div>

            <x-primary-button>{{ __('Upload') }}</x-primary-button>

        </div>
    </form>
</section>
