<section>
    <form action="{{ route('shared-with-me.download') }}" method="POST">
        @csrf
        <input type="hidden" name="path" value="{{ $data->file->path }}">
        <input type="hidden" name="file_name" value="{{ $data->file->file_name }}">

        <x-dropdown-link :href="route('shared-with-me.download')"
            onclick="event.preventDefault();
            this.closest('form').submit();">
            <i class="fas fa-download mr-2"></i>{{ __('Download') }}
        </x-dropdown-link>
    </form>
</section>
