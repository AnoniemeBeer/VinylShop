<div>
    <div>
        <h2>{{ $feed['title'] }} - {{ $feed['country'] }}</h2>
        <h3>Last updated: {{ $date }}</h3>
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
                @foreach ($albums as $key => $item)
                    <tbody>
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
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
