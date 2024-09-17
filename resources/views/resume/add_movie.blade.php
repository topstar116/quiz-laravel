@if (session('failure'))
    <script>
        alert('{{ session('failure') }}');
    </script>
@endif

<x-app-layout>
    <div class="lg:w-3/5 w-full m-auto  rounded-lg shadow-lg p-2 mt-0 bg-white md:p-10 md:mt-10">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 pt-0">
                <div class="text-center mt-7">
                    <h3 class="p-2 text-2xl font-bold text-gray-800">応募書類提出</h3>
                </div>

                <div class="px-6 pt-10 pb-2">
                    <p class="text-sm text-gray-500 leading-8">
                        <span class="font-semibold text-gray-700 text-lg">● 応募書類</span><br>
                        <span class="text-gray-600">作成した職務経歴書、履歴書もあれば併せてご提出ください</span>
                    </p>
                    <form action="{{ route('add.resumedocs') }}" method="POST" class="mt-4 space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-col sm:flex-row">
                            <label class="text-gray-700  mb-2 sm:mr-2">履歴書提出:</label>
                            <input type="file" name="resume_file" accept=".doc,.pdf,.txt,.docx"
                                class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100 transition duration-200" />
                        </div>

                        <div class="flex flex-col sm:flex-row">
                            <label class="text-gray-700  mb-2 sm:mr-2">経歴書提出:</label>
                            <input type="file" name="cv" accept=".doc,.pdf,.txt,.docx"
                                class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 transition duration-200" />
                        </div>

                        <button type="submit"
                            class="mt-2 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            提出
                        </button>
                    </form>
                </div>

                <form action="{{ route('save.movie') }}" enctype="multipart/form-data" method="POST" class="px-6">
                    @csrf
                    <p class="pt-10 pb-2 text-sm text-gray-500 leading-8">
                        <span class="font-semibold text-gray-700 text-lg">● 自己PR動画</span><br>
                        <span>求人情報のどの内容で活躍出来そうか、今回の応募理由を1分以内に口頭でご説明ください</span>
                    </p>
                    <div class="w-full">
                        <main class="container mx-auto max-w-screen-lg">
                            <article aria-label="File Upload Modal"
                                class="relative flex flex-col bg-white shadow-xl rounded-md"
                                ondrop="dropHandler(event);" ondragover="dragOverHandler(event);"
                                ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
                                <section class="p-8 flex flex-col">
                                    <header
                                        class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                                        <p class="mb-3 text-center text-gray-500">
                                            ここにファイルをドラッグ＆ドロップ<br />
                                            または
                                        </p>
                                        <input id="hidden-input" type="file" name="video" class="hidden" />
                                        <a id="button"
                                            class="mt-2 cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none transition duration-200">
                                            ファイルを選択
                                        </a>
                                    </header>

                                    <ul id="gallery" class="flex flex-wrap -m-1 mt-1">
                                        <li id="empty"
                                            class="h-full w-full text-center flex flex-col items-center justify-center">
                                            <img class="mx-auto w-32"
                                                src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                                alt="no data" />
                                            <span class="text-sm text-gray-500">なし</span>
                                        </li>
                                    </ul>
                                </section>
                            </article>
                        </main>
                    </div>

                    <template id="file-template">
                        <li class="block p-1 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 h-24">
                            <article tabindex="0"
                                class="group w-full h-full rounded-md bg-gray-100 cursor-pointer shadow-sm relative transition duration-200 hover:shadow-lg">
                                <section
                                    class="flex flex-col text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                    <h1 class="flex-1 overflow-hidden group-hover:text-blue-800 font-semibold"></h1>
                                    <div class="flex items-center">
                                        <p class="p-1 size text-xs text-gray-700"></p>
                                        <button
                                            class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800 transition duration-200">
                                            <svg class="pointer-events-none fill-current w-4 h-4"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                            </svg>
                                        </button>
                                    </div>
                                </section>
                            </article>
                        </li>
                        <input type="hidden" name="file_sizes" class="file_size" />
                    </template>

                    <div class="mt-6 flex items-center justify-end gap-4">
                        <a href="{{ route('view.movie') }}"
                            class="inline-flex items-center rounded-md bg-yellow-500 px-5 py-2 text-sm font-medium text-white shadow-lg transition-transform transform hover:scale-105 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600">
                            保存ファイル
                        </a>
                        <button type="submit" id="submit"
                            class="inline-flex items-center rounded-md bg-green-500 px-5 py-2 text-sm font-medium text-white shadow-lg transition-transform transform hover:scale-105 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                            保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Structure -->
    <div id="videoModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">PR動画</h3>
                            <div class="mt-2">
                                <video id="modalVideo" controls class="w-full rounded-lg shadow-md">
                                    <source id="modalVideoSource" src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="closebtn"
                        class="w-full inline-flex justify-center rounded-md border hover:border-gray-600 border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        閉じる
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
    <!-- loader -->
    <div id="loader" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <p class="text-lg font-semibold text-gray-700">データベースに保管中です。</p>
            <div class="mt-4">
                <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 01.268-1.875L4.268 10a7.96 7.96 0 00-1.604 3.75A8 8 0 014 12z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .video-sample {
        min-height: 300px;
    }

    .hasImage:hover section {
        background-color: rgba(5, 5, 5, 0.4);
    }

    .hasImage:hover button:hover {
        background: rgba(5, 5, 5, 0.45);
    }

    #overlay p,
    i {
        opacity: 0;
    }

    #overlay.draggedover {
        background-color: rgba(255, 255, 255, 0.7);
    }

    #overlay.draggedover p,
    #overlay.draggedover i {
        opacity: 1;
    }

    .group:hover .group-hover\:text-blue-800 {
        color: #2b6cb0;
    }

    /* New styles for improved aesthetics */
    #button {
        border-radius: 0.375rem;
        /* rounded-md */
        transition: background-color 0.2s;
    }

    .border-dashed {
        border-style: dashed;
    }

    .border-gray-400 {
        border-color: #cbd5e1;
        /* light gray */
    }

    .hover\:bg-blue-600:hover {
        background-color: #2563eb;
        /* darker blue */
    }

    .bg-gray-100 {
        background-color: #f3f4f6;
        /* light gray */
    }

    .text-gray-700 {
        color: #374151;
        /* dark gray */
    }

    .text-gray-500 {
        color: #6b7280;
        /* medium gray */
    }

    .rounded-md {
        border-radius: 0.375rem;
    }

    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

