<x-app-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 mt-10 lg:px-8">

        <form class="max-w-4xl  sm:w-full bg-white p-8 sm:p-10 rounded-lg shadow-lg"
            action="{{ route('resume.generator') }}" method="POST" id="resumeForm">
            @csrf
            <div class="space-y-8">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold text-gray-800">過去の仕事内容を教えてください</h1>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="select_job" class="block text-lg font-medium text-gray-700">希望する職種を選びましょう</label>
                        {{-- <select name="select_job" id="select_job"
                                class="mt-2 block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base"
                                required>
                                <option value="" disabled selected>提案された職種を選びましょう</option>
                                <option value="PMO">PMO</option>
                                <option value="開発・テスト">開発・テスト</option>
                                <option value="インフラ">インフラ</option>
                                <option value="IT研修">IT研修</option>
                            </select> --}}
                        <select name="select_job" id="select_job"
                            class="mt-2 block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base"
                            required>
                            <option value="" disabled selected>提案された職種を選びましょう</option>
                            <option value="事務">事務</option>
                            <option value="営業">営業</option>
                            <option value="IT・通信">IT・通信</option>
                            <option value="金融">金融</option>
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
                                placeholder="最終学歴と学部を入力"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                            <input type="text" id="experience_reason" name="experience_reason"
                                placeholder="これまでの経緯を入力"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                            <input type="text" id="future_plans" name="future_plans" placeholder="今後の計画を入力"
                                class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-lg font-medium text-gray-700">活かせるスキル・経験</label>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">Excel関数使用経験を選択</label>
                                <input type="radio" name="excel_experience" value="あり" id="excel_experience_yes"
                                    class="ml-2">
                                <label for="excel_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="excel_experience" value="なし" id="excel_experience_no"
                                    class="ml-4">
                                <label for="excel_experience_no" class="text-gray-700">なし</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">パワポ資料作成経験を選択</label>
                                <input type="radio" name="ppt_experience" value="あり" id="ppt_experience_yes"
                                    class="ml-2">
                                <label for="ppt_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="ppt_experience" value="なし" id="ppt_experience_no"
                                    class="ml-4">
                                <label for="ppt_experience_no" class="text-gray-700">なし</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="text-gray-600">リーダー、管理職経験を選択</label>
                                <input type="radio" name="leadership_experience" value="あり"
                                    id="leadership_experience_yes" class="ml-2">
                                <label for="leadership_experience_yes" class="text-gray-700">あり</label>
                                <input type="radio" name="leadership_experience" value="なし"
                                    id="leadership_experience_no" class="ml-4">
                                <label for="leadership_experience_no" class="text-gray-700">なし</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <input type="text" id="skillset" name="skillset" placeholder="経験のある技術を全て入力"
                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                    </div>

                    <div>
                        <label class="block text-lg font-medium text-gray-700">取得済みの資格</label>
                        <input type="text" id="qualifications" name="qualifications" placeholder="資格があれば入力"
                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                    </div>

                    <div class="bg-white rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">職務経歴</h2>
                        <div id="experience_skills_container" class="space-y-6">
                            <!-- Initial Experience Skill Input -->
                            <div class="experience_skill border p-4 rounded-lg bg-gray-50">

                                <!-- 職務経歴の期間 -->
                                {{-- <label class="block text-sm font-medium text-gray-700">職務経歴の期間</label>
                                <div class="flex space-x-4 mb-4">
                                    <div class="w-1/2">
                                        <label for="job_start_date" class="sr-only">開始日</label>
                                        <input type="month" name="job_start_date[]"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                                    </div>
                                    <div class="w-1/2">
                                        <label for="job_end_date" class="sr-only">終了日</label>
                                        <input type="month" name="job_end_date[]"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                                    </div>
                                </div> --}}

                                <!-- 業務名に関する入力 -->
                                <div class="flex space-x-4 mb-4">
                                    <div class="w-1/2">
                                        <label for="job_name"
                                            class="block text-sm font-medium text-gray-700">業務名</label>
                                        <input type="text" name="job_name[]" placeholder="業務名を入力"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base mb-4" />
                                    </div>
                                    <div class="w-1/2">
                                        <label for="job_name"
                                            class="block text-sm font-medium text-gray-700">プロジェクト規模</label>
                                        <select name="job_budget[]"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base">
                                            <option value="不明">不明</option>
                                            <option value="数百万">数百万</option>
                                            <option value="数千万">数千万</option>
                                            <option value="億単位">億単位</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- メンバー人数と役割 -->
                                <div class="flex space-x-4 mb-4">
                                    <div class="w-1/2">
                                        <input type="number" name="team_members_count[]" placeholder="メンバー人数"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base" />
                                    </div>
                                    <div class="w-1/2">
                                        <select name="job_role[]"
                                            class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base">
                                            <option value="">役割を選択</option>
                                            <option value="リーダー">リーダー</option>
                                            <option value="リーダー補佐">リーダー補佐</option>
                                            <option value="メンバー">メンバー</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 職務経歴の詳細 -->
                                <textarea name="job_details[]" rows="4"
                                    class="block w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base mb-4"
                                    placeholder="職務経歴の詳細を入力"></textarea>
                            </div>
                        </div>

                        <!-- Add New Experience Button -->
                        <button id="add_experience_button"
                            class="mt-4 py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                            + 追加の経験を入力
                        </button>
                    </div>

                    <!-- Submit Button -->
                </div>
                <div class="flex justify-center border-t-2 border-gray-100 pt-10">
                    <button type="submit" id="resumeGenerator"
                        class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                        経歴書生成
                    </button>
                </div>
                <h1 class="text-center mt-0">※ 生成に20秒程度かかります。</h1>
                <!-- Loader HTML -->
                <div id="loader"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex justify-center items-center z-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <p class="text-lg font-semibold text-gray-700">生成に20秒程度かかります。</p>
                        <div class="mt-4">
                            <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 01.268-1.875L4.268 10a7.96 7.96 0 00-1.604 3.75A8 8 0 014 12z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

