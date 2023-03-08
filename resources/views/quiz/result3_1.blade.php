<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">


                    <div class="text-center complete-information items-center">
                        <img src="{{ asset('send.png') }}" class="m-auto mb-20">
                        <h1 class="text-2xl my-20">あなたのおすすめ進路は「{{ $result['sub_title'] }}」です。</h1>
                        <a  href="{{ $result['url'] }}" target="_blank"><h1 class="text-1xl underline">ページから確認してみましょう</h1></a>
                        <p class="my-20">                            
                            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full cursor-pointer text-sm">トップページへ移動</a>
                        </p>
                       
                    </div>

                </div>




            </div>
        </div>
    </div>

</x-app-layout>