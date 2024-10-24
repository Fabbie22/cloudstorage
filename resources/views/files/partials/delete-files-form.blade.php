<section>
        <x-dropdown-link class="cursor-pointer" x-data=""
            x-on:click.prevent="$dispatch('open-modal', '{{ basename($file->path) . 'name=' . basename($file->path)  }}')">
            <i class="fas fa-trash mr-2"></i>{{ 'Delete' }}
        </x-dropdown-link>
</section>
