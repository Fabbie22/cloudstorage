<section>
    <form method="POST" action="{{ route('files.delete', $file->id) }}">
        @csrf
        @method('DELETE')

        <x-dropdown-link :href="route('files.delete', $file->id)"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
        </x-dropdown-link>
    </form>
</section>
