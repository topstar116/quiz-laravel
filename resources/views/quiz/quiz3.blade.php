<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html {
        scroll-behavior: smooth;
    }

    .question__description:before {
        content: "Q" counter(question-counter);
    }
</style>

<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result3') }}">
                        @csrf

                        <div class="mt-5">
                            <p class="bg-blue-500 p-3 text-xl text-white font-semibold rounded-md">適性質問項目</p>
                        </div>

                        <div class="mt-8">
                            @foreach ($quizs as $quiz)
                                <div class="question-group__questions">
                                    <div class="question bg-gray-50 p-6 rounded-lg shadow-sm">
                                        <!-- Question Description -->
                                        <div class="question__description text-lg font-semibold text-gray-800">
                                            Q{{ $loop->iteration }}
                                        </div>

                                        <!-- Question Choices -->
                                        <div class="question__choices space-y-4 mt-4">
                                            <ol>
                                                <li>
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-1"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-1"
                                                        class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        onclick="window.scrollBy(0, 300);">
                                                    <label for="{{ $quiz->id }}-1"
                                                        class="question__choices--label text-gray-700 cursor-pointer">
                                                        {{ explode(',', $quiz->回答項目)[0] }}
                                                    </label>
                                                </li>
                                                <li>
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-2"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-2"
                                                        class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        onclick="window.scrollBy(0, 300);">
                                                    <label for="{{ $quiz->id }}-2"
                                                        class="question__choices--label text-gray-700 cursor-pointer">
                                                        {{ explode(',', $quiz->回答項目)[1] }}
                                                    </label>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10 text-center">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-16 rounded-full cursor-pointer shadow-md transition duration-200 ease-in-out">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
