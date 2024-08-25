<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html {
        scroll-behavior: smooth;
    }

    .question-group__description::before {
        content: "{{ $項目 }}";
    }

    .question__description::before {
        content: "Q" counter(question-counter);
    }
</style>

<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8 examination-contents">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result3_s') }}">
                        @csrf

                        <div class="question-group">
                            <div class="question-group__description mt-8 text-gray-700 font-semibold text-lg"></div>

                            <div class="question-group__questions space-y-8">
                                @foreach ($quizs as $quiz)
                                    <div class="question bg-gray-50 p-6 rounded-lg shadow-sm">
                                        <div class="question__description text-gray-900 font-bold mt-4"></div>
                                        <div class="question__choices mt-4">
                                            <ol class="list-inside list-decimal space-y-4">
                                                @php
                                                    $options = explode(',', $quiz->回答項目);
                                                @endphp
                                                @foreach ($options as $index => $option)
                                                    <li>
                                                        <label class="flex items-center space-x-3">
                                                            <input type="radio"
                                                                value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-{{ $index + 1 }}"
                                                                name="{{ $quiz->id }}"
                                                                id="{{ $quiz->id }}-{{ $index + 1 }}"
                                                                data-gtm-form-interact-field-id="{{ $index }}"
                                                                class="form-radio text-blue-500"
                                                                onclick="return window.scrollBy(0, 300);">
                                                            <span
                                                                class="question__choices--label text-gray-600">{{ $option }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-12">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-all duration-200 ease-in-out transform hover:scale-105 cursor-pointer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
