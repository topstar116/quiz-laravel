<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center text-xl font-bold">
                    <a href="{{ route('home') }}">
                        AI Career Consultant
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('TOP') }}
                    </x-nav-link>
                </div>

                @if (Auth::check() && Auth::user()->role == 'admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                            {{ __('管理ページ') }}
                        </x-nav-link>
                        <x-nav-link :href="route('resume.output')" :active="request()->routeIs('resume.output')">
                            {{ __('応募書類提出') }}
                        </x-nav-link>
                        <x-nav-link :href="route('email.template')" :active="request()->routeIs('email.template')">
                            {{ __('ポップアップ') }}
                        </x-nav-link>
                    </div>
                @elseif (Auth::check() && Auth::user()->role != 'admin' && Auth::user()->role != 'company')
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700">
                                    <div>職種提案を受ける</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('resume.career.question')">{{ __('全職種') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('quiz1')">{{ __('ITエンジニア') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700">
                                    <div>職種一覧を見る</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="https://shigoto.mhlw.go.jp/User/"
                                    target="blank">{{ __('全職種') }}</x-dropdown-link>
                                <x-dropdown-link href="https://engineer-match-recommend-result.com/total/"
                                    target="blank">{{ __('ITエンジニア') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('question_resuming')" :active="request()->routeIs('question.resuming')">{{ __('職務経歴書') }}</x-nav-link>
                        <x-nav-link :href="route('work.question')" :active="request()->routeIs('work.question')">{{ __('業務適性検査を受ける') }}</x-nav-link>
                        <x-nav-link :href="route('add.movie')" :active="request()->routeIs('add.movie')">{{ __('応募書類提出') }}</x-nav-link>
                    </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700">
                            <div>
                                {{ Auth::user()->name == '' ? Auth::user()->initName_f . ' ' . Auth::user()->initName_l : Auth::user()->name }}
                            </div>
                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show')">{{ __('プロフィール編集') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">{{ __('ログアウト') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = !open"
                    class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow-lg">
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="my-3 space-y-1">
                    <x-responsive-nav-link :href="route('home')"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                        {{ __('TOP') }}
                    </x-responsive-nav-link>

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                            {{ __('管理ページ') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('resume.output')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                            {{ __('応募書類提出') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('email.template')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                            {{ __('ポップアップ') }}
                        </x-responsive-nav-link>
                    @elseif (Auth::check() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'company')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center w-full px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                                    <div>職種提案を受ける</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content" class="w-full">
                                <x-dropdown-link :href="route('resume.career.question')" class="w-full">{{ __('全職種') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('quiz1')" class="w-full">{{ __('ITエンジニア') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center w-full px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">
                                    <div>職種一覧を見る</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="https://shigoto.mhlw.go.jp/User/"
                                    target="blank">{{ __('全職種') }}</x-dropdown-link>
                                <x-dropdown-link href="https://engineer-match-recommend-result.com/total/"
                                    target="blank">{{ __('ITエンジニア') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <x-responsive-nav-link :href="route('question_resuming')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">{{ __('職務経歴書') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('work.question')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">{{ __('業務適性検査を受ける') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('add.movie')"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">{{ __('応募書類提出') }}</x-responsive-nav-link>
                    @endif
                </div>

                <hr class="my-2" />

                <!-- User Info -->
                <div class="px-4 mt-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show')"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">{{ __('プロフィール編集') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded">{{ __('ログアウト') }}</x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>


</nav>
