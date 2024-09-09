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
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white sm:p-10">
                    <form class="js-api-form js-loading-form" action="{{ route('question.confirm') }}" method="POST">
                        @csrf
                        <div class="my-5">
                            <p class="bg-blue-500 p-4 text-xl text-white font-semibold rounded-lg shadow-md">
                                適性質問項目
                            </p>
                        </div>

                        <div class="question-group__questions space-y-8">
                            @foreach ($resumes as $resume)
                                <div class="question bg-gray-50 p-6 rounded-lg shadow-sm">
                                    <div class="question__description text-lg font-semibold text-gray-800">
                                        {{-- Description Content Here --}}
                                    </div>
                                    <div class="question__choices mt-4">
                                        <ol class="space-y-4">
                                            @foreach (explode(',', $resume->question) as $index => $option)
                                                <li>
                                                    <input type="radio"
                                                        value="{{ $option }}-{{ $index + 1 }}-{{ $resume->question_id }}"
                                                        name="{{ $resume->question_id }}"
                                                        id="{{ $resume->id }}-{{ $index + 1 }}"
                                                        class="mr-2 cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        onclick="return window.scrollBy(0,300);">
                                                    <label for="{{ $resume->id }}-{{ $index + 1 }}"
                                                        class="text-gray-700 cursor-pointer">
                                                        {{ $option }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12 text-center">
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-16 rounded-full cursor-pointer shadow-md transition-transform transform hover:scale-105 duration-200 ease-in-out">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
