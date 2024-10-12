<section>
    <form method="POST" action="{{ route('files.delete', $file->id) }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="path" value="{{ $file->path }}">

        <x-dropdown-link :href="route('files.delete', $file->id)"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
        </x-dropdown-link>
    </form>
</section>