<script>
    $(document).ready(() => {
        const fileTempl = document.getElementById("file-template");
        const empty = document.getElementById("empty");
        const hiddenInput = document.getElementById("hidden-input");
        const gallery = document.getElementById("gallery");
        const overlay = document.getElementById("overlay");
        const selectButton = document.getElementById("button");
        const loader = document.getElementById("loader");

        let FILES = {};

        function addFile(target, file) {
            if (Object.keys(FILES).length >= 1) {
                alert('1つの動画のみアップロードできます。');
                return;
            }

            if (Object.values(FILES).some(existingFile => existingFile.name === file.name)) {
                alert(`すでに "${file.name}" という名前のファイルが選択されています。`);
                return;
            }

            if (!file.type.startsWith('video/')) {
                alert('動画ファイルのみアップロードできます。');
                return;
            }

            const maxSize = 30 * 1024 * 1024; // 30MB in bytes
            if (file.size > maxSize) {
                alert(`ファイルサイズは30MBまでです。"${file.name}"のサイズが大きすぎます。`);
                return;
            }

            const objectURL = URL.createObjectURL(file);
            const clone = fileTempl.content.cloneNode(true);

            clone.querySelector("h1").textContent = file.name;
            clone.querySelector("h1").id = objectURL;
            clone.querySelector("li").id = objectURL;
            clone.querySelector(".file_size").value = file.size;
            clone.querySelector(".delete").dataset.target = objectURL;
            clone.querySelector(".size").textContent =
                file.size > 1024 ?
                file.size > 1048576 ?
                Math.round(file.size / 1048576) + "mb" :
                Math.round(file.size / 1024) + "kb" :
                file.size + "b";

            empty.classList.add("hidden");
            target.prepend(clone);
            FILES[objectURL] = file;

            updateHiddenInput();
            updateButtonText();
        }

        function updateHiddenInput() {
            $(hiddenInput).val('');
            const dataTransfer = new DataTransfer();

            Object.values(FILES).forEach(file => {
                dataTransfer.items.add(file);
            });

            hiddenInput.files = dataTransfer.files;
        }

        function updateButtonText() {
            if (Object.keys(FILES).length > 0) {
                selectButton.textContent = "ファイル追加";
            } else {
                selectButton.textContent = "ファイルを選択";
            }
        }

        $("#button").click(() => {
            $("#hidden-input").click();
        });

        hiddenInput.onchange = (e) => {
            for (const file of e.target.files) {
                addFile(gallery, file);
            }
        };

        function dropHandler(ev) {
            ev.preventDefault();
            for (const file of ev.dataTransfer.files) {
                addFile(gallery, file);
                overlay.classList.remove("draggedover");
            }
        }

        function dragEnterHandler(e) {
            e.preventDefault();
            if (!hasFiles(e)) return;
            overlay.classList.add("draggedover");
        }

        function dragLeaveHandler(e) {
            overlay.classList.remove("draggedover");
        }

        function dragOverHandler(e) {
            if (hasFiles(e)) e.preventDefault();
        }

        function hasFiles({
            dataTransfer: {
                types = []
            }
        }) {
            return types.indexOf("Files") > -1;
        }

        document.getElementById('gallery').addEventListener('click', (e) => {
            if (e.target.tagName === 'H1') {
                const videoUrl = e.target.id;
                if (videoUrl) showModal(videoUrl);
            }

            if (e.target.className.indexOf("delete") != -1) {
                const ou = e.target.dataset.target;
                document.getElementById(ou).remove();
                delete FILES[ou];
                if (gallery.children.length === 1) empty.classList.remove("hidden");
                updateHiddenInput();
                updateButtonText();
            }
        });

        $("#closebtn").click(() => closeModal());

        $("#submit").click((e) => {
            if (Object.keys(FILES).length === 0) {
                e.preventDefault();
                alert('動画がありません。');
            }
        });

        function showModal(videoUrl) {
            const modal = document.getElementById('videoModal');
            const modalVideoSource = document.getElementById('modalVideoSource');
            const modalVideo = document.getElementById('modalVideo');

            modalVideoSource.src = videoUrl;
            modalVideo.load();
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('videoModal');
            const modalVideo = document.getElementById('modalVideo');

            modalVideo.pause();
            modal.classList.add('hidden');
        }

        // Show loader on form submit
        $("form").on("submit", () => {
            loader.classList.remove('hidden');
        });

        // Hide loader on page load
        window.addEventListener('load', () => {
            loader.classList.add('hidden');
        });
    });
</script>
