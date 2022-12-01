<x-vinylshop-layout>
    <x-slot name="title"></x-slot>
    <div class="grid grid-rows-2 grid-flow-col gap-4">
        <p class="row-span-2 text-5xl text-right border-r-2 border-gray-700 pr-4">
            @yield('code')
        </p>
        <p class="text-2xl font-light text-gray-400">
            @yield('message')
        </p>
        <div>
            <x-jet-button class="bg-gray-400 hover:bg-gray-500">
                <a href="{{ route('home') }}">Home</a>
            </x-jet-button>
            <x-jet-button class="bg-gray-400 hover:bg-gray-500">
                <a href="#" onclick="window.history.back();">Back</a>
            </x-jet-button>
        </div>
    </div>
</x-vinylshop-layout>
