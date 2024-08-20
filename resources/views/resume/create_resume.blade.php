@if (isset($alert))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ $alert['title'] }}',
                text: '{{ $alert['text'] }}',
                icon: '{{ $alert['icon'] }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif



<x-app-layout>

    <form class="lg:w-1/2 m-auto p-10 sm:w-full bg-white mt-10 rounded-lg" action="{{ route('resume.generator') }}"
        enctype="multipart/form-data" method="POST">
        @csrf
        <div class="p-1 text-center">
            <p class="p-10 text-2xl">{{ auth()->user()->initName_f }} {{ auth()->user()->initName_l }}さんに合いそうな職種はこちらです
            </p>
        </div>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                タイトル
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                職種説明
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($identify == 0)
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data[2] }}"
                                            class="text-blue-400 hover:underline hover:text-blue-600">
                                            {{ $result_data[0] }}
                                        </a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-normal tracking-wide leading-8 text-gray-700 flex-wrap">
                                        {{ $result_data[1] }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($result_datas as $result_data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $result_data->url }}"
                                            class="text-blue-400 hover:underline hover:text-blue-600">
                                            {{ $result_data->job }}
                                        </a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-normal tracking-wide leading-8 text-gray-700 flex-wrap">
                                        {{ $result_data->comment }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="p-1 text-center">
                    <p class="p-10 text-2xl">続けて過去の仕事内容を 教えてください</p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="select_job"
                            class="block text-sm font-medium leading-6 text-gray-700">職種は何を希望しますか？</label>
                        <div class="mt-2">
                            <input type="text" name="select_job" id="select_job" required
                                placeholder="提案された職種を入力しましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="experience" class="block text-sm font-medium leading-6 text-gray-700">職務要約</label>
                        <div class="mt-2">
                            <textarea id="experience" name="experience" rows="3" placeholder="これまでの経験を100文字程度でわかりやすくまとめましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="available_skill"
                            class="block text-sm font-medium leading-6 text-gray-700">活かせるスキル・経験</label>
                        <div class="mt-2">
                            <textarea id="available_skill" name="available_skill" rows="3" placeholder="アピールできる資格、経験などを入力しましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="resume" class="block text-sm font-medium leading-6 text-gray-700">職務経歴</label>
                        <div class="mt-2">
                            <textarea id="resume" name="resume" rows="6"
                                placeholder="【期間】 : 2009年07月～ 2014年3月
【プロジェクト】: 制作と管理業務全般
【メンバー数】 :  4人
【役職】 : なし
【業務内容】 : 
    ・紙の在庫管理をExcel入力
    ・中級関数を使用した棚卸生産性改善
    ・制作作業全般"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="border-b border-gray-900/10 pb-12 pt-0">
                <div class="text-center mt-7">
                    <h1 class="p-2 text-2xl">1分程度自己PR動画掲載</h1>
                </div>
                <p class="px-6 pt-10 pb-2 text-sm whitespace-normal tracking-wide leading-8 text-gray-500">
                    ● 自由に自己紹介をしてください。(1分以内)<br>
                    ● 自分の強みと弱みを教えてください。(1分以内)<br>
                    ● なぜこの会社を選んだのか理由を教えてください。(1分以内)<br>
                </p>
                <div class="w-full">
                    <main class="container mx-auto max-w-screen-lg">
                        <!-- file upload modal -->
                        <article aria-label="File Upload Modal"
                            class="relative h-full flex flex-col bg-white shadow-xl rounded-md"
                            ondrop="dropHandler(event);" ondragover="dragOverHandler(event);"
                            ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
                            <!-- overlay -->
                            {{-- <div id="overlay"
                                class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md">
                                <i>
                                    <svg class="fill-current w-12 h-12 mb-3 text-blue-700"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z" />
                                    </svg>
                                </i>
                                <p class="text-lg text-blue-700">Drop files to upload</p>
                            </div> --}}

                            <!-- scroll area -->
                            <section class="h-full overflow-auto p-8 pt-0 w-full h-full flex flex-col">
                                <header
                                    class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                                    <p class="mb-3  text-center text-gray-500 flex flex-wrap justify-center">
                                        ここにファイルをドラッグ＆ドロップ<br />
                                        または
                                    </p>
                                    <input id="hidden-input" type="file" name="videos[]" multiple class="hidden" />
                                    <a id="button"
                                        class="mt-2 cursor-pointer rounded-sm bg-blue-500 text-white rounded-sm px-4 py-2 bg-gray-200 hover:bg-blue-600 focus:shadow-outline focus:outline-none">
                                        ファイルを選択
                                    </a>
                                </header>


                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1 mt-1">
                                    <li id="empty"
                                        class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32"
                                            src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                            alt="no data" />
                                        <span class="text-small text-gray-500">なし</span>
                                    </li>
                                </ul>
                            </section>
                        </article>
                    </main>
                </div>

                <template id="file-template">
                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                        <article tabindex="0"
                            class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
                            <img alt="upload preview"
                                class="img-preview hidden w-full h-full sticky object-cover rounded-md bg-fixed" />

                            <section
                                class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                <h1 class="flex-1 group-hover:text-blue-800 overflow-hidden"></h1>
                                <div class="flex">
                                    <p class="p-1 size text-xs text-gray-700"></p>
                                    <button
                                        class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path class="pointer-events-none"
                                                d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                        </svg>
                                    </button>
                                </div>
                            </section>
                        </article>
                    </li>
                </template>

                <template id="image-template">
                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                        <article tabindex="0"
                            class="group hasImage w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
                            <img alt="upload preview"
                                class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

                            <section
                                class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                <h1 class="flex-1"></h1>
                                <div class="flex">
                                    <span class="p-1">
                                        <i>
                                            <svg class="fill-current w-4 h-4 ml-auto pt-"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24">
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
                                            <path class="pointer-events-none"
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

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit"
                class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">確認</button>
        </div>
    </form>

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
        const fileTempl = document.getElementById("file-template"),
            imageTempl = document.getElementById("image-template"),
            empty = document.getElementById("empty");

        // Use to store pre-selected files
        let FILES = {};

        // Function to add files to the gallery
        function addFile(target, file) {
            // Check if the number of selected files is already 5
            if (Object.keys(FILES).length >= 5) {
                alert('You can only upload a maximum of 5 video files.');
                return; // Do not add more files
            }

            const isImage = file.type.match("image.*"),
                objectURL = URL.createObjectURL(file);

            const clone = isImage ?
                imageTempl.content.cloneNode(true) :
                fileTempl.content.cloneNode(true);

            clone.querySelector("h1").textContent = file.name;
            clone.querySelector("li").id = objectURL;
            clone.querySelector(".delete").dataset.target = objectURL;
            clone.querySelector(".size").textContent =
                file.size > 1024 ?
                file.size > 1048576 ?
                Math.round(file.size / 1048576) + "mb" :
                Math.round(file.size / 1024) + "kb" :
                file.size + "b";

            isImage &&
                Object.assign(clone.querySelector("img"), {
                    src: objectURL,
                    alt: file.name
                });

            empty.classList.add("hidden");
            target.prepend(clone);

            FILES[objectURL] = file;
        }

        const gallery = document.getElementById("gallery"),
            overlay = document.getElementById("overlay");

        // Click the hidden input of type file if the visible button is clicked
        // and capture the selected files
        const hidden = document.getElementById("hidden-input");
        $("#button").click(() => {
            $("#hidden-input").click();
        });

        hidden.onchange = (e) => {
            for (const file of e.target.files) {
                addFile(gallery, file);
            }
        };

        // Use to check if a file is being dragged
        const hasFiles = ({
                dataTransfer: {
                    types = []
                }
            }) =>
            types.indexOf("Files") > -1;

        // Drag and drop handlers
        let counter = 0;

        function dropHandler(ev) {
            ev.preventDefault();
            for (const file of ev.dataTransfer.files) {
                addFile(gallery, file);
                overlay.classList.remove("draggedover");
                counter = 0;
            }
        }

        function dragEnterHandler(e) {
            e.preventDefault();
            if (!hasFiles(e)) {
                return;
            }
            ++counter && overlay.classList.add("draggedover");
        }

        function dragLeaveHandler(e) {
            1 > --counter && overlay.classList.remove("draggedover");
        }

        function dragOverHandler(e) {
            if (hasFiles(e)) {
                e.preventDefault();
            }
        }

        // Event delegation to capture delete events
        document.getElementById('gallery').addEventListener('click', (e) => {
            if (e.target.className.indexOf("delete") != -1) {
                const ou = e.target.dataset.target;
                document.getElementById(ou).remove(ou);
                gallery.children.length === 1 && empty.classList.remove("hidden");
                delete FILES[ou];
            }
        });

        // Print all selected files
        $("#submit").click = () => {
            alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
            console.log(FILES);
        };

        // Clear entire selection
        $(".cancel").click = () => {
            while (gallery.children.length > 0) {
                gallery.lastChild.remove();
            }
            FILES = {};
            empty.classList.remove("hidden");
            gallery.append(empty);
        };
    });
</script>
