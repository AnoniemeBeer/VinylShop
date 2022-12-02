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
        <x-jet-nav-link href="{{ route('itunes') }}" :active="request()->routeIs('itunes')">
            Itunes
        </x-jet-nav-link>
        <x-jet-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
            Contact
        </x-jet-nav-link>
    </div>

    {{-- right navigation --}}
    <div class="relative flex items-center space-x-2">
        @guest
            <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                Login
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                Register
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('home') }}" :active="request()->routeIs('basket')">
                <x-fas-shopping-basket class="w-4 h-4" />
            </x-jet-nav-link>
        @endguest
        {{-- dropdown navigation --}}
        @auth
            <x-jet-dropdown align="right" width="48">
                {{-- avatar --}}
                <x-slot name="trigger">
                    <img class="rounded-full h-8 w-8 cursor-pointer" src="{{ $avatar }}"
                        alt="{{ auth()->user()->name }}">
                </x-slot>
                <x-slot name="content">
                    {{-- all users --}}
                    <div class="block px-4 py-2 text-xs text-gray-400">{{ auth()->user()->name }}</div>
                    <x-jet-dropdown-link href="{{ route('dashboard') }}">Dashboard</x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('profile.show') }}">Update Profile</x-jet-dropdown-link>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">Logout</button>
                    </form>
                    @if (auth()->user()->admin)
                        <div class="border-t border-gray-100"></div>
                        {{-- admins only --}}
                        <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>
                        <x-jet-dropdown-link href="{{ route('admin.genres') }}">Genres</x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('admin.records.index') }}">Records</x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('home') }}">Covers</x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('home') }}">Users</x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('home') }}">Orders</x-jet-dropdown-link>
                    @endif
                </x-slot>
            </x-jet-dropdown>
        @endauth
    </div>
</nav>
