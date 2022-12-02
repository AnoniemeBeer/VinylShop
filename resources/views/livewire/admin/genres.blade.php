<div>
    <x-tmk.section class="p-0 mb-4 flex flex-col gap-2" x-data="{ open: false }">
        <div class="p-4 flex justify-between items-start gap-4">
            <div class="relative w-64">
                <x-jet-input id="newGenre" type="text" placeholder="New genre"
                    @keydown.enter="$el.setAttribute('disabled', true); $el.value = '';"
                    @keydown.tab="$el.setAttribute('disabled', true); $el.value = '';"
                    @keydown.esc="$el.setAttribute('disabled', true); $el.value = '';" wire:model.defer="newGenre"
                    wire:keydown.enter="createGenre()" wire:keydown.tab="createGenre()"
                    wire:keydown.escape="resetNewGenre()" class="w-full shadow-md placeholder-gray-300" />
                <x-phosphor-arrows-clockwise class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin"
                    wire:loading wire:target="createGenre" />
            </div>
            <x-heroicon-o-information-circle class="w-5 text-gray-400 cursor-help outline-0" @click="open = !open" />
        </div>
        <x-jet-input-error for="newGenre" class="m-4 -mt-4 w-full" />
        <div style="display: none" class="text-sky-900 bg-sky-50 border-t p-4" x-show="open">
            <x-tmk.list type="ul" class="list-outside mx-4 text-sm">
                <li>
                    <b>A new genre</b> can be added by typing in the input field and pressing <b>enter</b> or
                    <b>tab</b>. Press <b>escape</b> to undo.
                </li>
                <li>
                    <b>Edit a genre</b> by clicking the
                    <x-phosphor-pencil-line-duotone class="w-5 inline-block" />
                    icon or by clicking on the genre name. Press <b>enter</b> to save, <b>escape</b> to undo.
                </li>
                <li>
                    Clicking the
                    <x-heroicon-o-information-circle class="w-5 inline-block" />
                    icon will toggle this message on and off.
                </li>
            </x-tmk.list>
        </div>
    </x-tmk.section>

    <x-tmk.section>
        {{-- pagination --}}
        <div class="my-4">{{ $genres->links() }}</div>

        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-14">
                <col class="w-20">
                <col class="w-16">
                <col class="w-max">
            </colgroup>
            <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2 cursor-pointer">
                    <th wire:click="resort('id')">
                        <span data-tippy-content="Order by id">#</span>
                        <x-heroicon-s-chevron-up
                            class="w-5 text-slate-400
                        {{ $orderAsc ?: 'rotate-180' }}
                        {{ $orderBy === 'id' ? 'inline-block' : 'hidden' }}
                    " />
                    </th>
                    <th wire:click="resort('records_count')">
                        <span data-tippy-content="Order by # records">
                            <x-tmk.logo
                                class="w-5 text-slate-400
                            {{ $orderAsc ?: 'rotate-180' }}
                            {{ $orderBy === 'records_count' ? 'inline-block' : 'hidden' }}
                        " />
                        </span>
                        <x-heroicon-s-chevron-up class="w-5 text-slate-400 inline-block" />
                    </th>
                    <th></th>
                    <th wire:click="resort('name')" class="text-left">
                        <span data-tippy-content="Order by genre">Genre</span>
                        <x-heroicon-s-chevron-up
                            class="w-5 text-slate-400
                        {{ $orderAsc ?: 'rotate-180' }}
                        {{ $orderBy === 'name' ? 'inline-block' : 'hidden' }}
                    " />
                    </th>
                    <th>
                        <div class="col-span-3 md:col-span-2 lg:col-span-1">
                            <x-tmk.form.select id="perPage" wire:model="perPage" class="block mx-auto w-full">
                                @foreach ([5, 10, 15, 20, 25] as $recordsPerPage)
                                    <option value="{{ $recordsPerPage }}">{{ $recordsPerPage }}</option>
                                @endforeach
                            </x-tmk.form.select>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr class="border-t border-gray-300 [&>td]:p-2" wire:key="genre_{{ $genre->id }}">
                        <td>{{ $genre->id }}</td>
                        <td>{{ $genre->records_count }}</td>
                        <td x-data="">
                            @if ($editGenre['id'] !== $genre->id)
                                <div
                                    class="flex gap-1 justify-center [&>*]:cursor-pointer [&>*]:outline-0 [&>*]:transition">
                                    <x-phosphor-pencil-line-duotone class="w-5 text-gray-300 hover:text-green-600"
                                        wire:click="editExistingGenre({{ $genre->id }})" />
                                    <x-phosphor-trash-duotone class="w-5 text-gray-300 hover:text-red-600"
                                        @click="$dispatch('swal:confirm', {
                                        title: 'Delete {{ $genre->name }}?',
                                        icon: '{{ $genre->records_count > 0 ? 'warning' : '' }}',
                                        background: '{{ $genre->records_count > 0 ? 'error' : '' }}',
                                        cancelButtonText: 'NO!',
                                        confirmButtonText: 'YES DELETE THIS GENRE',
                                        html: '{{ $genre->records_count > 0 ? '<b>ATTENTION</b>: you are going to delete <b>' . $genre->records_count . ' ' . Str::plural('record', $genre->records_count) . '</b> at the same time!' : '' }}',
                                        color: '{{ $genre->records_count > 0 ? 'red' : '' }}',
                                        next: {
                                            event: 'delete-genre',
                                            params: {
                                                id: {{ $genre->id }}
                                            }
                                        }
                                    });" />
                                </div>
                            @endif
                        </td>
                        @if ($editGenre['id'] !== $genre->id)
                            <td class="text-left
                                        cursor-pointer"
                                wire:click="editExistingGenre({{ $genre->id }})">
                                {{ $genre->name }}
                            </td>
                        @else
                            <td>
                                <div class="flex flex-col text-left">
                                    <x-jet-input id="edit_{{ $genre->id }}" type="text" x-data=""
                                        x-init="$el.focus()" wire:model.defer="editGenre.name"
                                        @keydown.enter="$el.setAttribute('disabled', true);"
                                        @keydown.tab="$el.setAttribute('disabled', true);"
                                        @keydown.esc="$el.setAttribute('disabled', true);"
                                        wire:keydown.enter="updateGenre({{ $genre->id }})"
                                        wire:keydown.tab="updateGenre({{ $genre->id }})"
                                        wire:keydown.escape="resetEditGenre()" class="w-48" />
                                    <x-phosphor-arrows-clockwise
                                        class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin" wire:loading
                                        wire:target="updateGenre" />
                                    <x-jet-input-error for="editGenre.name" class="mt-2" />
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-tmk.section>
</div>
