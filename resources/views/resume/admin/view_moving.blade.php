<x-app-layout>
    <style>
        #myVideo {
            position: relative;
            min-height: 100%;
            min-width: 100%;
            height: 100%;
        }

        /* Add some content at the bottom of the video/page */
        .content {
            position: relative;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #f1f1f1;
            width: 100%;
            padding: 20px;
        }

        /* Style the button used to pause/play the video */
        .mybtn {
            width: 100%;
            font-size: 20px;
            position: relative;
            padding: 10px;
            border: none;
            color: #fff;
            background-color: dodgerblue;
            border: 1px solid dodgerblue;
            cursor: pointer;
            transition: 0.2s
        }

        .mybtn:hover {
            background: rgb(13, 124, 236);
        }

        * {
            box-sizing: border-box
        }

        /* Slideshow container */
        .slideshow-container {
            width: 100%;
            position: relative;
            margin: auto;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        .prev {
            left: 0;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.3s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: rgb(94, 162, 229);
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        main::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }
    </style>


    <div class="py-12 bg-gray-700">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div id="app" class="md:flex antialiased">

                    <main class="bg-white h-screen w-full overflow-y-auto">

                        <section v-if="active === 'management'" id="management">
                            <section class="bg-white  rounded ">
                                <header class=" p-4 text-lg font-medium text-center">
                                    PR動画
                                </header>

                                <section class="items-center text-center ">
                                    @if ($movieList)

                                        @php
                                            $counter = 1;
                                        @endphp
                                        <div class="slideshow-container">
                                            @foreach ($movieList as $moviePath)
                                                <div class="mySlides fade">
                                                    <div class="numbertext text-blue-500">{{ $counter }} /
                                                        {{ count($movieList) }}
                                                    </div>
                                                    <video autoplay muted loop id="myVideo{{ $counter }}"
                                                        controls="controls">
                                                        <source src="{{ asset($moviePath) }}" type="video/mp4">
                                                    </video>

                                                    <!-- Optional: some overlay text to describe the video -->
                                                    <!-- Use a button to pause/play the video with JavaScript -->

                                                </div>
                                                <!-- Next and previous buttons -->
                                                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                        </div>
                                        <br>
                                    @else
                                        <div>なし</div>
                                    @endif

                                    <!-- The dots/circles -->



                                </section>

                            </section>
                        </section>
                    </main>

                </div>








                <script>
                    // Pause and play the video, and change the button text
                    function myFunction(buttonID, videoID) {
                        // Get the video
                        var video = document.getElementById(videoID);
                        console.log(video);

                        // Get the button
                        var btn = document.getElementById(buttonID);
                        if (video.paused) {
                            video.play();
                            btn.innerHTML = "Pause";
                            videoPlayer.firstChild.nodeValue = 'Play';
                        } else {
                            video.pause();
                            btn.innerHTML = "Play";
                            videoPlayer.firstChild.nodeValue = 'Pause';
                        }
                    }
                    let slideIndex = 1;
                    showSlides(slideIndex);

                    // Next/previous controls
                    function plusSlides(n) {
                        showSlides(slideIndex += n);
                    }

                    // Thumbnail image controls
                    function currentSlide(n) {
                        showSlides(slideIndex = n);
                    }

                    function showSlides(n) {
                        let i;
                        let slides = document.getElementsByClassName("mySlides");
                        if (n > slides.length) {
                            slideIndex = 1
                        }
                        if (n < 1) {
                            slideIndex = slides.length
                        }
                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";
                        }

                        slides[slideIndex - 1].style.display = "block";
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
