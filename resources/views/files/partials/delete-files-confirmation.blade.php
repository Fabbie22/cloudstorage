<section>
    <x-modal name="{{ basename($data->path) . 'name=' .basename($data->path) }}" focusable>
        <form method="POST" class="mt-6 p-5" action="{{ route('files.delete', Crypt::encryptString($data->id)) }}">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Delete') }} '{{ basename($data->path) }}'
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once deleted your file is gone.') }}
            </p>
            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ms-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
