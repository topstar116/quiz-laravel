<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="md:flex antialiased">
                    <!-- Main Content Area -->
                    <main class="bg-white h-screen w-full overflow-y-auto p-6">
                        <!-- Tab Content -->
                        <div id="AIConsulting" class="tabcontent">
                            <div class="flex justify-between items-center mb-4">
                                <h1 class="text-2xl font-semibold text-gray-700">ポップアップ</h1>
                                <button onclick="openModal('addModal')"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300">
                                    追加
                                </button>
                            </div>
                            <table class="w-full border border-gray-300 rounded-lg">
                                <thead class="bg-gray-100 text-left">
                                    <tr>
                                        <th class="p-4 border-b border-gray-300 text-center whitespace-nowrap">番号</th>
                                        <th class="p-4 border-b border-gray-300 text-center whitespace-nowrap">タイトル</th>
                                        <th class="p-4 border-b border-gray-300 text-center whitespace-nowrap">メール内容
                                        </th>
                                        <th class="p-4 border-b border-gray-300 text-center whitespace-nowrap">アクション
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($email_datas as $index => $email_data)
                                        <tr id="{{ $email_data->id }}">
                                            <td class="p-4 border-b border-gray-300 whitespace-nowrap">
                                                {{ $index + 1 }}</td>
                                            <td class="p-4 border-b border-gray-300 whitespace-nowrap">
                                                {{ htmlspecialchars($email_data->title, ENT_QUOTES) }}
                                            </td>
                                            <td class="p-4 border-b border-gray-300 whitespace-nowrap">
                                                <p class="truncate w-full max-w-2xl">
                                                    {{ nl2br(htmlspecialchars($email_data->content, ENT_QUOTES)) }}
                                                </p>
                                            </td>
                                            <td class="p-4 border-b border-gray-300 whitespace-nowrap flex space-x-2">
                                                <button data-content="{{ $email_data->content }}"
                                                    data-title={{ $email_data->title }} data-id="{{ $email_data->id }}"
                                                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-300 focus:outline-none btn-modal">
                                                    編集
                                                </button>
                                                <form action="{{ route('email.delete') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="email_id"
                                                        value="{{ $email_data->id }}" />
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition duration-300 focus:outline-none">
                                                        削除
                                                    </button>
                                                </form>
                                                <form action="{{ route('email.display') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="email_id"
                                                        value="{{ $email_data->id }}" />
                                                    @if ($email_data->select == 'display')
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-yellow-300 text-white font-semibold rounded-md transition duration-300 focus:outline-none">
                                                            表示
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-yellow-700 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300 focus:outline-none">
                                                            表示
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-overlay absolute inset-0 bg-gray-800 opacity-50"></div>
        <div class="modal-content bg-white rounded-lg p-6 z-10 max-w-lg w-full">
            <h2 class="text-xl font-semibold mb-4">メールテンプレ追加</h2>
            <form action="{{ route('insert.email') }}" method="POST">
                @csrf
                <div>
                    <label class="block mb-2">タイトル</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-2" required>
                </div>
                <div class="mt-4">
                    <label class="block mb-2">メール内容</label>
                    <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg p-2" required></textarea>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal('addModal')"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md">キャンセル</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">追加</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-overlay absolute inset-0 bg-gray-800 opacity-50"></div>
        <div class="modal-content bg-white rounded-lg p-6 z-10 max-w-lg w-full">
            <h2 class="text-xl font-semibold mb-4">メールテンプレ編集</h2>
            <form action="{{ route('update.email') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="update-id" value="">
                <div>
                    <label class="block mb-2">タイトル</label>
                    <input type="text" name="title" id="update-title" value=""
                        class="w-full border border-gray-300 rounded-lg p-2" required>
                </div>
                <div class="mt-4">
                    <label class="block mb-2">メール内容</label>
                    <textarea name="content" id="update-content" rows="4" class="w-full border border-gray-300 rounded-lg p-2"
                        required></textarea>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal('updateModal')"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md">キャンセル</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">保存</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal {
            display: none;
        }

        .modal.hidden {
            display: none;
        }

        .modal.visible {
            display: flex;
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <script>
        function openModal(modalId, id, title, content) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('visible');

            if (modalId === 'updateModal') {
                document.getElementById('update-id').value = id;
                document.getElementById('update-title').value = title;
                // Ensure content is properly escaped
                document.getElementById('update-content').value = decodeURIComponent(content);
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('visible');
            document.getElementById(modalId).classList.add('hidden');
        }

        $(document).ready(function() {
            $(".btn-modal").click(function() {
                var content = $(this).attr('data-content');
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-title');
                $("#update-id").val(id);
                $("#update-title").val(title);
                $("#update-content").val(content);
                $("#updateModal").removeClass('hidden');
                $("#updateModal").addClass('visible');
            });
        });
    </script>
</x-app-layout>
