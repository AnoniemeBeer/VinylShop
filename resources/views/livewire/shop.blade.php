<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse" wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>
    {{-- filter section: artist or title, genre, max price and records per page --}}

    <div class="grid grid-cols-10 gap-4">
        <div class="col-span-10 md:col-span-5 lg:col-span-3">
            <x-jet-label for="name" value="Filter" />
            <div class="relative" x-data="{ name: @entangle('name') }">
                <x-jet-input id="name" type="text" class="block mt-1 w-full" placeholder="Filter Artist Or Record"
                    x-model.debounce.500ms="name" {{-- wire:model.debounce.500ms="name" --}} />
                <div class="w-5 absolute right-4 top-3 cursor-pointer" x-show="name" @click="name = '';">
                    <x-phosphor-x-duotone />
                </div>
            </div>
        </div>
        <div class="col-span-5 md:col-span-2 lg:col-span-2">
            <x-jet-label for="genre" value="Genre" />
            <x-tmk.form.select id="genre" class="block mt-1 w-full" wire:model.debounce.500ms="price">
                <option value="%">All Genres</option>
                @foreach ($allGenres as $g)
                    <option value="{{ $g->id }}">
                        {{ $g->name }} ({{ $g->records_count }})
                    </option>
                @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-5 md:col-span-3 lg:col-span-2">
            <x-jet-label for="perPage" value="Records per page" />
            <x-tmk.form.select id="perPage" class="block mt-1 w-full" wire:model="perPage">
                @foreach ([3, 6, 9, 12, 15, 18, 24] as $recordsPerPage)
                    <option value="{{ $recordsPerPage }}">{{ $recordsPerPage }}</option>
                @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-10 lg:col-span-3">
            <x-jet-label for="price">Price &le;
                <output id="pricefilter" name="pricefilter">{{ $price }}</output>
            </x-jet-label>
            <x-jet-input type="range" id="price" name="price" min="{{ $priceMin }}"
                max="{{ $priceMax }}" oninput="pricefilter.value = price.value"
                class="block mt-4 w-full h-2 bg-indigo-100 appearance-none" wire:model="price" />
        </div>
    </div>

    {{-- master section: cards with paginationlinks --}}
    <div class="my-4">{{ $records->links() }}</div>
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">
        @foreach ($records as $record)
            <div wire:key="record-{{ $record->id }}"
                class="flex bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <img class="w-52 h-52 border-r border-gray-300 object-cover" src="{{ $record->cover['url'] }}"
                    alt="{{ $record->title }}" title="{{ $record->title }}">
                <div class="flex-1 flex flex-col">
                    <div class="flex-1 p-4">
                        <p class="text-lg font-medium">{{ $record->artist }}</p>
                        <p class="italic pb-2">{{ $record->title }}</p>
                        <p class="italic font-thin text-right pt-2 mb-2">{{ $record->genre_name }}</p>
                    </div>
                    <div class="flex justify-between border-t border-gray-300 bg-gray-100 px-4 py-2">
                        <div>{{ $record->price_euro }}</div>
                        <div class="flex space-x-4">
                            @if ($record->stock > 0)
                                <div class="w-6 cursor-pointer hover:text-red-900">
                                    <x-phosphor-shopping-bag-light class="outline-0"
                                        data-tippy-content="Add to basket<br><span class='text-red-300'>NOT IMPLEMENTED YET</span>" />
                                </div>
                            @else
                                <p class="font-extrabold text-red-700">SOLD OUT</p>
                            @endif
                            <div class="w-6 cursor-pointer hover:text-red-900">
                                <x-phosphor-music-notes-light wire:click="showTracks({{ $record->id }})"
                                    class="outline-0" data-tippy-content="Show tracks" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-4">{{ $records->links() }}</div>

    {{-- No records found --}}
    @if ($records->isEmpty())
        <x-tmk.alert type="danger" class="w-full">
            Can't find any artist or album with <b>'{{ $name }}'</b> and a price of
            <b>'≤ €{{ $price }}'</b> for this genre
        </x-tmk.alert>
    @endif

    {{-- Detail section --}}
    <div x-data="{ open: @entangle('showModal') }" x-cloak x-show="open" x-transition.duration.500ms
        class="fixed z-40 inset-0 p-8 grid h-screen place-items-center backdrop-blur-sm backdrop-grayscale-[.7] bg-slate-100/70">
        <div @click.away="open = false;" @keyup.enter.window="open = false;" @keyup.esc.window="open = false;"
            class="bg-white p-4 border border-gray-300 max-w-2xl">
            <div class="flex justify-between space-x-4 pb-2 border-b border-gray-300">
                <h3 class="font-medium">
                    {{ $selectedRecord->title ?? 'Title' }}<br />
                    <span class="font-light">{{ $selectedRecord->artist ?? 'Artist' }}</span>
                </h3>
                <img class="w-20 h-20"
                    src="{{ $selectedRecord->cover['url'] ?? asset('storage/covers/no-cover.png') }}" alt="">
            </div>
            @isset($selectedRecord->tracks)
                <table class="w-full text-left align-top">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Track</th>
                            <th class="px-4 py-2">Length</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedRecord['tracks'] as $track)
                            <tr class="border-t border-gray-100">
                                <td class="px-4 py-2">{{ $track['position'] }}</td>
                                <td class="px-4 py-2">{{ $track['title'] }}</td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::createFromTimestampMs($track['length'])->format('i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endisset
        </div>
    </div>
</div>
