<x-app-layout>


    <form class="lg:w-1/2 m-auto p-10 sm:w-full bg-white mt-10 rounded-lg" action="{{ route('save.movie') }}"
        enctype="multipart/form-data" method="POST">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 pt-0">
                <div class="text-center mt-7">
                    <h1 class="p-2 text-2xl">1分程度自己PR動画掲載</h1>
                </div>
                <p class="px-6 pt-10 pb-2 text-sm text-gray-500 leading-8">
                    ● 自由に自己紹介をしてください。(1分以内)<br>
                    ● 自分の強みと弱みを教えてください。(1分以内)<br>
                    ● なぜこの会社を選んだのか理由を教えてください。(1分以内)<br>
                </p>
                <div class="w-full">
                    <main class="container mx-auto max-w-screen-lg">
                        <!-- File upload modal -->
                        <article aria-label="File Upload Modal"
                            class="relative flex flex-col bg-white shadow-xl rounded-md" ondrop="dropHandler(event);"
                            ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);"
                            ondragenter="dragEnterHandler(event);">
                            <section class="p-8 pt-0 w-full flex flex-col">
                                <header
                                    class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                                    <p class="mb-3 text-center text-gray-500">
                                        ここにファイルをドラッグ＆ドロップ<br />
                                        または
                                    </p>
                                    <input id="hidden-input" type="file" name="videos[]" multiple class="hidden" />
                                    <a id="button"
                                        class="mt-2 cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-sm hover:bg-blue-600 focus:outline-none">
                                        ファイルを選択
                                    </a>
                                </header>

                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1 mt-1">

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
                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                        <article tabindex="0"
                            class="group w-full h-full rounded-md bg-gray-100 cursor-pointer shadow-sm relative">
                            <section
                                class="flex flex-col text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                <h1 class="flex-1 overflow-hidden group-hover:text-blue-800"></h1>
                                <div class="flex">
                                    <p class="p-1 size text-xs text-gray-700"></p>
                                    <button
                                        class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                        </svg>
                                    </button>
                                </div>
                            </section>
                        </article>
                    </li>
                    <input type="hidden" name="file_sizes[]" class="file_size" />
                </template>

                <template id="image-template">
                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                        <article tabindex="0"
                            class="group hasImage w-full h-full rounded-md bg-gray-100 cursor-pointer shadow-sm relative text-transparent hover:text-white">
                            <img alt="upload preview"
                                class="img-preview w-full h-full sticky object-cover rounded-md" />

                            <section
                                class="flex flex-col text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                <h1 class="flex-1"></h1>
                                <div class="flex">
                                    <span class="p-1">
                                        <i>
                                            <svg class="fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24">
                                                <path
                                                    d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
                                            </svg>
                                        </i>
                                    </span>

                                    <p class="p-1 size text-xs"></p>
                                    <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md">
                                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                        </svg>
                                    </button>
                                </div>
                            </section>
                        </article>
                    </li>
                </template>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-4">
            <a href="{{ route('view.movie') }}"
                class="inline-flex items-center rounded-md bg-yellow-500 px-5 py-2 text-sm font-medium text-white shadow-lg transition-transform transform hover:scale-105 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600">
                保存ファイル
            </a>
            <button type="submit" id="submit"
                class="inline-flex items-center rounded-md bg-green-500 px-5 py-2 text-sm font-medium text-white shadow-lg transition-transform transform hover:scale-105 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                保存
            </button>
        </div>
    </form>





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
                                <video id="modalVideo" controls class="w-full">
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

</x-app-layout>


<style>
    .video-sample {
        min-height: 300px
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
</style>
<script>
    $(document).ready(() => {
        const fileTempl = document.getElementById("file-template");
        const imageTempl = document.getElementById("image-template");
        const empty = document.getElementById("empty");
        const hiddenInput = document.getElementById("hidden-input");
        const gallery = document.getElementById("gallery");
        const overlay = document.getElementById("overlay");

        let FILES = {};

        function addFile(target, file) {
            if (Object.keys(FILES).length >= 5) {
                alert('アップロードできる動画ファイルは最大5つまでです。');
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
            // Check file size (limit to 2MB)
            const maxSize = 30 * 1024 * 1024; // 2MB in bytes
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

            // Update the hidden file input with selected files
            updateHiddenInput();
        }

        function updateHiddenInput() {
            // Clear previous files
            $(hiddenInput).val('');

            // Create a DataTransfer object to hold the files
            const dataTransfer = new DataTransfer();

            Object.values(FILES).forEach(file => {
                dataTransfer.items.add(file);
            });

            hiddenInput.files = dataTransfer.files;
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
    });
</script>
