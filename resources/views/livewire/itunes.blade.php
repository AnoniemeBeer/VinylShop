<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse" wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>
    <div class="flex gap-4">
        <div class="flex-1">
            <h2>{{ $feed['title'] }} - {{ strtoupper($feed['country']) }}</h2>
            <h3>Last updated: {{ $date }}</h3>
        </div>
        <div class="w-52">
            {{-- the form for the country codes --}}
            <x-tmk.form.select id="countryCode" wire:model="countryCode"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                <option value="be">Belgium</option>
                <option value="fr">France</option>
                <option value="gb">United Kingdom</option>
                <option value="us">United States</option>
                <option value="nl">Netherlands</option>
                <option value="de">Germany</option>
                <option value="it">Italy</option>
                <option value="es">Spain</option>
                <option value="ca">Canada</option>
                <option value="au">Australia</option>
                <option value="jp">Japan</option>
                <option value="lu">Luxembourg</option>
                <option value="ch">Switzerland</option>
                <option value="at">Austria</option>
                <option value="dk">Denmark</option>
                <option value="no">Norway</option>
            </x-tmk.form.select>

            {{-- the form for the amount of albums --}}
            <x-tmk.form.select id="amount" wire:model="amount"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-2">
                @for ($i = 6; $i <= 50; $i += 2)
                    <option value="{{ $i }}">{{ $i }} items</option>
                @endfor
            </x-tmk.form.select>

            <x-tmk.form.switch name="type" text-on="albums" text-off="singles" wire:model="type"
                class="cursor-pointer border border-gray-300 rounded-md text-center font-semibold uppercase text-xs h-9 w-16 inline-flex flex-wrap overflow-hidden w-full mt-2" />

        </div>
    </div>
    <div>
        <div class="flex gap-4">
            <table class="w-full text-left bg-white border border-gray-100 shadow-2xl mt-8">
                <thead>
                    <tr class="bg-gray-800 text-gray-100">
                        <td class="px-4 py-2">#</td>
                        <td class="px-4 py-2">Cover</td>
                        <td class="px-4 py-2">Artist</td>
                        <td class="px-4 py-2">Genre</td>
                        <td class="px-4 py-2">Artist Url</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($albums as $key => $item)
                        <tr class="border-t border-gray-100 align-top">
                            <td class="px-4 py-2">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-4 py-2">
                                <img src="{{ $item['artworkUrl100'] }}" alt="{{ $item['name'] }}" class="w-12 h-12">
                            </td>
                            <td class="px-4 py-2">
                                {{ $item['artistName'] }}
                                <br>
                                {{ $item['name'] }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $item['genres'][0]['name'] }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ $item['artistUrl'] }}"
                                    class="text-sky-600 underline">{{ $item['artistName'] }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
