<link rel="stylesheet" href="{{ asset('css/mikiwa.css') }}">

<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8 examination-contents">
                    <div class="text-center complete-information">
                        <img src="{{ asset('send.png') }}" class="mx-auto mb-10 w-24 h-24">

                        @if ($next == 2)
                            <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                                あなたの状況は「{{ $result['sub_type'] }}」です。</h1>
                            <h2 class="text-xl text-gray-600 mb-10">{{ $result['sub_title'] }}</h2>
                            <a href="{{ route('quiz2_m') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">
                                次へ
                            </a>
                        @elseif ($next == 3)
                            <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                                あなたの状況は「{{ $result['sub_type'] }}」です。</h1>
                            <h2 class="text-xl text-gray-600 mb-10">{{ $result['sub_title'] }}</h2>
                            <a href="{{ route('quiz3_m') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">
                                次へ
                            </a>
                        @else
                            <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                                あなたの状況は「{{ $result['sub_type'] }}」です。</h1>
                            <h2 class="text-xl text-gray-600 mb-10">{{ $result['sub_title'] }}</h2>
                            <a href="https://engineer-match-recommend-result.com/tekisei/"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-10 rounded-lg shadow-md transition duration-300">
                                トップページへ移動
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
