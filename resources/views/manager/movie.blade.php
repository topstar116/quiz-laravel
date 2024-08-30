<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="app" class="md:flex antialiased">
                    <main class="bg-gray-100 h-screen w-full overflow-y-auto p-4">
                        <section v-if="active === 'recruitment'" id="recruitment">
                            <section class="bg-white border border-gray-300 rounded-lg shadow-md">
                                <header class="border-b border-gray-300 p-4 text-lg font-semibold bg-gray-50">
                                    アカウント管理 • 動画
                                </header>
                                <section class="p-4">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        氏名
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        動画
                                                    </th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        職務経歴書
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($videoUrls as $user => $data)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                            {{ $user }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm">
                                                            @if (count($data['videos']) > 0)
                                                                <div
                                                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                                                    @foreach ($data['videos'] as $video)
                                                                        <div
                                                                            class="border rounded-lg overflow-hidden shadow-sm">
                                                                            <video controls
                                                                                class="w-full h-32 object-cover">
                                                                                <source src="{{ asset('/' . $video) }}"
                                                                                    type="video/mp4">
                                                                                Your browser does not support the video
                                                                                tag.
                                                                            </video>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p class="text-gray-600 text-center">動画がありません。</p>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3 text-sm">
                                                            <div
                                                                class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-center justify-center">
                                                                <a href="{{ $data['docs_url'] }}"
                                                                    class="w-10 h-10 flex items-center justify-center">
                                                                    <img src="{{ asset('download.png') }}"
                                                                        alt="Preview" class="w-8 h-8">
                                                                </a>
                                                                <!-- Include additional links if needed -->

                                                            </div>
                                                        </td>
                                                    </tr>
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
