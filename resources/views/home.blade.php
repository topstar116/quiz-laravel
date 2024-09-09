<x-app-layout>
    <!-- Modal Background -->
    <div id="modal" class="fixed inset-0 bg-gray-300 bg-opacity-50 transition-opacity hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0"
                id="modal-content">
                @if (session('mail_content'))
                    @php
                        $mail_content = session('mail_content');
                        // Assuming content is a string where each sentence should be separated by a line break
                        $formattedContent = nl2br(e($mail_content->content));
                    @endphp

                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $mail_content->title }}</h2>
                    <div
                        class="alert alert-info overflow-y-auto max-h-60 border border-gray-100 rounded-lg p-4 bg-gray-50">
                        <div class="whitespace-pre-wrap text-gray-700">{!! $formattedContent !!}</div>
                    </div>
                @endif
                <div class="mt-6">
                    <button id="close-modal"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">閉じる</button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->role == 'user')
                        <div class="border border-l-8 border-blue-800 shadow rounded-lg mt-8 mb-8">
                            <h5 class="text-3xl font-bold m-5">当システムのご案内</h5>

                            <p class="text-gray-700 text-sm ml-5 mr-5 mb-8">
                                <span style="font-size: 12pt; font-weight: bolder;">職種提案を受ける</span><br />
                                <span
                                    style="font-size: 12pt;">ユーザーのキャリア方向性を具体的に示すことで、効果的な転職やキャリアアップをサポートします。</span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">職種一覧を見る</span><br />
                                <span
                                    style="font-size: 12pt;">業界ごとの分類や職種の詳細情報、求められるスキル、給与範囲などが表示されており、ユーザーは自分の興味や経験に合った職種を自由に探索することができます。
                                    参考リンク出典：job tag（厚生労働省職業情報提供サイト（日本版O-NET））</span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">経歴書作成</span><br />
                                <span
                                    style="font-size: 12pt;">生成AIを使用した職務経歴書を作成します。質問に答えるだけで高品質な応募書類が出来上がります！</span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">業務適性検査を受ける</span><br />
                                <span
                                    style="font-size: 12pt;">ユーザーの性格、スキル、働き方のスタイルを分析します。これによって企業側に適切な情報が提供されます。</span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">応募書類提出</span><br />
                                <span style="font-size: 12pt;">
                                    作成した経歴書に加えて1分動画を企業へ提出することで、面接前に自分の強みをアピールできます。</span><br />
                            </p>
                        </div>
                    @elseif (Auth::user()->role == 'admin')
                        <div class="border border-l-8 border-blue-800 shadow rounded-lg mt-8 mb-8">
                            <h5 class="text-3xl font-bold m-5">管理画面のご案内</h5>

                            <p class="text-gray-700 text-sm ml-5 mr-5 mb-8">
                                <span style="font-size: 12pt; font-weight: bolder;">管理ページ</span><br />
                                <span style="font-size: 12pt;">提案職種と質問回答データを取得できます</span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">応募書類</span><br />
                                <span style="font-size: 12pt;">履歴書、職務経歴書、1分自己PR動画を取得出来ます
                                </span><br />
                                <br />
                                <span style="font-size: 12pt; font-weight: bolder;">ポップアップ</span><br />
                                <span style="font-size: 12pt;">求職者に伝えたい内容を事前通知出来ます</span><br />
                                <br />
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Custom Scrollbar Styles */
        .alert {
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: #4F46E5 #E5E7EB;
            /* For Firefox: thumb color and track color */
        }

        .alert::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
        }

        .alert::-webkit-scrollbar-track {
            background: #E5E7EB;
            /* Track color */
            border-radius: 10px;
            /* Rounded corners */
        }

        .alert::-webkit-scrollbar-thumb {
            background-color: #4F46E5;
            /* Thumb color */
            border-radius: 10px;
            /* Rounded corners */
            border: 2px solid #E5E7EB;
            /* Space between track and thumb */
        }

        .alert::-webkit-scrollbar-thumb:hover {
            background-color: #4338CA;
            /* Darker thumb color on hover */
        }
    </style>

    <script>
        // Show the modal if there is a session message
        document.addEventListener('DOMContentLoaded', function() {
            // Check if mail_content exists in the session
            const mailContentExists = @json(session('mail_content') !== null);
            // Check if the user is authenticated and not an admin
            const isAdmin = @json(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'company'));


            if (mailContentExists && !isAdmin) {
                const modal = document.getElementById('modal');
                const modalContent = document.getElementById('modal-content');

                modal.classList.remove('hidden');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }
        });


        // Close modal functionality
        document.getElementById('close-modal').addEventListener('click', function() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });
    </script>
</x-app-layout>
