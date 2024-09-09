<x-app-layout>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div id="app" class="md:flex antialiased">
                    @include('layouts.admin')
                    <main class="bg-white h-screen w-full overflow-y-auto">

                        <section v-if="active === 'recruiment'" id="recruiment">
                            <section class="bg-white border border-gray-300 border-solid rounded shadow">
                                <header class="border-b border-solid border-gray-300 p-4 text-lg font-medium">
                                    質問項目•業務適性
                                    <x-button class="mx-10 float-right" onclick="toggleModal()">
                                        {{ __(' 質問追加') }}
                                    </x-button>
                                    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
                                        <div
                                            class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 transition-opacity">
                                                <div class="absolute inset-0 bg-gray-900 opacity-75" />
                                            </div>
                                            <span
                                                class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                                <form method="POST" action="{{ route('add.resumequiz') }}">
                                                    @csrf
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <label>項目</label>
                                                        <input type="text" id="job" name="job"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3">
                                                        </input>
                                                        <label>No</label>
                                                        <input type="text" name="question_id"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                        <label>回答項目</label>
                                                        <input type="text" name="question1"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                        <input type="text" name="question2"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                        <label>職種説明</label>
                                                        <input type="text" name="comment"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                        <label>参考リンク</label>
                                                        <input type="text" name="url"
                                                            class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                    </div>
                                                    <div class="bg-gray-200 px-4 py-3 text-right">
                                                        <button type="button"
                                                            class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                                                            onclick="toggleModal()"><i class="fas fa-times"></i>
                                                            キャンセル</button>
                                                        <button type="submit"
                                                            class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                                                class="fas fa-plus"></i> 質問追加</button>
                                                    </div>
                                                    <input type="hidden" name="level" value="sales">
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <script>
                                        function toggleModal() {
                                            document.getElementById('modal').classList.toggle('hidden')
                                        }
                                    </script>
                                </header>
                                <div class="overflow-x-auto">

                                    <section
                                        class=" flex flex-row flex-wrap items-center text-center border-b border-solid border-gray-300">


                                        <div class="inline-block min-w-full shadow-md rounded-lg overflow-x-auto">
                                            <table class="min-w-full leading-normal">
                                                <thead>
                                                    <tr>
                                                        <!-- <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                            質問№
                                                        </th> -->
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                            項目
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                            No
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                            回答項目
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resumingquizs as $quiz)
                                                        <tr>
                                                            <!-- <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-600 whitespace-no-wrap">
                                                                
                                                            </p>
                                                        </td> -->
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-nowrap">
                                                                    {{ $quiz->job }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-600 whitespace-nowrap">
                                                                    {{ $quiz->question_id }}
                                                                </p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <p class="text-gray-900 whitespace-nowrap">
                                                                    {{ explode(',', $quiz->question)[0] }}</p>
                                                                <p class="text-gray-900 whitespace-nowrap">
                                                                    {{ explode(',', $quiz->question)[1] }}</p>
                                                            </td>
                                                            <td
                                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                                <span
                                                                    class="relative inline-block px-3 py-1 mt-1 font-semibold text-red-900 leading-tight"
                                                                    style="float:left">
                                                                    <span aria-hidden
                                                                        class="absolute inset-0 bg-blue-200 opacity-50 rounded-full">
                                                                    </span>
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $quiz->id }}">
                                                                    {{-- <input type="hidden" name="level" value="recruiment"> --}}
                                                                    <button type=""
                                                                        class="relative  whitespace-nowrap"
                                                                        onclick="toggleEdit({{ $quiz->id }})">編集</button>
                                                                </span>

                                                                <form method="POST"
                                                                    action="{{ route('del.resumequiz') }}">
                                                                    @csrf
                                                                    <span
                                                                        class="relative inline-block px-3 py-1 mt-1 font-semibold text-red-900 leading-tight">
                                                                        <span aria-hidden
                                                                            class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $quiz->id }}">
                                                                        {{-- <input type="hidden" name="level" value="sales"> --}}
                                                                        <button type="submit"
                                                                            class="relative whitespace-nowrap"
                                                                            onclick="return confirm('削除しますか？');">削除</button>
                                                                    </span>
                                                                </form>

                                                                <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden"
                                                                    id="modal{{ $quiz->id }}">
                                                                    <div
                                                                        class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                        <div class="fixed inset-0 transition-opacity">
                                                                            <div
                                                                                class="absolute inset-0 bg-gray-900 opacity-75" />
                                                                        </div>
                                                                        <span
                                                                            class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                                        <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                                                            role="dialog" aria-modal="true"
                                                                            aria-labelledby="modal-headline">
                                                                            <form method="POST"
                                                                                action="{{ route('update.resumequiz') }}">
                                                                                @csrf
                                                                                <div
                                                                                    class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                                    <label>項目</label>
                                                                                    <input type="text"
                                                                                        name="job"
                                                                                        value="{{ $quiz->job }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                                                    <label>No</label>
                                                                                    <input type="text"
                                                                                        name="question_id"
                                                                                        value="{{ $quiz->question_id }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3 disabled:opacity-75" />
                                                                                    <label>回答項目</label>
                                                                                    <input type="text"
                                                                                        name="question1"
                                                                                        value="{{ explode(',', $quiz->question)[0] }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                                                    <input type="text"
                                                                                        name="question2"
                                                                                        value="{{ explode(',', $quiz->question)[1] }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                                                                                    <label>職種説明</label>
                                                                                    <input type="textarea"
                                                                                        name="comment"
                                                                                        aria-rowspan="4"
                                                                                        value="{{ $quiz->comment }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3 border border-gray-500" />
                                                                                    <label>参考リンク</label>
                                                                                    <input type="textarea"
                                                                                        name="url"
                                                                                        aria-rowspan="4"
                                                                                        value="{{ $quiz->url }}"
                                                                                        class="w-full bg-gray-100 p-2 mt-2 mb-3 border border-gray-500" />
                                                                                </div>
                                                                                <div
                                                                                    class="bg-gray-200 px-4 py-3 text-right">
                                                                                    <button type="button"
                                                                                        class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                                                                                        onclick="toggleEdit({{ $quiz->id }})"><i
                                                                                            class="fas fa-times"></i>
                                                                                        キャンセル</button>
                                                                                    <button type="submit"
                                                                                        class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                                                                            class="fas fa-plus"></i>
                                                                                        質問編集</button>
                                                                                </div>
                                                                                <input type="hidden" name="level"
                                                                                    value="sales">
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $quiz->id }}">
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    function toggleEdit(ele) {
                                                                        document.getElementById('modal' + ele).classList.toggle('hidden');
                                                                    }
                                                                </script>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </section>
                                </div>

                            </section>
                        </section>
                    </main>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
