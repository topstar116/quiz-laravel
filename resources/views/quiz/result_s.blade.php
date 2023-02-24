<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="small-12 column examination-contents p-10">


                    <div class="text-center complete-information items-center">
                        <img src="{{ asset('send.png') }}" class="m-auto mb-20">
                        
                        <h1 class="text-3xl my-20">あなたのランクは「{{ $result['type'] }}」です。</h1>                        
                        <h1 class="text-1xl my-10">{{ $result['sub_title'] }}</h1>                        

                        <p class="my-20">
                            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full cursor-pointer text-sm">トップページへ移動</a>
                        </p>

                        
                    </div>

                </div>




            </div>
        </div>
    </div>

</x-app-layout>