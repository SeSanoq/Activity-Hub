<nav x-data="{ open: false }" class="bg-orange-500 border-b border-orange-400 shadow-sm w-full">
    
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
 
            <div class="flex items-center flex-1 justify-start">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                   <img src="https://www.eng.kmutnb.ac.th/wp-content/uploads/2020/12/logo-kmutnb-final-800x214.jpg"
                        alt="Logo"
                        style="height: 32px; width: auto; max-width: 150px; object-fit: contain;">
                    <span class="text-lg font-bold text-white hidden md:block">
                        ActivityHub
                    </span>
                </a>
            </div>
 
            <div class="hidden sm:flex items-center justify-center space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="text-white hover:text-orange-100 transition">
                    Dashboard
                </x-nav-link>
                
                <x-nav-link :href="route('My-activities')" :active="request()->routeIs('My-activities')"
                    class="text-white hover:text-orange-100 transition">
                    My Activities
                </x-nav-link>
 
                @if(auth()->user()->role === 'admin_club')
                    <x-nav-link :href="url('/create-activity')" :active="request()->is('create-activity')"
                        class="text-white hover:text-orange-100 transition">
                        Create Activity
                    </x-nav-link>
 
                    <x-nav-link :href="url('/my-created-activities')" :active="request()->is('my-created-activities')"
                        class="text-white hover:text-orange-100 transition">
                        My Club
                    </x-nav-link>
                @endif
 
                @if(auth()->user()->role === 'staff')
                    <x-nav-link :href="url('/admin/activities')" :active="request()->is('admin/activities')"
                        class="text-white hover:text-orange-100 transition">
                        Approve Activities
                    </x-nav-link>
 
                    <x-nav-link :href="route('admin.review')" :active="request()->routeIs('admin.review')"
                        class="text-white hover:text-orange-100 transition">
                        Review
                    </x-nav-link>
                @endif
 
                @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')"
                        class="text-white hover:text-orange-100 transition">
                        Manage Users
                    </x-nav-link>
 
                    <x-nav-link :href="url('/admin/review')" :active="request()->is('admin/review')"
                        class="text-white hover:text-orange-100 transition">
                        Review
                    </x-nav-link>
                @endif
            </div>
 
            <div class="flex items-center flex-1 justify-end">
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-white/80 transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
 
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
 
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-500 font-bold">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
 
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center px-3 py-2 text-white">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
 
        </div>
    </div>
 
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-orange-600 border-t border-orange-400">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-orange-700">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('My-activities')" :active="request()->routeIs('My-activities')" class="text-white hover:bg-orange-700">
                My Activities
            </x-responsive-nav-link>
 
            @if(auth()->user()->role === 'admin_club')
                <x-responsive-nav-link :href="url('/create-activity')" class="text-white hover:bg-orange-700">
                    Create Activity
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="url('/my-created-activities')" class="text-white hover:bg-orange-700">
                    My Club
                </x-responsive-nav-link>
            @endif
 
            @if(auth()->user()->role === 'staff')
                <x-responsive-nav-link :href="url('/admin/activities')" class="text-white hover:bg-orange-700">
                    Approve Activities
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.review')" class="text-white hover:bg-orange-700">
                    Review
                </x-responsive-nav-link>
            @endif
 
            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.users')" class="text-white hover:bg-orange-700">
                    Manage Users
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="url('/admin/review')" class="text-white hover:bg-orange-700">
                    Review
                </x-responsive-nav-link>
            @endif
        </div>
 
        <div class="pt-4 pb-1 border-t border-orange-400">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-orange-200">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    Profile
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-white">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>