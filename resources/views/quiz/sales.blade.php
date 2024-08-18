<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">

                    <form class="js-api-form js-loading-form" data-form-name="answer_finish" id="edit_answer_finish_940649" action="https://app.mikiwame.com/api/v1/answers/940649/japanese" accept-charset="UTF-8" data-remote="true" method="post" data-gtm-form-interact-id="0">
                        <input name="utf8" type="hidden" value="✓">
                        <input type="hidden" name="_method" value="patch">

                        <div class="question-group"></div>
                        <div class="question-group__description mt-10">
                            <p>職種適正</p>
                        </div>
                        <div class="question-group__questions">

                            <div class="question">

                                @foreach($quizs as $quiz)
                                @if($quiz->項目 == '職種適正')
                                <div class="question__description mt-10"></div>
                                <div class="question__choices">
                                    <ol>
                                        <li>
                                            <input type="radio" value="" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="0">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[0] }}</label>
                                        </li>
                                        <li>
                                            <input type="radio" value="882" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="1">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[1] }}</label>
                                        </li>
                                    </ol>
                                </div>
                                @endif
                                @endforeach
                            </div>

                        </div>


                        <div class="question-group__description mt-20">
                            <p>企業適正</p>
                        </div>
                        <div class="question-group__questions">

                            <div class="question">

                                @foreach($quizs as $quiz)
                                @if($quiz->項目 == '企業適正')
                                <div class="question__description mt-10"></div>
                                <div class="question__choices">
                                    <ol>
                                        <li>
                                            <input type="radio" value="" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="0">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[0] }}</label>
                                        </li>
                                        <li>
                                            <input type="radio" value="882" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="1">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[1] }}</label>
                                        </li>
                                    </ol>
                                </div>
                                @endif
                                @endforeach
                            </div>

                        </div>



                        <div class="question-group__description mt-20">
                            <p>現状確認</p>
                        </div>
                        <div class="question-group__questions">

                            <div class="question">

                                @foreach($quizs as $quiz)
                                @if($quiz->項目 == '現状確認')
                                <div class="question__description mt-10"></div>
                                <div class="question__choices">
                                    <ol>
                                        <li>
                                            <input type="radio" value="" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="0">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[0] }}</label>
                                        </li>
                                        <li>
                                            <input type="radio" value="882" name="{{ $quiz->id }}" id="" data-gtm-form-interact-field-id="1">
                                            <label class="question__choices--label" for="">{{ explode(",",$quiz->回答項目)[1] }}</label>
                                        </li>
                                    </ol>
                                </div>
                                @endif
                                @endforeach

                            </div>

                        </div>



                        <p></p>
                        <div class="text-center">
                            <div id="answer_finish_base"></div>
                            <input type="submit" name="commit" value="回答を送信する" id="answer_submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer" data-confirm="本当に回答を送信しますか?" data-disable-with="回答を送信する" disabled="">
                        </div>
                    </form>
                </div>




            </div>
        </div>
    </div>

</x-app-layout>