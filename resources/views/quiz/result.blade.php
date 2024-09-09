<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-center p-8 examination-contents">
                    <img src="{{ asset('send.png') }}" class="mx-auto mb-10 w-24 h-24">
                    @if ($next == 2)
                        <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                            あなたの適性は「{{ $result['type'] }}」（{{ $result['sub_title'] }}）です。
                        </h1>
                        <a href="{{ $result['url'] }}" target="_blank">
                            <h1 class="text-xl underline text-gray-600 mb-10">ページから確認してみましょう</h1>
                        </a>
                        <a href="{{ route('quiz2') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">次へ</a>
                    @elseif($next == 3)
                        <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                            あなたの適性は「{{ $result['type'] }}」（{{ $result['sub_title'] }}）です。
                        </h1>
                        <a href="{{ $result['url'] }}" target="_blank">
                            <h1 class="text-xl text-gray-600 mb-10">ページから確認してみましょう</h1>
                        </a>
                        <a href="{{ route('quiz3_1') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">次へ</a>
                    @else
                        <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                            あなたの適性は「{{ $result['type'] }}」（{{ $result['sub_title'] }}）です。
                        </h1>
                        <a href="{{ $result['url'] }}" target="_blank">
                            <h1 class="text-xl text-gray-600 mb-10">ページから確認してみましょう</h1>
                        </a>
                        <a href="/"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">トップページへ移動</a>
                    @endif

                </div>

            </div>




        </div>
    </div>
    </div>

</x-app-layout>
