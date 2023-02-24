<x-app-layout>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h5 class="text-3xl font-bold m-5">適性検査の構成と注意点</h5>

                    <ul class="list-decimal p-6 my-5 ml-5">
                        @if(Auth::user()->role == 'recruiment')
                        <!-- <li class="my-2">本適性検査は職種、企業、おすすめ進路の 3つから成ります。</li> -->
                        <li class="my-2">適性検査については標準回答時間が10分。各質問項目について、二択で自分自身を評定します。</li>
                        @elseif(Auth::user()->role == 'sales')
                        <!-- <li class="my-2">本適性検査はPJ適性、コミュニケーション、リーダー適性の 3つから成ります。</li> -->
                        <li class="my-2">適性検査については標準回答時間が10分。各質問項目について、二択で自分自身を評定します。</li>
                        @elseif(Auth::user()->role == 'management')
                        <!-- <li class="my-2">本適性検査は仕事内容、人間関係、業務負担の 3つから成ります。</li> -->
                        <li class="my-2">適性検査については標準回答時間が10分。各質問項目について、二択で自分自身を評定します。</li>
                        @endif
                    </ul>

                    <div class="border border-l-8 border-blue-800 shadow rounded-lg mt-8 mb-8">
                        <h5 class="text-2xl font-bold m-5 text-pink-500">注意点</h5>

                        <ul class="list-disc p-6 ml-5">
                            <li class="my-2">実施環境アンケートの開始ボタンを押すと検査開始 です。一度検査を開始したら全てを連続して終了させてください。全てが完了する目安時間は10分程度です。</li>
                            <li class="my-2">検査開始途中でGoogle ChromeやSafariなどのブラウザの「閉じるボタン」、「戻るボタン」、「更新ボタン」を押さないでください。 押した場合、やり直しになってしまいますのでご注意ください。</li>
                        </ul>

                    </div>

                    <div style="text-align: center;">
                        <a href="{{ route('quiz3_1') }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full">実施環境アンケートを始める</button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>