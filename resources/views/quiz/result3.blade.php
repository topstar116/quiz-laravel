<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">


                    <div class="text-center complete-information items-center">
                        <img src="{{ asset('send.png') }}" class="m-auto mb-20">

                        <h1 class="text-3xl my-20">あなたの「おすすめ進路は{{ $result['sub_title'] }}」です。</h1>
                        
                        <p class="my-20">
                            <a href="{{ $result['url'] }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-20 rounded-full cursor-pointer">ページから確認してみましょう</a>
                        </p>
                    </div>

                </div>




            </div>
        </div>
    </div>

</x-app-layout>