<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div style="font-size: 40px;font-weight: bolder;">新規会員登録</div>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Company -->
            <div>
                <x-label for="company" :value="__('企業名')" />

                <x-input id="company" class="block mb-5 w-full" type="text" name="company" :value="old('company')" required autofocus />
            </div>

            <div>
                <x-label for="pos" :value="__('役職')" />

                <select id="pos" name="pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5">
                    <option selected></option>
                    <option value="経営者">経営者</option>
                    <option value="役員">役員</option>
                    <option value="部長">部長</option>
                    <option value="一般管理">一般管理</option>
                </select>
            </div>

            <div>
                <x-label for="name" :value="__('氏名')" />

                <x-input id="name" class="block mb-5 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mb-5 w-full" type="email" name="email" :value="old('メールアドレス')" required />
            </div>

            <!-- Phone number -->
            <div class="mt-4">
                <x-label for="phone" :value="__('電話番号')" />

                <x-input id="phone" class="block mb-5 w-full" type="text" name="phone" :value="old('メールアドレス')" required />
            </div>



            <div>
                <x-label for="task" :value="__('興味のある課題・サービス')" />

                <select id="countries" name="fav_task" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5">
                    <option selected></option>
                    <option value="SES協業、人材派遣">SES協業、人材派遣</option>
                    <option value="エンジニア採用">エンジニア採用</option>
                    <option value="エンジニア状況確認">エンジニア状況確認</option>
                    <option value="IT人材営業補助">IT人材営業補助</option>
                </select>
            </div>


            <div>
                <x-label for="task" :value="__('希望内容')" />

                <textarea id="task" rows="4" name="hop_content" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5" placeholder="あれば記入ください..."></textarea>

            </div>


            <div>
                <x-label for="task" :value="__('弊社を知ったきっかけ')" />

                <select id="countries" name="knw_case" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5">
                    <option selected></option>
                    <option value="紹介・口コミ">紹介・口コミ</option>
                    <option value="SNS">SNS</option>
                    <option value="メルマガ">メルマガ</option>
                    <option value="その他">その他</option>
                </select>
            </div>

            <div>
                <x-label for="task" :value="__('その他の方は記入ください')" />

                <textarea id="task" rows="4" name="others" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="あれば記入ください..."></textarea>

            </div>



            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mb-5 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('パスワード確認')" />

                <x-input id="password_confirmation" class="block mb-5 w-full"
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
            <input type="hidden" name="role" value="company">
        </form>
    </x-auth-card>
</x-guest-layout>
