<!-- General error container -->
{{-- @if ($errors->any())
    <div id="error-container" class="fixed top-14 right-4 w-full max-w-sm bg-red-300 text-white rounded-md shadow-lg p-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="mb-2">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<!-- Specific error display for the 'name' field -->
@error('name')
    <div id="name-error" class="fixed top-14 right-4 w-full max-w-sm bg-red-300 text-white rounded-md shadow-lg p-4">
        <p>{{ $message }}</p>
    </div>
@enderror

<!-- Specific error display for the 'email' field -->
@error('email')
    <div id="email-error" class="fixed top-4 right-4 w-full max-w-sm bg-red-300 text-white rounded-md shadow-lg p-4">
        <p>{{ $message }}</p>
    </div>
@enderror

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="app" class="md:flex antialiased">
                    @include('layouts.admin')
                    <main class="bg-white h-screen w-full overflow-y-auto">
                        <section v-if="active === 'recruitment'" id="recruitment">
                            <section class="bg-white border border-gray-300 rounded-lg shadow">
                                <header
                                    class="border-b border-gray-300 p-4 text-lg font-medium flex items-center justify-between">
                                    <span>ユーザー管理</span>
                                    <x-button class="bg-blue-500 text-md hover:bg-blue-700" id="insert">
                                        {{ __('追加') }}
                                    </x-button>
                                </header>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full leading-normal" id="table">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    <input type="checkbox" name="checkAll" class="checkAll" />
                                                </th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    番号</th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    名前</th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    メールアドレス</th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    パスワード</th>
                                                <th
                                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $cnt = 1; @endphp
                                            @foreach ($users as $user)
                                                @if ($user->role == 'admin')
                                                    <tr>
                                                        <td
                                                            class="px-5 py-5 border-b  text-center border-gray-200 bg-white text-sm">
                                                            <input type="checkbox" name="" class="quiz"
                                                                quiz="{{ $user->id }}" />
                                                        </td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 text-center bg-white text-sm">
                                                            {{ $cnt++ }}</td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 text-center bg-white text-sm">
                                                            {{ $user->name }}</td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 text-center bg-white text-sm">
                                                            {{ $user->email }}</td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 text-center bg-white text-sm">
                                                            {{ $user->pwd }}</td>
                                                        <td
                                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm flex gap-2 justify-center space-x-2">
                                                            <form method="POST" action="{{ route('del.manager') }}"
                                                                class="inline-block">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $user->id }}">
                                                                <button type="submit"
                                                                    class="text-white px-3 py-1 hover:bg-red-600 bg-red-500 rounded-lg"
                                                                    onclick="return confirm('削除しますか？');">削除</button>
                                                            </form>
                                                            <button
                                                                class="text-white-500 hover:bg-blue-700 edit-button bg-blue-500 px-3 py-1 rounded-lg"
                                                                data-id="{{ $user->id }}"
                                                                data-name="{{ $user->name }}"
                                                                data-email="{{ $user->email }}"
                                                                data-pwd="{{ $user->pwd }}">編集</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </section>
                    </main>
                </div>

                <!--      Edit Modal    -->
                <div class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden"
                    id="myModal">
                    <div class="modal-content bg-white p-6 rounded-lg w-full max-w-md relative">
                        <button
                            class="close-button absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
                        <form id="modal-form" method="POST" action="{{ route('admin.editmanager') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="modal-name" class="block text-gray-700">名前:</label>
                                <input type="text" id="modal-name" name="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="modal-email" class="block text-gray-700">メールアドレス:</label>
                                <input type="email" id="modal-email" name="email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="modal-pwd" class="block text-gray-700">パスワード:</label>
                                <input type="text" id="modal-pwd" name="pwd"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <input type="hidden" id="modal-id" name="id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                            <div class="flex justify-end space-x-2">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                    onclick="saveChanges()">保存</button>
                                <button type="button"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 close-button"
                                    onclick="closeModal()">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!--     insert modal       -->
                <div class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden"
                    id="insertModal">
                    <div class="modal-content bg-white p-6 rounded-lg w-full max-w-md relative">
                        <button class=" absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                            onclick="closeInsertModal('insertModal')">&times;</button>
                        <form id="modal-form" method="POST" action="{{ route('admin.insertmanger') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="modal-name" class="block text-gray-700">名前:</label>
                                <input type="text" id="modal-name" name="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="modal-email" class="block text-gray-700">メールアドレス:</label>
                                <input type="email" id="modal-email" name="email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="modal-pwd" class="block text-gray-700">パスワード:</label>
                                <input type="text" id="modal-pwd" name="pwd"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">追加</button>
                                <button type="button"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 close-button"
                                    onclick="closeInsertModal('insertModal')">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('myModal');
        const modalContent = {
            name: document.getElementById('modal-name'),
            email: document.getElementById('modal-email'),
            pwd: document.getElementById('modal-pwd'),
            id: document.getElementById('modal-id')
        };
        const closeButton = document.querySelectorAll('.close-button');

        // Open modal with user data
        function openModal(data) {
            modalContent.name.value = data.name;
            modalContent.email.value = data.email;
            modalContent.pwd.value = data.pwd;
            modalContent.id.value = data.id;
            modal.classList.remove('hidden');
        }

        // Handle "Edit" button clicks
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', (event) => {
                const data = {
                    id: event.target.getAttribute('data-id'),
                    name: event.target.getAttribute('data-name'),
                    email: event.target.getAttribute('data-email'),
                    pwd: event.target.getAttribute('data-pwd')
                };
                openModal(data);
            });
        });

        // Close modal
        function closeModal() {
            modal.classList.add('hidden');
        }

        closeButton.forEach(button => {
            button.addEventListener('click', closeModal);
        });

        // Close modal if clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        // Enable "Check All" functionality
        function enableCheckAll(selector) {
            const table = document.querySelector(selector);
            if (!table) return;

            const checkAll = table.querySelector('.checkAll');
            const checkboxes = table.querySelectorAll(':checkbox:not(.checkAll)');

            checkAll.addEventListener('click', () => {
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                });
            });
        }

        enableCheckAll('#table');

        // Handle CSV functionality


        // Handle saving changes
        window.saveChanges = () => {
            const form = document.getElementById('modal-form');
            // Logic to save changes goes here
            console.log('Saving changes for:', {
                id: modalContent.id.value,
                name: modalContent.name.value,
                email: modalContent.email.value,
                pwd: modalContent.pwd.value
            });
            closeModal(); // Close modal after saving
        };

        function isString(arg) {
            if (typeof arg == 'string' || arg instanceof String) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Enable Check All Functionality
         * @param  {string} element - ID or class of table
         * @return {[none]}         none
         */
        function enableCheckAll(element) {
            var $table = $(element),
                $notCheckAllCheckbox = $table.find(':checkbox').not('.checkAll');

            // "check all" checkbox functionality
            $table.find('.checkAll').click(function() {
                $notCheckAllCheckbox.prop('checked', this.checked);
            });

            /* The "check all" checkbox is only checked if all rows are checked */
            $notCheckAllCheckbox.change(function() {
                var numOfChecked = $notCheckAllCheckbox.filter(':checked').length,
                    numOfCheckboxes = $notCheckAllCheckbox.length,
                    isAllChecked = numOfChecked === numOfCheckboxes;
                $table.find('.checkAll').prop('checked', isAllChecked);
            });
        }

        var table2 = $('#table2');
        enableCheckAll('#table'); // passing in a string
        enableCheckAll(table2); // passing in an object



    });
    document.addEventListener('click', (e) => {
        if (e.target.id == "insert") {
            document.querySelector('#insertModal').classList.remove('hidden');
        }
    })

    function closeInsertModal(id) {
        document.querySelector('#' + id).classList.add('hidden');
    }

    window.addEventListener('click', (event) => {
        if (event.target === document.getElementById('insertModal')) {
            closeInsertModal('insertModal');
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
        // Function to show and hide error message with transition
        function handleErrorVisibility(selector, delay) {
            const element = document.querySelector(selector);
            if (element) {
                element.style.opacity = 1; // Show the element
                setTimeout(() => {
                    element.style.opacity = 0; // Hide the element with transition
                    setTimeout(() => element.remove(), 500); // Allow fade-out transition to complete
                }, delay);
            }
        }

        // Show and hide error messages after 5 seconds
        handleErrorVisibility('#error-container', 5000);
        handleErrorVisibility('#name-error', 5000);
        handleErrorVisibility('#email-error', 5000);
    });
</script>
