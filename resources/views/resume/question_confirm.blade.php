<x-app-layout>
    <form class="lg:w-1/2 m-auto p-10 sm:w-full bg-white mt-10 rounded-lg" action="{{ route('') }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="p-1 text-center">
                    <p class="p-10 text-2xl">続けて過去の仕事内容を 教えてください</p>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="select_job"
                            class="block text-sm font-medium leading-6 text-gray-900">職種は何を希望しますか？</label>
                        <div class="mt-2">
                            <input type="text" name="select_job" id="select_job" autocomplete="given-name" required
                                placeholder="提案された職種を入力しましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="experience" class="block text-sm font-medium leading-6 text-gray-900">職務要約</label>
                        <div class="mt-2">
                            <input type="text" name="experience" id="experience" autocomplete="family-name" required
                                placeholder="これまでの経験を100文字程度でわかりやすくまとめましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="available_skill"
                            class="block text-sm font-medium leading-6 text-gray-900">活かせるスキル・経験</label>
                        <div class="mt-2">
                            <textarea id="available_skill" name="available_skill" rows="3" placeholder="アピールできる資格、経験などを入力しましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="resume" class="block text-sm font-medium leading-6 text-gray-900">職務経歴</label>
                        <div class="mt-2">
                            <textarea id="resume" name="resume" rows="3" placeholder="企業名、〇年〇月～〇年〇月までの在籍期間を全て入力しましょう"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit"
                class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">確認</button>
        </div>
    </form>



</x-app-layout>
