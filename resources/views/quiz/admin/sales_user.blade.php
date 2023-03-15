<x-app-layout>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div id="app" class="md:flex antialiased">
                    @include('layouts.admin')

                    <main class="bg-write h-screen w-full overflow-y-auto">
                        <section v-if="active === 'recruiment'" id="recruiment">
                            <section class="bg-white border border-gray-300 border-solid rounded shadow">
                                <header class="border-b border-solid border-gray-300 p-4 text-lg font-medium">
                                ユーザー管理•営業
                                    <x-button class="mx-10 float-right" onclick="csv()">
                                        {{ __(' csv') }}
                                    </x-button>
                                </header>

                                <form class="csv" method="post" action="{{ route('admin.csv') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="sales_user">
                                </form>
                                <section class=" flex flex-row flex-wrap items-center text-center border-b border-solid border-gray-300">
                                    
                                    <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                                        <table class="min-w-full leading-normal" id="table">
                                            <thead>
                                                <tr>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        <input type="checkbox" name="checkAll" class="checkAll" />
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        #
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        会社名
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        イニシャル名字 
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        イニシャル名前
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        メールアドレス
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        パスワード
                                                    </th>
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $cnt = 1; ?>
                                                @foreach($users as $user)
                                                @if($user->role == "sales")
                                                <tr>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-600 whitespace-no-wrap">
                                                            <input type="checkbox" name="" id="" class="quiz" quiz="{{ $user->id }}" />
                                                        </p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-600 whitespace-no-wrap">{{ $cnt++ }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-600 whitespace-no-wrap">{{ $user->company }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-600 whitespace-no-wrap">{{ $user->initName_f }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-600 whitespace-no-wrap">{{ $user->initName_l }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->pwd }}</p>
                                                    </td>
                                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                        <form method="GET" action="{{ route('del.user') }}">
                                                            @csrf
                                                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                                <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                                <input type="hidden" name="level" value="sales">
                                                                <button type="submit" class="relative" onclick="return confirm('削除しますか？');">削除</button>
                                                            </span>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endif
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

                            function updateStatus(ele, id){
                                
                                if(!confirm("変更しますか？")) return;
                                
                                var status = $(ele).val();
                                
                                $.post("{{ route('admin.update') }}", {id:id, status:status, "_token": "{{ csrf_token() }}"}, function(res){

                                    alert("変更されました。");
                                });

                            }

                </script>
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