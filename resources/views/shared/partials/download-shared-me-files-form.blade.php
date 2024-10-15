<section>
    <form action="{{ route('shared-with-me.download') }}" method="POST">
        @csrf
        <input type="hidden" name="path" value="{{ Crypt::encryptString($data->file->path) }}">
        
        <x-dropdown-link :href="route('shared-with-me.download')"
            onclick="event.preventDefault();
            this.closest('form').submit();">
            <i class="fas fa-download mr-2"></i>{{ __('Download') }}
        </x-dropdown-link>
    </form>
</section>
