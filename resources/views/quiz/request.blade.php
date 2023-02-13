<x-app-layout>

    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h5 class="text-3xl font-bold m-5">受検依頼一覧</h5>
                    
                    <p class="text-gray-700 text-sm ml-5 mr-5 mb-8">
                        <h5 class="text-2xl font-bold m-5 text-blue-900">【ご商談企業様限定】無料お試し受検</h5>
                        <span class="m-10" style="font-size: 12pt;">応募期間: 2022/02/09 - 2030/10/18 受検項目: 性格適性</span><br/>
                    </p>
                    @if(auth()->user()->status == 0)
                    <a href="{{ route('explain') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full m-10" >応募申請</button></a>
                    @else
                    <button class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full m-10 cursor-not-allowed">応募完了</button>
                    @endif

            




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
