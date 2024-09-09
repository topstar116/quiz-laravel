<x-app-layout>
    <div class="container mx-auto p-6 w-full md:w-1/2">
        {!! $resumeContent !!}
        <form method="POST" action="{{ route('admin.resumepdf') }}" class="flex justify-center items-center mt-8">
            @csrf
            <input type="hidden" name="resume_content" value="{{ $resumeContent }}">
            <button type="submit"
                class="relative inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                ダウンロード
                <span class="absolute inset-0 bg-blue-200 opacity-50 rounded-lg"></span>
            </button>
        </form>
    </div>
</x-app-layout>
