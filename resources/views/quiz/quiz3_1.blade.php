<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html {
        scroll-behavior: smooth;
    }

    .question-group__description:before {
        content: "{{ $項目 }} - Q" counter(question-group-counter);
    }
</style>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('quiz3_2') }}">
                        @csrf

                        <div class="question-group">
                            <div class="question-group__description">
                                <!-- Here your description will be injected dynamically with the before pseudo-element -->
                            </div>

                            <div class="question-group__questions">
                                @foreach ($quizs as $quiz)
                                    @if (str_contains($quiz->提案NO, '1-'))
                                        <div class="question mt-8 p-6 bg-gray-50 rounded-lg shadow-sm">
                                            <!-- Display Question Number -->
                                            <div class="question__description text-lg font-semibold text-gray-800">

                                            </div>

                                            <!-- Display Question Choices -->
                                            <div class="question__choices mt-4">
                                                <ol>
                                                    <li class="mb-4">
                                                        <input type="radio"
                                                            value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-1"
                                                            name="{{ $quiz->id }}" id="{{ $quiz->id }}-1"
                                                            class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                            onclick="window.scrollBy(0, 300);">
                                                        <label for="{{ $quiz->id }}-1"
                                                            class="text-gray-700 cursor-pointer">
                                                            {{ explode(',', $quiz->回答項目)[0] }}
                                                        </label>
                                                    </li>
                                                    <li class="mb-4">
                                                        <input type="radio"
                                                            value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-2"
                                                            name="{{ $quiz->id }}" id="{{ $quiz->id }}-2"
                                                            class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                            onclick="window.scrollBy(0, 300);">
                                                        <label for="{{ $quiz->id }}-2"
                                                            class="text-gray-700 cursor-pointer">
                                                            {{ explode(',', $quiz->回答項目)[1] }}
                                                        </label>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-10 text-center">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer shadow-md transition duration-200 ease-in-out">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
