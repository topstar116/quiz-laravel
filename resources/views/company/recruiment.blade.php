<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-4xl font-bold text-black mb-6">採用</h1>

                    <!-- Validation Errors -->
                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <div class="inline-block w-full overflow-x-auto shadow-md rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-md font-semibold uppercase tracking-wider">番号
                                    </th>
                                    <th class="px-6 py-3 text-left text-md font-semibold uppercase tracking-wider">名前
                                    </th>
                                    <th class="px-6 py-3 text-left text-md font-semibold uppercase tracking-wider">
                                        メールアドレス</th>
                                    <th class="px-6 py-3 text-left text-md font-semibold uppercase tracking-wider">採用状況
                                    </th>
                                    <th class="px-6 py-3 text-left text-md font-semibold uppercase tracking-wider">アクション
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $cnt = 1; @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $cnt++ }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="hidden sm:block">
                                                @if ($user->recruiment_state == 'true')
                                                    <img src="{{ asset('recruiment.png') }}" alt="採用済み"
                                                        class="w-12 h-12">
                                                @else
                                                    <img src="{{ asset('no-recruiment.png') }}" alt="未採用"
                                                        class="w-12 h-12">
                                                @endif
                                            </div>
                                            <div class="block sm:hidden">
                                                @if ($user->recruiment_state == 'true')
                                                    <div class="w-5 h-5 bg-green-500 rounded-full shadow-green"></div>
                                                @else
                                                    <div class="w-5 h-5 bg-red-500 rounded-full shadow-red"></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex space-x-4">
                                                <form method="POST" action="{{ route('recruimenting') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <button type="submit"
                                                        @if ($user->recruiment_state == 'true') disabled @endif
                                                        class="px-3 py-1 font-semibold text-white bg-green-500 hover:bg-green-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 
                                                        @if ($user->recruiment_state == 'true') opacity-50 cursor-not-allowed @endif">
                                                        採用
                                                    </button>
                                                </form>


                                                <button type="button" @if ($user->recruiment_state == 'true') disabled @endif
                                                    class="px-3 py-1 font-semibold text-white bg-blue-500 hover:bg-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @if ($user->recruiment_state == 'true') opacity-50 cursor-not-allowed @endif"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}" onclick="openModal(event)">
                                                    メール
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal -->
                    <div id="modal"
                        class="fixed inset-0 z-50 sm:px-5 hidden bg-gray-500 bg-opacity-75 flex items-center justify-center">

                        <form id="sendEmailForm" method="POST" action="{{ route('sendEmail') }}">
                            @csrf
                            <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6">
                                <!-- Dynamically display the user name in the heading -->
                                <h2 class="text-xl font-semibold mb-4" id="modal-heading"></h2>
                                <textarea id="modal-content" name="content" rows="6" class="w-full border-gray-300 rounded-lg p-2 mb-4"
                                    placeholder="メール内容を入力してください"></textarea>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg"
                                        onclick="closeModal()">閉じる</button>

                                    <input type="hidden" name="user_id" id="modalUserId">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg">送信</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .shadow-red {
            box-shadow: 0 1px 10px rgba(255, 0, 0, 0.8);
            /* Adjust the rgba values as needed */
        }

        /* Add this to your custom CSS file */
        .shadow-green {
            box-shadow: 0 1px 10px rgba(0, 255, 0, 0.8);
            /* Adjust rgba values for desired green shade and opacity */
        }
    </style>

    <script>
        function openModal(event) {
            const userId = event.target.getAttribute('data-user-id');
            const userName = event.target.getAttribute('data-user-name'); // Fetch user name from data attribute
            document.getElementById('modalUserId').value = userId;
            document.getElementById('modal-heading').textContent = `${userName}にメールを送る。`;
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
