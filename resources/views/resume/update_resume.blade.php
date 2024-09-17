@if (session('success'))
    <script>
        alert("{{ session('success') }}");
        window.location.href = '/';
    </script>
@endif

<x-app-layout>
    <form action="{{ route('update_resume') }}" method="POST"
        class="p-6 mt-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg" id="updateresume">
        @csrf
        <h2 class="text-2xl font-bold mb-6 text-center">職務経歴書</h2>

        <div class="space-y-4">
            <!-- Job Title -->
            <div>
                <label for="job_title" class="block text-gray-700 font-medium mb-1">職業名</label>
                <input type="text" id="job_title" name="job_title" value="{{ $resumeContent['job_title'] ?? '' }}"
                    placeholder="職業名を入力してください"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <!-- Job Summary -->
            <div>
                <label for="job_summary" class="block text-gray-700 font-medium mb-1">職業の要約</label>
                <textarea id="job_summary" name="job_summary" rows="3" placeholder="職業経験を要約してください"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>{{ $resumeContent['job_summary'] ?? '' }}</textarea>
            </div>

            <!-- Skills and Experience -->
            <div>
                <label for="skills_experience" class="block text-gray-700 font-medium mb-1">スキルと経験</label>
                <textarea id="skills_experience" name="skills_experience" rows="3" placeholder="スキルと経験について説明してください"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>{{ $resumeContent['skills_experience'] ?? '' }}</textarea>
            </div>

            <!-- Skillset -->
            <div>
                <label for="skillset" class="block text-gray-700 font-medium mb-1">スキルセット</label>
                <input type="text" id="skillset" name="skillset"
                    value="{{ implode(', ', $resumeContent['skillset'] ?? []) }}" placeholder="スキルをカンマで区切って入力してください"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <!-- Qualifications -->
            <div>
                <label for="qualifications" class="block text-gray-700 font-medium mb-1">資格</label>
                <input type="text" id="qualifications" name="qualifications"
                    value="{{ implode(', ', $resumeContent['qualifications'] ?? []) }}"
                    placeholder="資格をカンマで区切って入力してください"
                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>

            <!-- Job History for larger screens -->
            <div class="hidden md:block">
                <label class="block text-gray-700 font-medium mb-1">職歴</label>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 rounded-md mb-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 p-2 text-left">職務名</th>
                                <th class="border border-gray-300 p-2 text-left">チームのサイズ</th>
                                <th class="border border-gray-300 p-2 text-left">役割</th>
                                <th class="border border-gray-300 p-2 text-left">経験の詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resumeContent['job_history'] ?? [] as $index => $job)
                                <tr>
                                    <td class="border border-gray-300 p-2">
                                        <p>{{ $job['job_name'] ?? '' }}</p>
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <p>{{ $job['team_size'] ?? '' }}</p>
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <p>{{ $job['role'] ?? '' }}</p>
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <textarea id="experience_details_{{ $index }}" name="job_history[{{ $index }}][experience_details]"
                                            rows="3" placeholder="経験について詳しく説明してください"
                                            class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            required>{{ $job['experience_details'] ?? '' }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Job History for small screens -->
            <div class="block md:hidden space-y-4">
                <label class="block text-gray-700 font-medium mb-1">職歴</label>
                @foreach ($resumeContent['job_history'] ?? [] as $index => $job)
                    <div class="border border-gray-300 rounded-md p-4 mb-4">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Start Date -->
                            <div>
                                <label for="start_date_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">開始日</label>
                                <input type="date" id="start_date_{{ $index }}"
                                    name="job_history[{{ $index }}][start_date]"
                                    value="{{ $job['start_date'] ?? '' }}"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">終了日</label>
                                <input type="date" id="end_date_{{ $index }}"
                                    name="job_history[{{ $index }}][end_date]"
                                    value="{{ $job['end_date'] ?? '' }}"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                            </div>

                            <!-- Job Name -->
                            <div>
                                <label for="job_name_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">職務名</label>
                                <input type="text" id="job_name_{{ $index }}"
                                    name="job_history[{{ $index }}][job_name]"
                                    value="{{ $job['job_name'] ?? '' }}" placeholder="職務名を入力してください"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                            </div>

                            <!-- Team Size -->
                            <div>
                                <label for="team_size_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">チームのサイズ</label>
                                <input type="number" id="team_size_{{ $index }}"
                                    name="job_history[{{ $index }}][team_size]"
                                    value="{{ $job['team_size'] ?? '' }}" placeholder="チームのサイズを入力してください"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">役割</label>
                                <input type="text" id="role_{{ $index }}"
                                    name="job_history[{{ $index }}][role]" value="{{ $job['role'] ?? '' }}"
                                    placeholder="あなたの役割を入力してください"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>
                            </div>

                            <!-- Experience Details -->
                            <div>
                                <label for="experience_details_{{ $index }}"
                                    class="block text-gray-700 font-medium mb-1">経験の詳細</label>
                                <textarea id="experience_details_{{ $index }}" name="job_history[{{ $index }}][experience_details]"
                                    rows="3" placeholder="経験について詳しく説明してください"
                                    class="w-full p-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    required>{{ $job['experience_details'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white p-3 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">職務経歴書
            </button>
        </div>
    </form>
</x-app-layout>
<!-- Loader HTML -->
{{-- <div id="loader" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <p class="text-lg font-semibold text-gray-700">データベースに保管中...</p>
        <div class="mt-4">
            <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 01.268-1.875L4.268 10a7.96 7.96 0 00-1.604 3.75A8 8 0 014 12z">
                </path>
            </svg>
        </div>
    </div>
</div>
<script>
    document.getElementById('updateresume').addEventListener('submit', function(event) {
        // Show the loader
        document.getElementById('loader').classList.remove('hidden');

        // Disable the submit button to prevent multiple submissions
        document.querySelector('button[type="submit"]').disabled = true;

        // Listen for the page unload event to hide the loader
        window.addEventListener('beforeunload', function() {

        });
    });
</script> --}}
