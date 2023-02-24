<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">


                    <div class="text-center complete-information items-center">
                        <img src="{{ asset('send.png') }}" class="m-auto mb-20">
                        @if(Auth::user()->role == 'recruiment')
                        <!-- <h1 class="text-3xl my-20">あなたの適性は{{ $result['type'] }}（提案No.{{ $result['sub_type'] }} {{ $result['sub_title'] }}）です。</h1> -->
                        <h1 class="text-3xl my-20">あなたの適性は「{{ $result['type'] }}」（{{ $result['sub_title'] }}）です。</h1>
                        
                        <p class="my-20">
                            <a href="{{ $result['url'] }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full cursor-pointer">ページから確認してみましょう</a>
                        </p>
                        @elseif(Auth::user()->role == 'sales')
                        <h1 class="text-3xl my-20">あなたのランクは「{{ $result['type'] }}」です。</h1>                        
                        <h1 class="text-2xl my-20">{{ $result['sub_title'] }}</h1>                        

                        <p class="my-20">
                            <a href="" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full cursor-pointer">トップページへ移動</a>
                        </p>

                        @elseif(Auth::user()->role == 'management')
                        <h1 class="text-3xl my-20">あなたの状況は「{{ $result['type'] }}」です。</h1>
                        <h1 class="text-2xl my-20">{{ $result['sub_title'] }}</h1>
                        <h1 class="text-2xl my-20">おすすめ進路は{{ $result['sub_type'] }}</h1>
                        
                        <p class="my-20">
                            <a href="" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full cursor-pointer">トップページへ移動</a>
                        </p>
                        @endif
                    </div>

                </div>




            </div>
        </div>
    </div>

</x-app-layout>