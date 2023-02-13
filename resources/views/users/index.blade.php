<x-app-layout>
  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">  

                    <font size =6 color = "black "> 
                        ユーザー管理
                    </font>

                    <!-- Validation Errors -->
                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <form method="GET" action="{{ route('add.user') }}" class="flex flex-row my-10">
                        @csrf

                        <!-- Name -->
                        <div class="w-1/3">
                            <x-label for="name" :value="__('名前')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="w-1/3 mx-5">
                            <x-label for="email" :value="__('メールアドレス')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!-- Password -->
                        <div class="w-1/3">
                            <x-label for="password" :value="__('パスワード')" />

                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" disabled value="xxxxxxxxxx"/>
                        </div>                        

                        <div class="flex items-center justify-end mt-4 w-1/6 mx-5">
                            <x-button class="ml-4">
                                {{ __(' 登録') }}
                            </x-button>
                        </div>
                    </form>

                    <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                            >#
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                            >
                                名前
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                            >
                                メールアドレス
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                            >
                                パスワード
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                            >
                                削除
                            </th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php $cnt = 1; ?>
                            @foreach($users as $user)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-600 whitespace-no-wrap">{{ $cnt++ }}</p>
                                </td> 
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-600 whitespace-no-wrap">{{ $user->name }}</p>
                                </td> 
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $user->pwd }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <form method="GET" action="{{ route('del.user') }}">
                                        @csrf
                                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="relative">削除</button>
                                        </span>
                                    </form>
                                </td>                            
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $users->links() }}
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

