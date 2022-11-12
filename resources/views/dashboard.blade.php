<x-vinylshop-layout>
    <x-slot name="description">dashboard</x-slot>
    <x-slot name="title">{{ auth()->user()->name }}'s Dashboard</x-slot>

    <x-tmk.section>
        <x-jet-welcome />
    </x-tmk.section>
</x-vinylshop-layout>
