<x-app-layout>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div id="app" class="md:flex antialiased">
                    @include('layouts.admin')
                    <main class="bg-white-100 h-screen w-full overflow-y-auto">

                        <section v-if="active === 'recruiment'" id="recruiment">
                            <section class="bg-white border border-gray-300 border-solid rounded shadow">
                                <header class="border-b border-solid border-gray-300 p-4 text-lg font-medium">
                                    ユーザー管理•管理
                                </header>
                                <section
                                    class=" flex flex-row flex-wrap items-center text-center border-b border-solid border-gray-300">

                                    <div class="inline-block min-w-full shadow-md rounded-lg overflow-x-auto">
                                        <table class="min-w-full leading-normal" style="width: 2048px;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        #
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        企業名
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        役職
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        氏名
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        メールアドレス
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        電話番号
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        興味のある課題・サービス
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        希望内容
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        弊社を知ったきっかけ
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        その他の方は記入ください
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $cnt = 1; ?>
                                                @foreach ($users as $user)
                                                    @if ($user->role == 'management')
                                                        <tr>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $cnt++ }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->company }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->pos }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->name }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->email }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->phone }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->fav_task }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-no-wrap">
                                                                    {{ $user->hop_content }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-900 whitespace-no-wrap">
                                                                    {{ $user->knw_case }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-900 whitespace-no-wrap">
                                                                    {{ $user->others }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <form method="GET" action="{{ route('del.user') }}">
                                                                    @csrf
                                                                    <span
                                                                        class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                                        <span aria-hidden
                                                                            class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $user->id }}">
                                                                        <input type="hidden" name="level"
                                                                            value="management">
                                                                        <button type="submit" class="relative"
                                                                            onclick="return confirm('削除しますか？');">削除</button>
                                                                    </span>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </section>

                            </section>
                        </section>

                    </main>

                </div>



















            </div>
        </div>
    </div>
</x-app-layout>
