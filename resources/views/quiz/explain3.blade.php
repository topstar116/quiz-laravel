<x-app-layout>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h5 class="text-3xl font-bold m-5">適性検査の構成と注意点</h5>

                    <ul class="list-decimal p-6 my-10">
                        <li class="my-2">本適性検査は 実施環境アンケート、能力適性検査、性格適性検査の 3つから成ります。 （能力適性検査、または性格適性検査どちらか一方のみの受検の場合は、受検する一方のみが表示されます）。</li>
                        <li class="my-2">練習問題の後、実施環境アンケートから始まります。</li>
                        <li class="my-2">実施環境アンケートが完了すると能力適性検査に、能力適性検査が完了すると性格適性検査に進みます。</li>
                        <li class="my-2">実施環境アンケートはご自身が回答に使用しているデバイスや環境を選択します。</li>
                        <li class="my-2">能力適性検査の制限時間は20分。選択肢の中から回答を選択します。</li>
                        <li class="my-2">性格適性検査については標準回答時間が10分。各質問項目について、5段階で自分自身を評定します。なお、本検査を過去に受検した方は性格適性検査はありません。</li>
                    </ul>


                    <div class="border border-l-8 border-blue-800 shadow rounded-lg mt-8 mb-8">
                        <h5 class="text-2xl font-bold m-5 text-pink-500">注意点</h5>

                        <ul class="list-disc p-6">
                            <li class="my-2">実施環境アンケートの開始ボタンを押すと検査開始 です。一度検査を開始したら実施環境アンケート、性格適性検査の全てを連続して終了させてください。途中で終えた場合は、その時点で検査が終了になります。全てが完了する目安時間は10分程度です。</li>
                            <li class="my-2">検査開始途中でGoogle ChromeやSafariなどのブラウザの「閉じるボタン」、「戻るボタン」、「更新ボタン」を押さないでください。 押した場合、検査がその時点で終了 してしまいますのでご注意ください。</li>
                            <li class="my-2">スマートフォンで受検可能です。その場合は、設定から 自動ロックをオフ にすることをお勧めします。検査に集中するためです。</li>
                            <li class="my-2">もし、トラブルにより正しく受検できなかった場合は、 よくある質問 をご覧ください。</li>
                        </ul>

                    </div>

                    <div style="text-align: center;">
                        <a href="{{ route('quiz3') }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-10 rounded-full">実施環境アンケートを始める</button>
                        </a>
                    </div>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>