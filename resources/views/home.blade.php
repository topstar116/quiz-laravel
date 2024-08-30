<x-app-layout>
    <!-- Modal Background -->
    <div id="modal" class="fixed inset-0 bg-gray-300 bg-opacity-50 transition-opacity hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0"
                id="modal-content">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">ようこそ</h2>
                @if (session('mail_content'))
                    <div
                        class="alert alert-info overflow-y-auto max-h-60 border border-gray-100 rounded-lg p-4 bg-gray-50">
                        @php
                            // Split the content by "。" and keep it while adding a line break
                            $content = session('mail_content');
                            $formattedContent = implode('。', explode('。', $content));
                        @endphp
                        <div class="whitespace-pre-wrap text-gray-700">{{ $formattedContent }}</div>
                    </div>
                @endif
                <div class="mt-6">
                    <button id="close-modal"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="border border-l-8 border-blue-800 shadow rounded-lg mt-8 mb-8">
                        <h5 class="text-3xl font-bold m-5">当システムのご案内</h5>

                        <p class="text-gray-700 text-sm ml-5 mr-5 mb-8">
                            <span style="font-size: 12pt; font-weight: bolder;">1. 職種提案を受ける</span><br />
                            <span style="font-size: 12pt;">ユーザーのキャリア方向性を具体的に示すことで、効果的な転職やキャリアアップをサポートします。</span><br />
                            <br />
                            <span style="font-size: 12pt; font-weight: bolder;">2. 職種一覧を見る</span><br />
                            <span
                                style="font-size: 12pt;">業界ごとの分類や職種の詳細情報、求められるスキル、給与範囲などが表示されており、ユーザーは自分の興味や経験に合った職種を自由に探索することができます。
                                参考リンク出典：job tag（厚生労働省職業情報提供サイト（日本版O-NET））</span><br />
                            <br />
                            <span style="font-size: 12pt; font-weight: bolder;">3. 経歴書作成</span><br />
                            <span style="font-size: 12pt;">生成AIを使用した職務経歴書を作成します。質問に答えるだけで高品質な応募書類が出来上がります！</span><br />
                            <br />
                            <span style="font-size: 12pt; font-weight: bolder;">3. 業務適性検査を受ける</span><br />
                            <span
                                style="font-size: 12pt;">ユーザーの性格、スキル、働き方のスタイルを分析します。これによって企業側に適切な情報が提供されます。</span><br />
                            <br />
                            <span style="font-size: 12pt; font-weight: bolder;">4. 自己PR動画撮影する</span><br />
                            <span style="font-size: 12pt;">
                                この動画を企業へ提出することで、面接前に自分の強みをアピールするツールとして活用できます。</span><br />
                        </p>
                    </div>
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
            const isAdmin = @json(auth()->check() && auth()->user()->role === 'admin');

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
