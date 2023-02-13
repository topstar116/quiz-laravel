<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div style="font-size: 40px;font-weight: bolder;">新規会員登録</div>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="company" :value="__('会社名 ( 所属会社を入力してください )')" />
                ※フリーランスの方は紹介企業を入力ください

                <x-input id="company" class="block mb-5 w-full" type="text" name="company" :value="old('company')" required autofocus />
                
            </div>

            <!-- Initial Name -->
            <div>
                <x-label for="initName_f" :value="__('イニシャル名字 ( ローマ字の頭文字を入力してください )')" />
                <x-input id="initName_f" class="block mb-5 w-full" type="text" name="initName_f" :value="old('initName_f')" required autofocus />
                
            </div>

            <!-- Initial Name -->
            <div>
                <x-label for="initName_l" :value="__('イニシャル名前 ( ローマ字の頭文字を入力してください )')" />
                <x-input id="initName_l" class="block mb-5 w-full" type="text" name="initName_l" :value="old('initName_l')" required autofocus />
                
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('メールアドレス')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('パスワード確認')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('既に会員登録済み の方は こちら') }}
                </a>

                <x-button class="ml-4">
                    {{ __('同意して登録する') }}
                </x-button>
            </div>

            <input type="hidden" name="role" value="sales">
        </form>
    </x-auth-card>
</x-guest-layout>
