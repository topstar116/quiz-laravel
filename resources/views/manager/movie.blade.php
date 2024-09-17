@if (session('resume_error'))
    <script>
        alert('{{ session('resume_error') }}');
    </script>
@endif

<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <header class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">応募書類提出</h1>

                    @if (Auth::user()->role == 'admin')
                        <form id="deleteDownloadForm" action="{{ route('admin.manageMultiple') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_items" id="selected_items">
                            <input type="hidden" name="action" id="action">
                            <div class="flex space-x-4">
                                <button type="button" onclick="submitForm('delete')"
                                    class="bg-red-500 text-white px-6 py-2 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200">
                                    選択削除
                                </button>
                                <button type="button" onclick="submitForm('download')"
                                    class="bg-green-500 text-white px-6 py-2 rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200">
                                    選択ダウンロード
                                </button>
                            </div>
                        </form>
                    @endif
                </header>

                <div class="space-y-8">
                    @foreach ($videoUrls as $user => $data)
                        @if (!empty($data['videos']) || !empty($data['resume_url']) || !empty($data['cv_url']))
                            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg font-semibold text-gray-800">{{ $user }}</span>
                                </div>

                                <div class="flex space-x-6 overflow-x-auto items-center">
                                    @foreach ($data['videos'] as $index => $video)
                                        <div class="relative bg-gray-100 p-2 rounded-lg shadow-md">
                                            <input type="checkbox"
                                                class="absolute left-2 top-2 z-10 form-checkbox text-red-600 transition duration-150 ease-in-out"
                                                name="selected_items[]"
                                                value="video:{{ $data['user_id'] }}:{{ $video }}"
                                                aria-label="Select video for deletion/download">
                                            <video controls class="w-40 h-24 object-cover rounded-lg shadow-sm">
                                                <source src="{{ asset($video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="text-center text-sm text-gray-600 mt-1">
                                                {{ $data['file_sizes'][$index] }}</div>
                                        </div>
                                    @endforeach

                                    <div class="flex items-center space-x-4">
                                        @if ($data['resume_url'])
                                            <div class="relative bg-gray-100 p-2 rounded-lg shadow-md">
                                                <input type="checkbox"
                                                    class="absolute left-2 top-2 z-10 form-checkbox text-red-600 transition duration-150 ease-in-out"
                                                    name="selected_items[]"
                                                    value="resume:{{ $data['user_id'] }}:{{ $data['resume_url'] }}">
                                                <a href="{{ $data['resume_url'] }}">
                                                    <img src="{{ asset('resume.png') }}" alt="Resume"
                                                        class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                                </a>
                                                <div class="text-center">経歴書</div>
                                            </div>
                                        @endif
                                        @if ($data['cv_url'])
                                            <div class="relative bg-gray-100 p-2 rounded-lg shadow-md">
                                                <input type="checkbox"
                                                    class="absolute left-2 top-2 z-10 form-checkbox text-red-600 transition duration-150 ease-in-out"
                                                    name="selected_items[]"
                                                    value="cv:{{ $data['user_id'] }}:{{ $data['cv_url'] }}">
                                                <a href="{{ $data['cv_url'] }}">
                                                    <img src="{{ asset('cv.png') }}" alt="CV"
                                                        class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                                </a>
                                                <div class="text-center">履歴書</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm(action) {
            let selectedItems = [];
            document.querySelectorAll('input[name="selected_items[]"]:checked').forEach(function(checkbox) {
                selectedItems.push(checkbox.value);
            });

            if (selectedItems.length === 0) {
                alert('削除/ダウンロードするアイテムを選択してください。');
                return;
            }

            document.getElementById('selected_items').value = JSON.stringify(selectedItems);
            document.getElementById('action').value = JSON.stringify(action);
            document.getElementById('deleteDownloadForm').submit();
        }
    </script>

    <style>
        @media (max-width: 640px) {

            video,
            img {
                width: 100%;
                height: auto;
            }
        }
    </style>
</x-app-layout>
