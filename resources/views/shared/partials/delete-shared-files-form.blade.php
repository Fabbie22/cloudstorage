<section>
    <form method="POST" action="{{ route('shared.delete', Crypt::encryptString($data->id)) }}">
        @csrf
        @method('DELETE')

<x-dropdown-link :href="route('shared.delete', Crypt::encrypt($data->id))"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
        </x-dropdown-link>
    </form>
</section
