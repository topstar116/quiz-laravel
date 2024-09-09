<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 sm:p-8 bg-white mt-10 rounded-lg shadow-md">
        <div class="text-center mb-8">
            <p class="text-3xl font-semibold text-gray-800">
                あなたに合いそうな職種はこちらです
            </p>
        </div>
        <div class="space-y-8">
            <div class="border-b border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">
                                種類
                            </th>
                            <th scope="col"
                                class="px-4 py-2 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">
                                職種説明
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($identify == 0)
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-4 py-4 text-left">
                                        <a href="{{ $result_data[2] }}" class="text-blue-600 hover:underline">
                                            {{ $result_data[0] }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-gray-700">
                                        {{ $result_data[1] }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-4 py-4 text-left">
                                        <a href="{{ $result_data->url }}" class="text-blue-600 hover:underline">
                                            {{ $result_data->title }} <!-- Adjusted from '職種' -->
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-gray-700">
                                        {{ $result_data->comment }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        業界に特化した職種提案も受けてみよう！
                    </h2>
                    <a href="" class="text-blue-600 hover:underline">
                        <span>IT・通信のエンジニアはこちら</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