<script>
    document.getElementById('add_experience_button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default button behavior

        // Get the container that holds all experience skills
        const container = document.getElementById('experience_skills_container');

        // Clone the first experience skill block inside the container
        const originalExperienceSkill = container.querySelector('.experience_skill');
        if (!originalExperienceSkill) {
            console.error('Original experience skill block not found!');
            return; // Exit if the original block is not found
        }

        const newExperienceSkill = originalExperienceSkill.cloneNode(true); // Deep clone
        newExperienceSkill.classList.add('relative'); // Ensure the new block is positioned relatively

        // Modify the `name` and `id` attributes of the inputs in the cloned block
        newExperienceSkill.querySelectorAll('input, textarea').forEach((input, index) => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace('[]', '') +
                    '[]'); // Ensure the name uses array notation
            }

            // Remove the value in cloned inputs to avoid duplicating data
            input.value = '';

            // Optionally, update `id` to ensure uniqueness
            if (input.getAttribute('id')) {
                input.setAttribute('id', input.getAttribute('id') + '-' + Math.random().toString(36)
                    .substring(7));
            }
        });

        // Add a close button to the new experience skill block
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;'; // Add the close (x) icon
        closeButton.className = 'absolute top-2 right-2 text-gray-600 hover:text-gray-900 focus:outline-none';
        closeButton.onclick = function() {
            // Remove the new experience skill block when the close button is clicked
            container.removeChild(newExperienceSkill);
        };

        // Append the close button to the new experience skill block
        newExperienceSkill.appendChild(closeButton);

        // Append the new experience skill block to the container
        container.appendChild(newExperienceSkill);

        // Focus the first input of the newly added section
        const firstInput = newExperienceSkill.querySelector('input[type="text"], input[type="date"], textarea');
        if (firstInput) {
            firstInput.focus();
        }
    });

    document.getElementById('resumeForm').addEventListener('submit', function(event) {
        // Show the loader
        document.getElementById('loader').classList.remove('hidden');

        // Disable the submit button to prevent multiple submissions
        document.querySelector('button[type="submit"]').disabled = true;
    });
    document.addEventListener("DOMContentLoaded", () => {
        const loader = document.getElementById("loader");

        // Show loader when the form is submitted
        document.querySelector('form').addEventListener('submit', () => {
            loader.classList.remove('hidden');
        });

        // Hide loader once the page has fully loaded
        window.addEventListener('load', () => {
            loader.classList.add('hidden');
        });
    });
</script>
