<x-app-layout>
    <div class="px-4 py-10 md:px-10">
        <header class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                氏名: {{ $content['name'] }}

            </h3>
        </header>

        <section class="mt-8">
            <h4 class="text-md font-semibold mb-2">項目: 職種適性</h4>
            <h4 class="text-md">提案された適性職業 : {{ $content['result'] }}</h4>

            <h4 class="text-md mt-4">回答内容:</h4>
            <table class="w-full mx-auto border-collapse mt-2 border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">提案NO</th>
                        <th class="px-4 py-2 border">回答</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content['quiz_array'] as $key => $quiz)
                        <tr class="{{ $key % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="text-center px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $quiz }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
