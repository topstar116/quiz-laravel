<x-app-layout>
    <div class="px-10  mt-10  py-10 md:max-w-5xl m-auto bg-white">
        <header class="flex justify-between items-center pt-10">
            <h3 class="text-lg font-semibold">
                氏名: {{ $name }}
                <span class="text-sm text-gray-500">回答日: {{ $created_at }}</span>
            </h3>
        </header>

        @foreach ([$quiz1, $quiz2, $quiz3] as $index => $quiz)
            @if ($quiz != '')
                <section class="mt-8">
                    <h4 class="text-md font-semibold mb-2">項目: {{ explode('-', $quiz)[0] }}</h4>
                    <table class="w-4/5 mx-auto border-collapse">
                        <tbody>
                            @foreach (explode(',', $quiz) as $key => $quizItem)
                                <tr class="border-b">
                                    <td class="text-center py-2">{{ $key + 1 }}</td>
                                    <td class="pl-4 py-2">{{ $quiz_array[trim($quizItem)] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4 class="mt-4 pl-2">
                        {{ $type == 'recruiment' ? '提案№' : ($type == 'sales' ? 'ランク' : '状況') }}:
                        {{ ${'no' . ($index + 1)} }}
                        &nbsp;&nbsp;{{ $type == 'recruiment' ? 'お勧め進路' : '説明概要' }}: {{ ${'res' . ($index + 1)} }}
                    </h4>
                </section>
            @endif
        @endforeach

        @if ($type == 'management')
            <section class="mt-8">
                <h4 class="text-md font-semibold">【感想】</h4>
                <h5 class="mt-2 mb-4 p-2 border rounded bg-gray-100">{{ $express }}</h5>
            </section>
        @endif
    </div>
</x-app-layout>
