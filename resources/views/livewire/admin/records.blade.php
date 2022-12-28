<div>
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-jet-input id="search" type="text" placeholder="Filter Artist Or Record"
                wire:model.debounce.500ms="search" class="w-full shadow-md placeholder-gray-300" />
        </div>
        <x-tmk.form.switch id="noStock" text-off="No stock" color-off="bg-gray-100 before:line-through" text-on="No stock"
            color-on="text-white bg-lime-600" wire:model="noStock" class="w-20 h-11" />
        <x-tmk.form.switch id="noCover" text-off="Records without cover" color-off="bg-gray-100 before:line-through"
            text-on="Records without cover" color-on="text-white bg-lime-600" wire:model="noCover" class="w-44 h-11" />
        <x-jet-button wire:click="setNewRecord()">
            new record
        </x-jet-button>
    </x-tmk.section>

    <x-tmk.section>
        <div class="my-4">{{ $records->links() }}</div>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-14">
                <col class="w-20">
                <col class="w-20">
                <col class="w-14">
                <col class="w-max">
                <col class="w-24">
            </colgroup>
            <thead>
                <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                    <th>#</th>
                    <th></th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th class="text-left">Record</th>
                    <th>
                        <x-tmk.form.select id="perPage" class="block mt-1 w-full" wire:model="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </x-tmk.form.select>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr class="border-t border-gray-300" wire:key="record_{{ $record->id }}">
                        <td>{{ $record->id }}</td>
                        <td>
                            <img src="{{ $record->cover['url'] }}" alt="{{ $record->title }} by {{ $record->artist }}"
                                class="my-2 border object-cover">
                        </td>
                        <td>{{ $record->price_euro }}</td>
                        <td>{{ $record->stock }}</td>
                        <td class="text-left">
                            <p class="text-lg font-medium">{{ $record->artist }}</p>
                            <p class="italic">{{ $record->title }}</p>
                            <p class="text-sm text-teal-700">{{ $record->genre_name }}</p>
                        </td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                                <button wire:click="setNewRecord({{ $record->id }})"
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5" />
                                </button>
                                <button x-data=""
                                    @click="confirm('Are you sure you want to delete this record?') ? $wire.deleteRecord({{ $record->id }}) : ''"
                                    class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                    <x-phosphor-trash-duotone class="inline-block w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                            <div class="font-bold italic text-sky-800">No records found</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
        <div class="my-4">{{ $records->links() }}</div>
    </x-tmk.section>

    <x-jet-dialog-modal id="recordModal" wire:model="showModal">
        <x-slot name="title">
            <h2>{{ is_null($newRecord['id']) ? 'New record' : 'Edit record' }}</h2>
        </x-slot>
        <x-slot name="content">
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif
            @if (is_null($newRecord['id']))
                <x-jet-label for="mb_id" value="MusicBrainz id" />
                <div class="flex flex-row gap-2 mt-2">
                    <x-jet-input id="mb_id" type="text" placeholder="MusicBrainz ID"
                        wire:model.defer="newRecord.mb_id" class="flex-1" />
                    <x-jet-button wire:click="getDataFromMusicbrainzApi()" wire:loading.attr="disabled">
                        Get Record info
                    </x-jet-button>
                </div>
            @endif
            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-2">
                    <p class="text-lg font-medium">{!! $newRecord['artist'] ?? '&nbsp;' !!}</p>
                    <input type="hidden" wire:model.defer="newRecord.artist">
                    <p class="italic">{!! $newRecord['title'] ?? '&nbsp;' !!}</p>
                    <input type="hidden" wire:model.defer="newRecord.name">
                    <p class="text-sm text-teal-700">{!! $newRecord['mb_id'] ? 'MusicBrainz id: ' . $newRecord['mb_id'] : '&nbsp;' !!}</p>
                    <input type="hidden" wire:model.defer="newRecord.mb_id">
                    <x-jet-label for="genre_id" value="Genre" class="mt-4" />
                    <x-tmk.form.select wire:model.defer="newRecord.genre_id" id="genre_id" class="block mt-1 w-full">
                        <option value="">Select a genre</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </x-tmk.form.select>
                    <x-jet-label for="price" value="Price" class="mt-4" />
                    <x-jet-input id="price" type="number" step="0.01" wire:model.defer="newRecord.price"
                        class="mt-1 block w-full" />
                    <x-jet-label for="stock" value="Stock" class="mt-4" />
                    <x-jet-input id="stock" type="number" wire:model.defer="newRecord.stock"
                        class="mt-1 block w-full" />

                </div>
                <img src="{{ $newRecord['cover'] }}" alt=""
                    class="mt-4 w-40 h-40 border border-gray-300 object-cover">
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button @click="show = false">Cancel</x-jet-secondary-button>
            @if (is_null($newRecord['id']))
                <x-jet-button wire:click="createRecord()" wire:loading.attr="disabled" class="ml-2">Save new record
                </x-jet-button>
            @else
                <x-jet-button color="success" wire:click="updateRecord({{ $newRecord['id'] }})"
                    wire:loading.attr="disabled" class="ml-2">Update record
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>
</div>
