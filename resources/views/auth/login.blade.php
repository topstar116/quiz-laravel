<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            
            <div style="font-size: 40px;font-weight: bolder;">ログイン</div>
            
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 flex flex-col">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('ログインしたままにする') }}</span>
                </label>
                <!-- <label for="user" class="inline-flex items-center my-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('企業登録') }}
                    </a>
                </label>
                <label  for="company" class="inline-flex items-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('ユーザー登録') }}
                    </a>
                </label> -->
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('パスワード設定はこちら') }}
                    </a> -->
                @endif

                <x-button class="ml-4">
                    {{ __('ログイン') }}
                </x-button>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('パスワード設定はこちら') }}
                    </a> -->
                @endif

                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('採用') }}
                </a>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 mx-4" href="{{ route('sales_register') }}">
                    {{ __('営業') }}
                </a>

                <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 mr-4" href="{{ route('management_register') }}">
                    {{ __('企業登録') }}
                </a> -->
                
                <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('member_register') }}">
                    {{ __('管理') }}
                </a>登録はこちら -->

                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('management_register') }}">
                    {{ __('管理') }}
                </a>登録はこちら

            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
