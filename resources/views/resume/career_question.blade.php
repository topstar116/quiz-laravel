<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html {
        scroll-behavior: smooth;
    }

    .question__description:before {
        content: "Q" counter(question-counter);
    }
</style>
<script></script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-gray-50">
                    <form class="js-api-form js-loading-form" action="{{ route('question.confirm') }}" method="POST">
                        @csrf
                        <div class="mt-5">
                            <p class="bg-blue-500 p-3 text-xl text-white font-semibold rounded-md">適性質問項目</p>
                        </div>
                        <div class="mt-8 space-y-10">
                            @foreach ($resumes as $resume)
                                <div class="question-group__questions">
                                    <div class="question">
                                        <div class="question__description mt-8 text-lg font-semibold text-gray-800">
                                        </div>
                                        <div class="question__choices mt-4 space-y-4">
                                            <ol>
                                                <li>
                                                    <input type="radio"
                                                        value="{{ explode(',', $resume->question)[0] }}-1-{{ $resume->question_id }}"
                                                        name="{{ $resume->question_id }}" id="{{ $resume->id }}-1"
                                                        class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        onclick="return window.scrollBy(0,300);">
                                                    <label for="{{ $resume->id }}-1"
                                                        class="question__choices--label text-gray-700 cursor-pointer">
                                                        {{ explode(',', $resume->question)[0] }}
                                                    </label>
                                                </li>
                                                <li>
                                                    <input type="radio"
                                                        value="{{ explode(',', $resume->question)[1] }}-2"
                                                        name="{{ $resume->question_id }}" id="{{ $resume->id }}-2"
                                                        class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        onclick="return window.scrollBy(0,300);">
                                                    <label for="{{ $resume->id }}-2"
                                                        class="question__choices--label text-gray-700 cursor-pointer">
                                                        {{ explode(',', $resume->question)[1] }}
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
