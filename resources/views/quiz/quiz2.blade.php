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

                <div class="p-10">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result2') }}">
                        @csrf

                        <!-- Question Group Description Placeholder -->
                        <div class="question-group__description mb-8">
                            <p class="text-xl font-semibold text-gray-800"></p>
                        </div>

                        <!-- Questions Section -->
                        <div class="question-group__questions space-y-8">
                            @foreach ($quizs as $quiz)
                                <div class="question bg-gray-50 p-6 rounded-md shadow-sm">
                                    <!-- Question Title -->
                                    <div class="question__description text-lg font-semibold text-gray-800">

                                    </div>

                                    <!-- Choices for each question -->
                                    <div class="question__choices mt-4">
                                        <ol class="space-y-4">
                                            @foreach (explode(',', $quiz->回答項目) as $index => $answer)
                                                <li>
                                                    <label class="flex items-center space-x-3">
                                                        <input type="radio"
                                                            value="{{ $quiz->項目 }}-{{ $quiz->提案NO }}-{{ $index + 1 }}"
                                                            name="{{ $quiz->id }}"
                                                            id="{{ $quiz->id }}-{{ $index + 1 }}"
                                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                            onclick="window.scrollBy(0,300);">
                                                        <span class="text-gray-700">{{ $answer }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-12 text-center">
                            <input type="submit" value="回答を送信する"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-16 rounded-full transition duration-200 ease-in-out transform hover:scale-105 cursor-pointer">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
