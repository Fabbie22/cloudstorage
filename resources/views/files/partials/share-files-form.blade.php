<section>
    <x-modal name="{{ $data->id }}" focusable>
        <form method="POST" class="mt-6 p-5" action="{{ route('share.store', Crypt::encryptString($data->id)) }}">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Share') }} '{{ basename($data->path) }}'
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('When you share your file, you will always stay in control of the file. Delete the shared connection anytime you want on your shared page. You will always be the owner.') }}
            </p>
            <x-text-input id="recipient_email" name="recipient_email" type="text" class="mt-6 block w-full"
                placeholder="Email address" autocomplete="email" />

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">
                    {{ __('Share') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
