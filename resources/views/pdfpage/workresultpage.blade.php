<x-app-layout>
    <div class="px-4 md:px-10 mt-10  py-10 md:max-w-5xl m-auto bg-white">
        <header class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                氏名: {{ $content['name'] }}
                <span class="text-sm text-gray-500">回答日: {{ $content['created_at'] }}</span>
            </h3>
        </header>

        @foreach ([$content['quiz1'], $content['quiz2'], $content['quiz3']] as $index => $quiz)
            @if ($quiz != '')
                <section class="mt-8">
                    <h4 class="text-md font-semibold">項目: {{ explode('-', $quiz)[0] }}</h4>
                    <table class="w-full mx-auto border-collapse mt-2">
                        <tbody>
                            @php $cnt = 0; @endphp
                            @foreach (explode(',', $quiz) as $quizItem)
                                <tr class="border-b">
                                    <td class="text-center py-2">{{ ++$cnt }}</td>
                                    <td class="py-2 pl-4">{{ $content['quiz_array'][trim($quizItem)] ?? '未回答' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4 class="mt-4 pl-2">
                        {{ explode('-', $quiz)[0] }}回答結果: {{ $content['res' . ($index + 1)] }}
                    </h4>
                </section>
            @endif
        @endforeach
    </div>
</x-app-layout>
