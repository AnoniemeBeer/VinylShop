<nav class="container mx-auto p-4 flex justify-between">
    {{-- left navigation --}}
    <div class="flex items-center space-x-2">
        {{-- Logo --}}
        <a href="{{ route('home') }}">
            <x-tmk.logo class="w-8 h-8" />
        </a>
        <a class="hidden sm:block font-medium text-lg" href="{{ route('home') }}">
            The Vinyl Shop
        </a>
        <x-jet-nav-link href="{{ route('shop') }}" :active="request()->routeIs('shop')">
            Shop
        </x-jet-nav-link>
        <x-jet-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
            Contact
        </x-jet-nav-link>
    </div>

    {{-- right navigation --}}
    <div class="relative flex items-center space-x-2">
        <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
            Login
        </x-jet-nav-link>
        <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
            Register
        </x-jet-nav-link>
        <x-jet-nav-link href="{{ route('home') }}" :active="request()->routeIs('basket')">
            <x-fas-shopping-basket class="w-4 h-4" />
        </x-jet-nav-link>
        {{-- dropdown navigation --}}
        <x-jet-dropdown align="right" width="48">
            {{-- avatar --}}
            <x-slot name="trigger">
                <img class="rounded-full h-8 w-8 cursor-pointer" src="https://ui-avatars.com/api/?name=Vinyl+Shop"
                    alt="Vinyl Shop">
            </x-slot>
            <x-slot name="content">
                {{-- all users --}}
                <div class="block px-4 py-2 text-xs text-gray-400">My Name</div>
                <x-jet-dropdown-link href="{{ route('home') }}">Dashboard</x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('home') }}">Update Profile</x-jet-dropdown-link>
                <div class="border-t border-gray-100"></div>
                <x-jet-dropdown-link href="{{ route('home') }}">Logout</x-jet-dropdown-link>
                <div class="border-t border-gray-100"></div>
                {{-- admins only --}}
                <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>
                <x-jet-dropdown-link href="{{ route('home') }}">Genres</x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('admin.records.index') }}">Records</x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('home') }}">Covers</x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('home') }}">Users</x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('home') }}">Orders</x-jet-dropdown-link>
            </x-slot>
        </x-jet-dropdown>
    </div>
</nav>
