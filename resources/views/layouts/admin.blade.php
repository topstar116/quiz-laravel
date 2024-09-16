<aside class="w-full md:h-screen md:w-64 bg-gray-700 md:flex md:flex-col">
    <nav class="overflow-y-auto h-full flex-grow">
        <header>
            <span class="text-xs text-gray-100 block py-6 px-6">アカウント管理
            </span>
        </header>
        <ul class="font-medium px-4 text-left">
            <li class="text-gray-100">
                {{-- <a href="{{ route('admin') }}"><button href="#recruiment" v-on:click="select('recruiment')"
                        class="rounded text-sm text-left block py-3 px-6 {{ $page == 'recruimentUser' ? '' : 'hover:' }}bg-blue-600 w-full">採用</button></a>
                <a href="{{ route('admin.sales') }}"><button href="#sales" v-on:click="select('sales')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'salesUser' ? '' : 'hover:' }}bg-blue-600 w-full text-left">営業</button></a>
                <a href="{{ route('admin.management') }}"><button href="#management" v-on:click="select('management')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'managementUser' ? '' : 'hover:' }}bg-blue-600 w-full text-left">管理</button></a> --}}
                <a href="{{ route('admin') }}"><button href="#recruimentUser" v-on:click="select('recruimentUser')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'recruimentUser' ? '' : 'hover:' }}bg-blue-600 w-full text-left">ユーザー</button></a>
                <a href="{{ route('admin.member') }}"><button href="#member" v-on:click="select('member')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'memberUser' ? '' : 'hover:' }}bg-blue-600 w-full text-left">システム管理者</button></a>

            </li>
        </ul>

        <header>
            <span class="text-xs text-gray-100 block py-6 px-6">質問管理</span>
        </header>
        <ul class="font-medium px-4 text-left">
            <li class="text-gray-100">
                <a href="{{ route('admin.quiz') }}"><button href="#recruiment" v-on:click="select('recruiment')"
                        class="rounded text-sm text-left block py-3 px-6 {{ $page == 'recruimentQuiz' ? '' : 'hover:' }}bg-blue-600 w-full active">職種適性(エンジニア版)</button></a>
                <a href="{{ route('admin.quiz.resuming') }}"><button href="#resuming" v-on:click="select('resuming')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'resumingQuiz' ? '' : 'hover:' }}bg-blue-600 w-full text-left">職種適性(全職種版)</button></a>
                <a href="{{ route('admin.quiz.work') }}"><button href="#work" v-on:click="select('work')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'workQuiz' ? '' : 'hover:' }}bg-blue-600 w-full text-left">業務適性</button></a>
                <a href="{{ route('admin.quiz.management') }}"><button href="#management"
                        v-on:click="select('management')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'managementQuiz' ? '' : 'hover:' }}bg-blue-600 w-full text-left">
                        現状確認</button></a>
            </li>
        </ul>

        <header>
            <span class="text-xs text-gray-100 block py-6 px-6">回答管理</span>
        </header>
        <ul class="font-medium px-4 text-left">
            <li class="text-gray-100">
                <a href="{{ route('admin.result') }}"><button href="#recruiment" v-on:click="select('recruiment')"
                        class="rounded text-sm text-left block py-3 px-6 {{ $page == 'recruimentResult' ? '' : 'hover:' }}bg-blue-600 w-full active">職種適性(エンジニア版)</button></a>
                <a href="{{ route('admin.result.resuming') }}"><button href="#resuming_result"
                        v-on:click="select('resuming_result')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'resumingResult' ? '' : 'hover:' }}bg-blue-600 w-full text-left">職種適性(全職種版)</button></a>
                <a href="{{ route('admin.result.sales') }}"><button href="#sales" v-on:click="select('sales')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'workResult' ? '' : 'hover:' }}bg-blue-600 w-full text-left">業務適性</button></a>
                <a href="{{ route('admin.result.management') }}"><button href="#management"
                        v-on:click="select('management')"
                        class="rounded text-sm block py-3 px-6 {{ $page == 'managementResult' ? '' : 'hover:' }}bg-blue-600 w-full text-left">
                        現状確認</button></a>
            </li>
        </ul>
    </nav>
</aside>
