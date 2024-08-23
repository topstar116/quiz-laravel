<x-app-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 mt-10">
        <form class="lg:w-2/3 sm:w-full bg-white p-8 sm:p-10 rounded-lg shadow-lg"
            action="{{ route('resume.generator') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="space-y-8">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold text-gray-800">過去の仕事内容を教えてください</h1>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="select_job" class="block text-lg font-medium text-gray-700">希望する職種を選びましょう</label>
                        <select name="select_job" id="select_job"
                            class="mt-2 block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base"
                            required>
                            <option value="" disabled selected>提案された職種を選びましょう</option>
                            <option value="事務">事務</option>
                            <option value="営業">営業</option>
                            <option value="IT・通信">IT・通信</option>
                            <option value="医療・看護">医療・看護</option>
                            <option value="介護">介護</option>
                            <option value="土木・建築">土木・建築</option>
                            <option value="研究職">研究職</option>
                            <option value="toC仕事">toC仕事</option>
                        </select>
                    </div>

                    <div>
                        <label for="experience_summary" class="block text-lg font-medium text-gray-700">職務要約</label>
                        <div class="mt-2 space-y-4">
                            <input type="text" id="experience_summary" name="experience_summary"
                                placeholder="最終学歴と学部を入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                            <input type="text" id="experience_reason" name="experience_reason"
                                placeholder="どういった経緯と思考で仕事に就いたか簡単に入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                            <input type="text" id="future_plans" name="future_plans" placeholder="今後の計画を簡単に入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-lg font-medium text-gray-700">活かせるスキル・経験</label>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">Excel使用経験</label>
                                <input type="radio" name="excel_experience" id="excel_experience_yes" class="ml-2">
                                <label for="excel_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="excel_experience" id="excel_experience_no" class="ml-4">
                                <label for="excel_experience_no" class="text-gray-700">なし</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">Excel関数使用経験</label>
                                <input type="radio" name="excel_function_experience" id="excel_function_yes"
                                    class="ml-2">
                                <label for="excel_function_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="excel_function_experience" id="excel_function_no"
                                    class="ml-4">
                                <label for="excel_function_no" class="text-gray-700">なし</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">パワポ資料作成経験</label>
                                <input type="radio" name="ppt_experience" id="ppt_experience_yes" class="ml-2">
                                <label for="ppt_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="ppt_experience" id="ppt_experience_no" class="ml-4">
                                <label for="ppt_experience_no" class="text-gray-700">なし</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">リーダー、管理職経験</label>
                                <input type="radio" name="leadership_experience" id="leadership_experience_yes"
                                    class="ml-2">
                                <label for="leadership_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="leadership_experience" id="leadership_experience_no"
                                    class="ml-4">
                                <label for="leadership_experience_no" class="text-gray-700">なし</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="experience_details" class="block text-lg font-medium text-gray-700">職務経歴</label>
                        <div class="mt-2 space-y-4">
                            <input type="text" id="qualification" name="qualification"
                                placeholder="他アピールできる資格、経験があれば入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />

                            <div class="flex space-x-4">
                                <input type="date" id="start_date" name="start_date"
                                    class="block w-1/2 rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                                <input type="date" id="end_date" name="end_date"
                                    class="block w-1/2 rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                            </div>

                            <input type="text" id="job_summary" name="job_summary" placeholder="業務内容を一言で入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />

                            <div class="flex space-x-4">
                                <input type="number" id="team_size" name="team_size" placeholder="メンバー人数"
                                    class="block w-1/2 rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                                <select name="role" id="role"
                                    class="block w-1/2 rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base">
                                    <option value="">役割を選択しましょう</option>
                                    <option value="リーダー">リーダー</option>
                                    <option value="リーダー補佐">リーダー補佐</option>
                                    <option value="メンバー">メンバー</option>
                                </select>
                            </div>

                            <textarea id="experience_details" name="experience_details" rows="3" placeholder="経験した全ての内容を入力しましょう"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        経歴書生成
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
