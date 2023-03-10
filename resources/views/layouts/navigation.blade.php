<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center text-xl font-bold">
                    <a href="{{ route('home') }}">
                        Engineer Match
                    </a>
                </div>



                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('TOP') }}
                    </x-nav-link>
                </div>

                @if(Auth::user()->role != 'admin' && Auth::user()->role != 'member' && Auth::user()->role != 'pending')

                @if(Auth::user()->role == 'recruiment')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>検査を受ける</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('request1')" active="request()->routeIs('request1')">
                                {{ __('職種適正') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('request2')" active="request()->routeIs('request2')">
                                {{ __('企業適正') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('request3_1')" active="request()->routeIs('request3_1')">
                                {{ __('現状確認') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="https://engineer-match-recommend-result.com/total/" target="_blank" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('おすすめ結果を見る') }}
                    </a>
                </div>
                @elseif(Auth::user()->role == 'sales')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('request1_s')" :active="request()->routeIs('request1_s')">
                        {{ __('検査を受ける') }}
                    </x-nav-link>
                </div>
                @elseif(Auth::user()->role == 'management')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('request1_m')" :active="request()->routeIs('request1_m')">
                        {{ __('検査を受ける') }}
                    </x-nav-link>
                </div>

                <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('express')" :active="request()->routeIs('express')">
                            {{ __('感想') }}
                        </x-nav-link>
                    </div> -->
                @endif

                @else

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                        {{ __('管理ページ') }}
                    </x-nav-link>
                </div>
                @endif

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                            <div>{{ Auth::user()->name == '' ? Auth::user()->initName_f ." ".
                                Auth::user()->initName_l:Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show')">
                            {{ __('プロフィール編集') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('ログアウト') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>


                </x-dropdown>

            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="my-3 space-y-1">
                <x-responsive-nav-link :href="route('home')">
                    {{ __('TOP') }}
                </x-responsive-nav-link>
                @if(Auth::user()->role == 'recruiment')
                <x-responsive-nav-link>
                    {{ __('検査を受ける') }}
                </x-responsive-nav-link>
                <x-dropdown-link class="pl-8" :href="route('request1')" :active="request()->routeIs('request1')">
                    {{ __('職種適正') }}
                </x-dropdown-link>
                <x-dropdown-link class="pl-8" :href="route('request2')" :active="request()->routeIs('request2')">
                    {{ __('企業適正') }}
                </x-dropdown-link>
                <x-dropdown-link class="pl-8" :href="route('request3_1')" :active="request()->routeIs('request3_1')">
                    {{ __('現状確認') }}
                </x-dropdown-link>
                <x-responsive-nav-link :href="route('home')">
                    <a href="https://engineer-match-recommend-result.com/total/" target="_blank" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('おすすめ結果を見る') }}
                    </a>
                </x-responsive-nav-link>                

                @elseif(Auth::user()->role == 'sales')
                <x-dropdown-link :href="route('request1_s')" :active="request()->routeIs('request1_s')">
                    {{ __('検査を受ける') }}
                </x-dropdown-link>
                @elseif(Auth::user()->role == 'management')
                <x-dropdown-link :href="route('request1_m')" :active="request()->routeIs('request1_m')">
                    {{ __('検査を受ける') }}
                </x-dropdown-link>
                <!-- <x-dropdown-link :href="route('express')" :active="request()->routeIs('express')">
                    {{ __('感想') }}
                </x-dropdown-link> -->
                @else
                <hr />
                <x-responsive-nav-link :href="route('admin')">
                    {{ __('管理ページ') }}
                </x-responsive-nav-link>
                @endif

            </div>
            <hr />
            <div class="px-4 mt-3">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.show')">
                    {{ __('プロフィール編集') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('ログアウト') }}
                    </x-responsive-nav-link>
                </form>
            </div>

            @endauth
        </div>
    </div>
</nav>