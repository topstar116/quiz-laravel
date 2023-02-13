<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('プロフィール') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-validation-errors class="mb-4" :errors="$errors"/>

                    <x-alert.success></x-alert.success>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-label for="name" :value="__('名前')"/>

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                     :value="old('name', auth()->user()->name)" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="email" :value="__('メールアドレス')"/>

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                     :value="old('email', auth()->user()->email)" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="password" :value="__('パスワード')"/>

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('パスワード確認')"/>

                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                     name="password_confirmation" required/>
                        </div>

                        <x-button class="mt-4">
                            {{ __('Submit') }}
                        </x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
