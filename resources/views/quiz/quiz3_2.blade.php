<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html {
        scroll-behavior: smooth;
    }

    .question-group__description:before {
        content: "{{ $項目 }}";
    }

    .question__description:before {
        content: "Q" counter(question-counter);
    }
</style>

<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">

                    <form method="post" class="js-api-form js-loading-form" action="{{ route('quiz3_3') }}">
                        @csrf
                        <div class="question-group"></div>

                        <div class="question-group__description mb-8">

                        </div>

                        <div class="question-group__questions space-y-8">
                            @foreach ($quizs as $quiz)
                                @if (str_contains($quiz->提案NO, '2-'))
                                    <div class="mt-10 p-6 bg-gray-50 rounded-md shadow-md">
                                        <div class="question__description text-lg font-semibold text-gray-800 mb-4">

                                        </div>
                                        <div class="question__choices mt-4">
                                            <ol class="space-y-4">
                                                <li class="flex items-center space-x-3">
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-1"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-1"
                                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                                        onclick="window.scrollBy(0, 300);">
                                                    <label class="ml-3 text-gray-700 cursor-pointer"
                                                        for="{{ $quiz->id }}-1">
                                                        {{ explode(',', $quiz->回答項目)[0] }}
                                                    </label>
                                                </li>
                                                <li class="flex items-center space-x-3">
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-2"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-2"
                                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                                        onclick="window.scrollBy(0, 300);">
                                                    <label class="ml-3 text-gray-700 cursor-pointer"
                                                        for="{{ $quiz->id }}-2">
                                                        {{ explode(',', $quiz->回答項目)[1] }}
                                                    </label>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-12 text-center">
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-16 rounded-full transition duration-200 ease-in-out transform hover:scale-105 cursor-pointer shadow-lg">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
