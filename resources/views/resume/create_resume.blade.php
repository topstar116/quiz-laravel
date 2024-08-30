<x-app-layout>

    <form class="lg:w-1/2 m-auto p-10 sm:w-full bg-white mt-10 rounded-lg" action="{{ route('resume.generator') }}"
        enctype="multipart/form-data" method="POST">
        @csrf
        <div class="p-1 text-center">
            <p class="p-10 text-2xl">{{ auth()->user()->initName_f }} {{ auth()->user()->initName_l }}さんに合いそうな職種はこちらです
            </p>
        </div>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                タイトル
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                職種説明
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($identify == 0)
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data[2] }}"
                                            class="text-blue-400 hover:underline hover:text-blue-600">
                                            {{ $result_data[0] }}
                                        </a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-normal tracking-wide leading-8 text-gray-700 flex-wrap">
                                        {{ $result_data[1] }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data->url }}"
                                            class="text-blue-400 hover:underline hover:text-blue-600">
                                            全職種
                                        </a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-normal tracking-wide leading-8 text-gray-700 flex-wrap">
                                        {{ $result_data->comment }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit"
                class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">確認</button>
        </div> --}}
    </form>

</x-app-layout>
