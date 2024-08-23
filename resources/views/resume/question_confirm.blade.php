<x-app-layout>
    <div class="lg:w-1/2 m-auto p-10 sm:w-full bg-white mt-10 rounded-lg">
        <div class="text-center p-1">
            <p class="text-2xl p-10">
                {{ auth()->user()->initName_f }} {{ auth()->user()->initName_l }}さんに合いそうな職種はこちらです
            </p>
        </div>
        <div class="space-y-12">
            <div class="pb-12 border-b border-gray-300">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                タイトル
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                職種説明
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($identify == 0)
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data[2] }}" class="text-blue-500 hover:underline">
                                            {{ $result_data[0] }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-gray-700">
                                        {{ $result_data[1] }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data->url }}" class="text-blue-500 hover:underline">
                                            {{ $result_data->job }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-gray-700">
                                        {{ $result_data->comment }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
