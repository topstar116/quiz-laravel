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

                <div class="small-12 column examination-contents p-10">

                    <form class="js-api-form js-loading-form" action="{{ route('question.confirm') }}">
                        @csrf
                        <div class="question-group"></div>
                        <div class="mt-5 p-2">
                            <p class="bg-blue-500 p-2 text-xl text-white ">適性質問項目</p>
                        </div>
                        <div class="question-group__questions">
                            <div class="question">
                                @foreach ($resumes as $resume)
                                    <div class="question__description mt-20"></div>
                                    <div class="question__choices">
                                        <ol>
                                            <li class="my-10">
                                                <input type="radio"
                                                    value="{{ explode(',', $resume->question)[0] }}-1-{{ $resume->question_id }}"
                                                    name="{{ $resume->question_id }}-1" id="{{ $resume->id }}-1"
                                                    data-gtm-form-interact-field-id="0"
                                                    onclick="return window.scrollBy(0,300);">
                                                <label class="question__choices--label"
                                                    for="{{ $resume->question_id }}-1">{{ explode(',', $resume->question)[0] }}</label>
                                                </input>
                                            </li>
                                            <li class="my-10">
                                                <input type="radio" value="{{ explode(',', $resume->question)[1] }}-2"
                                                    name="{{ $resume->question_id }}-2" id="{{ $resume->id }}-2"
                                                    data-gtm-form-interact-field-id="1"
                                                    onclick="return window.scrollBy(0,300);">
                                                <label class="question__choices--label"
                                                    for="{{ $resume->question_id }}-2">{{ explode(',', $resume->question)[1] }}</label>
                                                </input>

                                            </li>
                                        </ol>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer">
                        </div>

                    </form>
                </div>




            </div>
        </div>
    </div>

</x-app-layout>
