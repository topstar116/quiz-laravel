<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="md:flex antialiased">
                    <!-- Sidebar -->

                    <!-- Main Content Area -->
                    <main class="bg-white h-screen w-full overflow-y-auto p-6">
                        <!-- Tab Buttons -->
                        <div class="flex space-x-4 border-b border-gray-200 mb-6">
                            <button
                                class="tablink text-gray-700 font-semibold px-6 py-2 rounded-t-md transition-colors duration-300 focus:outline-none hover:bg-blue-100"
                                onclick="openTab(event, 'AIConsulting')">
                                AIキャリアコンサル受講の案内
                            </button>
                            <button
                                class="tablink text-gray-700 font-semibold px-6 py-2 rounded-t-md transition-colors duration-300 focus:outline-none hover:bg-blue-100"
                                onclick="openTab(event, 'AdditionalInfo')" id="defaultOpen">
                                求人応募後の追加情報案内
                            </button>
                        </div>

                        <!-- Tab Content -->
                        <div id="AIConsulting" class="tabcontent hidden">
                            <h1 class="text-2xl font-semibold text-gray-700 mb-4">AIキャリアコンサル受講の案内</h1>
                            <form action="{{ route('save.email') }}">
                                <textarea
                                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    cols="30" rows="10" placeholder="内容を入力してください..." name="contentOne">{{ $email_data->contentOne }}</textarea>
                                <input type="hidden" name="emailnumber" value="one" />
                                <button
                                    class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-all duration-300 focus:outline-none">
                                    保存
                                </button>
                            </form>
                        </div>

                        <div id="AdditionalInfo" class="tabcontent hidden">
                            <h1 class="text-2xl font-semibold text-gray-700 mb-4">求人応募後の追加情報案内</h1>
                            <form action="{{ route('save.email') }}">
                                <textarea
                                    class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    cols="30" rows="10" placeholder="内容を入力してください..." name="contentTwo">{{ $email_data->contentTwo }}</textarea>
                                <input type="hidden" name="emailnumber" value="two" />
                                <button
                                    class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-all duration-300 focus:outline-none">
                                    保存
                                </button>
                            </form>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tabcontent {
            display: none;
        }

        .active-tab {
            border-b-2 border-blue-500;
        }
    </style>

    <script>
        function openTab(event, tabName) {
            // Hide all tabcontent elements
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remove active class from all tablinks
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active-tab");
                tablinks[i].classList.remove("border-b-2");
                tablinks[i].classList.remove("border-blue-500");
            }

            // Show the specific tab content and set the active tab
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.classList.add("active-tab");
            event.currentTarget.classList.add("border-b-2");
            event.currentTarget.classList.add("border-blue-500");
        }

        // Trigger the default tab open
        document.getElementById("defaultOpen").click();
    </script>
</x-app-layout>
