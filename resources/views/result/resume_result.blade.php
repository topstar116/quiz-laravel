<x-app-layout>
    <div class="container mx-auto p-6">
        {!! $resumeContent !!}
        <form method="POST" action="{{ route('admin.resumepdf') }}">
            @csrf
            <span
                class="absolute right-36 top-4 inline-block px-3 py-1 font-semibold text-white-900 leading-tight hover:text-white-700">
                <span aria-hidden class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                <input type="hidden" style="display: none" name="resume_content" value="{{ $resumeContent }}">
                <button type="submit" class="relative">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </button>
            </span>
        </form>
    </div>
</x-app-layout>
