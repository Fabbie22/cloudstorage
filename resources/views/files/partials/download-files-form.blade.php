<section>
    <form action="{{ route('files.download') }}" method="POST">
        @csrf
        <input type="hidden" name="path" value="{{ Crypt::encryptString($file->path) }}">

        <x-dropdown-link :href="route('files.download')"
            onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="fas fa-download mr-2"></i>{{ __('Download') }}
        </x-dropdown-link>
    </form>
</section>
