<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">


                    <div class="text-center complete-information items-center">
                        <img src="{{ asset('send.png') }}" class="m-auto">
                        <h1 class="text-3xl">回答を受け付けました</h1>
                        <p class="text-2xl">
                            お疲れさまでした。
                            <br>
                            エントリー企業に結果を送信しました。
                        </p>
                        <p>
                            <br>
                            <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer">トップページへ</a>
                        </p>
                    </div>

                </div>




            </div>
        </div>
    </div>

</x-app-layout>