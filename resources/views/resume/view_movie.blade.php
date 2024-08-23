<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($result_datas as $result_data)
                <div class="video-container bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="w-full h-64 bg-gray-200">
                        <video controls class="w-full h-full object-cover">
                            <source src="{{ asset('/' . $result_data['video_url']) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 text-center">{{ $result_data['file_name'] }}</h2>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
