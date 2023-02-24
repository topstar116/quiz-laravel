<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">
                    <form method="post" class="js-api-form js-loading-form" action="{{ route('result3_m') }}">
                        @csrf
                        <div class="question-group__questions">

                            <div class="question">

                                <p class="my-10">【感想】今回の回答についての感想や、会社や上司に伝えておきたいこと等をご記載ください。</p>
                                <textarea name="express" rows="4" class=" mb-20 block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

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