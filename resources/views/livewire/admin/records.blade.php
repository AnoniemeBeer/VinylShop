<div>
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-jet-input id="search" type="text" placeholder="Filter Artist Or Record"
                wire:model.debounce.500ms="search" class="w-full shadow-md placeholder-gray-300" />
        </div>
        <x-tmk.form.switch id="noStock" text-off="No stock" color-off="bg-gray-100 before:line-through" text-on="No stock"
            color-on="text-white bg-lime-600" wire:model="noStock" class="w-20 h-11" />
        <x-tmk.form.switch id="noCover" text-off="Records without cover" color-off="bg-gray-100 before:line-through"
            text-on="Records without cover" color-on="text-white bg-lime-600" class="w-44 h-11" />
        <x-jet-button>
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
                        <x-tmk.form.select id="perPage" class="block mt-1 w-full">
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
                    <tr class="border-t border-gray-300">
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
                                <button
                                    class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5" />
                                </button>
                                <button class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
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
            <h2>title</h2>
        </x-slot>
        <x-slot name="content">
            content
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button @click="show = false">Cancel</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
