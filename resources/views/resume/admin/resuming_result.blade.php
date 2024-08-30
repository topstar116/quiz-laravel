<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="app" class="md:flex antialiased">
                    @include('layouts.admin')

                    <main class="bg-white h-screen w-full overflow-y-auto">

                        <section v-if="active === 'management'" id="management">
                            <section class="bg-white border border-gray-300 border-solid rounded shadow">
                                <header class="border-b border-solid border-gray-300 p-4 text-lg font-medium">
                                    回答管理•業務適性
                                </header>

                                <section
                                    class=" flex flex-row flex-wrap items-center text-center border-b border-solid border-gray-300">


                                    <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                                        <table class="min-w-full leading-normal" id="table">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        <input type="checkbox" name="checkAll" class="checkAll" />
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        氏名
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        適性業務
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        回答日
                                                    </th>
                                                    <th
                                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-600 whitespace-no-wrap">
                                                                <input type="checkbox" name="" id=""
                                                                    class="quiz" quiz="{{ $result->id }}" />
                                                            </p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-600 whitespace-no-wrap">
                                                                {{ $result->initName_f }} {{ $result->initName_l }}</p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-600 whitespace-no-wrap">
                                                                {{ $result->job }}</p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-900 whitespace-no-wrap">
                                                                @if ($result->updated_at)
                                                                    {{ $result->updated_at }}
                                                                @else
                                                                    {{ $result->created_at }}
                                                                @endif
                                                            </p>        
                                                        </td>
                                                        <td
                                                            class="py-5 flex flex-col sm:flex-row gap-2 border-b border-gray-200 bg-white text-sm">


                                                            <form method="POST" action="{{ route('admin.work.pdf') }}"
                                                                style="float: left;">
                                                                @csrf
                                                                <span
                                                                    class="relative inline-block px-3 py-1 font-semibold text-white-900 leading-tight">
                                                                    <span aria-hidden
                                                                        class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $result->user_id }}">


                                                                    <input type="hidden" name="name"
                                                                        value="{{ $result->initName_f }} {{ $result->initName_l }}">
                                                                    <input type="hidden" name="resume_content"
                                                                        value="{{ $result->resume_content }}">


                                                                    <input type="hidden" name="created_at"
                                                                        value="{{ $result->created_at }}">

                                                                    <button type="submit" class="relative">PDF</button>
                                                                </span>
                                                            </form>

                                                            <form method="GET" action="{{ route('del.result') }}">
                                                                @csrf
                                                                <span
                                                                    class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                                    <span aria-hidden
                                                                        class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                    <input type="hidden" name="result_id"
                                                                        value="{{ $result->id }}">
                                                                    <input type="hidden" name="level"
                                                                        value="management">
                                                                    <button type="submit" class="relative"
                                                                        onclick="return confirm('削除しますか？');">削除</button>
                                                                </span>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </section>
                        </section>
                    </main>
                </div>

                <script>
                    /**
                     * Check if passed value is a string
                     */
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

                    function csv() {

                        var checkItems = [];

                        $.each($(".quiz:checked"), function() {
                            var id = $(this).attr('quiz');
                            checkItems.push(id);

                        });


                        checkItems = checkItems.toString();
                        $(".csv").find("[name='items']").remove();
                        if (checkItems != '') {
                            $(".csv").append('<input type="hidden" name="items" value="' + checkItems + '" >');
                        } else {
                            alert("ダウンロードリストを選択する必要があります。");
                            return;
                        }
                        $(".csv").submit();
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
