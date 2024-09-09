@if (session('resume_error'))
    <div id="resumeError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
        role="alert">
        <strong class="font-bold">エラー: </strong>
        <span class="block sm:inline">{{ session('resume_error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-9a1 1 0 10-2 0v3a1 1 0 102 0V9zm-4-1a1 1 0 10-2 0v3a1 1 0 102 0V8z"
                    clip-rule="evenodd" />
            </svg>
        </span>
    </div>

    <script>
        // Automatically hide the alert after 3 seconds
        setTimeout(function() {
            var alert = document.getElementById('resumeError');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500); // wait for fade out transition
            }
        }, 3000); // Hide after 3 seconds
    </script>
@endif

<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <header class="flex justify-between items-center mb-6">
                    <h1 class="text-xl font-bold text-gray-800">応募書類提出</h1>

                    <!-- Form for deleting selected videos -->
                    @if (Auth::user()->role == 'admin')
                        <form id="deleteVideosForm" action="{{ route('admin.deleteMultiple') }}" method="POST">
                            @csrf
                            <!-- Add a hidden input to track the selected videos -->
                            <input type="hidden" name="selected_videos" id="selected_videos">

                            <button type="submit" onclick="submitForm()"
                                class="bg-red-400 text-white px-4 py-2 rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200">
                                選択削除
                            </button>
                        </form>
                    @endif
                </header>

                <!-- User Video and Dropdown Card -->
                <div class="space-y-6">
                    @foreach ($videoUrls as $user => $data)
                        <div class="bg-gray-50 rounded-lg shadow-md p-4 w-full">
                            <!-- User Header Section -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-semibold text-gray-800">{{ $user }}</span>

                                <!-- Dropdown button (3 dots) -->
                                <div class="relative">
                                    <button onclick="toggleDropdown('dropdown-{{ $loop->index }}')"
                                        class="text-gray-500 focus:outline-none">
                                        &#x2026; <!-- This is the "..." button -->
                                    </button>
                                    <div id="dropdown-{{ $loop->index }}"
                                        class="hidden absolute right-0 mt-2 w-28 bg-white border rounded-md shadow-lg z-10">
                                        <!-- First Line: 履歴書 -->
                                        <a href="{{ $data['resume_url'] }}"
                                            class="block px-4 text-sm pt-1 text-gray-700 hover:bg-gray-100">経歴書
                                        </a>

                                        <!-- Second Line: Delete and Download for 履歴書 -->
                                        <div class="flex items-center space-x-2 px-4">
                                            <a href="{{ $data['resume_url'] }}"
                                                class="text-blue-500 text-sm hover:bg-gray-100 p-1"><img
                                                    src="{{ asset('download.png') }}" class="w-7 h-7"
                                                    alt=""></a>
                                            <form method="POST" action="{{ route('del.resumeAndCv') }}">
                                                @csrf
                                                <input type="hidden" name="result_id" value="{{ $data['user_id'] }}">
                                                <input type="hidden" name="level" value="resume">
                                                <button type="submit"
                                                    class="text-red-600 text-sm hover:bg-gray-100 p-1"
                                                    onclick="return confirm('削除しますか？');">
                                                    <img src="{{ asset('delete.png') }}" class="w-7 h-7"
                                                        alt="">
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Third Line: CV -->
                                        <a href="{{ $data['cv_url'] }}"
                                            class="block px-4 text-sm text-gray-700 hover:bg-gray-100">履歴書</a>

                                        <!-- Fourth Line: Delete and Download for CV -->
                                        <div class="flex items-center space-x-2 px-4">
                                            <a href="{{ $data['cv_url'] }}"
                                                class="text-blue-500 text-sm hover:bg-gray-100 p-1"><img
                                                    src="{{ asset('download.png') }}" class="w-7 h-7"
                                                    alt=""></a>
                                            <form method="POST" action="{{ route('del.resumeAndCv') }}">
                                                @csrf
                                                <input type="hidden" name="result_id" value="{{ $data['user_id'] }}">
                                                <input type="hidden" name="level" value="cv">
                                                <button type="submit"
                                                    class="text-red-600 text-sm hover:bg-gray-100 p-1"
                                                    onclick="return confirm('削除しますか？');"><img
                                                        src="{{ asset('delete.png') }}" class="w-7 h-7"
                                                        alt=""></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Videos Section (scrollable) -->
                            <div class="flex space-x-4 overflow-x-auto">
                                @foreach ($data['videos'] as $index => $video)
                                    <div class="relative">
                                        <input type="checkbox"
                                            class="absolute left-1 top-1 z-10 form-checkbox text-red-600 transition duration-150 ease-in-out mr-2"
                                            name="selected_videos[]"
                                            value="{{ $data['user_id'] }}:{{ $video }}"
                                            aria-label="Select video for deletion">

                                        <video controls class="w-40 h-24 object-cover rounded-md">
                                            <source src="{{ asset($video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="text-center">
                                            {{ $data['file_sizes'][$index] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle the dropdown visibility
        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Function to gather all selected checkboxes and submit the form
        function submitForm() {
            let selectedVideos = [];
            document.querySelectorAll('input[name="selected_videos[]"]:checked').forEach(function(checkbox) {
                selectedVideos.push(checkbox.value);
            });

            if (selectedVideos.length === 0) {
                // If no videos are selected, display an alert
                alert('削除する動画を選択してください。');
                return; // Stop the form submission
            }

            // Set the hidden input value to the array of selected videos
            document.getElementById('selected_videos').value = JSON.stringify(selectedVideos);

            // Submit the form
            document.getElementById('deleteVideosForm').submit();
        }
    </script>

    <style>
        body {
            background-color: #f7fafc;
        }
    </style>
</x-app-layout>
