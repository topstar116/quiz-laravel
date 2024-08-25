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
                <div class="examination-contents p-8">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result3_m') }}">
                        @csrf

                        <div class="question-group">
                            <div class="question-group__description mb-6">
                                <!-- Description content -->
                            </div>
                            <div class="question-group__questions space-y-8">
                                @foreach ($quizs as $quiz)
                                    <div class="question bg-gray-50 p-6 rounded-lg shadow-sm">
                                        <div class="question__description text-lg font-semibold mb-4"></div>
                                        <div class="question__choices">
                                            <ol class="list-none space-y-4">
                                                <li>
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-1"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-1"
                                                        class="mr-2" data-gtm-form-interact-field-id="0"
                                                        onclick="return window.scrollBy(0, 300);">
                                                    <label class="question__choices--label text-gray-700 cursor-pointer"
                                                        for="{{ $quiz->id }}-1">
                                                        {{ explode(',', $quiz->回答項目)[0] }}
                                                    </label>
                                                </li>
                                                <li>
                                                    <input type="radio"
                                                        value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-2"
                                                        name="{{ $quiz->id }}" id="{{ $quiz->id }}-2"
                                                        class="mr-2" data-gtm-form-interact-field-id="1"
                                                        onclick="return window.scrollBy(0, 300);">
                                                    <label class="question__choices--label text-gray-700 cursor-pointer"
                                                        for="{{ $quiz->id }}-2">
                                                        {{ explode(',', $quiz->回答項目)[1] }}
                                                    </label>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-12">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-300 cursor-pointer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
