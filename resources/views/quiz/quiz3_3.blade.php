<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">
<style>
    html{
        scroll-behavior: smooth;
    }
    .question-group__description:before {
        content: "{{ $項目 }} - Q"counter(question-group-counter);
    }
</style>
<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">

                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result3_1') }}">

                        @csrf

                        <div class="question-group"></div>
                        <div class="question-group__description opacity-0" style="height: 0;"></div>
                        <div class="question-group__description opacity-0" style="height: 0;"></div>

                        <div class="question-group__description">
                        </div>

                        <div class="question-group__questions">

                            <div class="question">

                                @foreach($quizs as $quiz)
                                @if(str_contains($quiz->提案NO, '3-'))
                                <div class="question__description mt-20"></div>
                                <div class="question__choices">
                                    <ol>
                                        <li class="my-10">
                                            <input type="radio" value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-1" name="{{ $quiz->id }}" id="{{ $quiz->id }}-1" data-gtm-form-interact-field-id="0" onclick="return window.scrollBy(0,300);">
                                            <label class="question__choices--label" for="{{ $quiz->id }}-1">{{ explode(",",$quiz->回答項目)[0] }}</label>
                                        </li>
                                        <li class="my-10">
                                            <input type="radio" value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-2" name="{{ $quiz->id }}" id="{{ $quiz->id }}-2" data-gtm-form-interact-field-id="1" onclick="return window.scrollBy(0,300);">
                                            <label class="question__choices--label" for="{{ $quiz->id }}-2">{{ explode(",",$quiz->回答項目)[1] }}</label>
                                        </li>
                                    </ol>
                                </div>
                                @endif
                                @endforeach
                            </div>

                        </div>

                        <div class="text-center">
                            <div id="answer_finish_base"></div>
                            <input type="submit" value="回答を送信する" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer">
                        </div>
                    </form>
                </div>




            </div>
        </div>
    </div>

</x-app-layout>