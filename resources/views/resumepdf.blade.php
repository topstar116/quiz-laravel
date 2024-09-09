<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
        }

        .section-heading {
            font-size: 1.25rem;
            font-weight: 600;
            color: #4a4a4a;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="container mx-auto py-8 px-4 md:px-8">
        <!-- Resume Container -->
        <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
            <!-- Job Title -->
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-6">
                {{ $resume['job_title'] }}
            </h1>

            <!-- Job Summary -->
            <div class="mb-8">
                <h2 class="section-heading">職業の要約</h2>
                <p class="text-gray-700 mt-2">{{ $resume['job_summary'] }}</p>
            </div>

            <!-- Skills and Experience -->
            <div class="mb-8">
                <h2 class="section-heading">経験</h2>
                <p class="text-gray-700 mt-2">{{ $resume['skills_experience'] }}</p>
            </div>

            <!-- Skillset -->
            <div class="mb-8">
                <h2 class="section-heading">スキル</h2>
                <p class="text-gray-700 mt-2">{{ $resume['skillset'] }}</p>
            </div>

            <!-- Qualifications -->
            <div class="mb-8">
                <h2 class="section-heading">資格</h2>
                <p class="text-gray-700 mt-2">{{ $resume['qualifications'] }}</p>
            </div>

            <!-- Job History -->
            <div>
                <h2 class="section-heading">職歴</h2>
                <div class="mt-4 space-y-6">
                    @foreach (json_decode($resume['job_history'], true) as $job)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Start Date -->
                                <div>
                                    <p class="text-sm font-medium text-gray-500">開始日</p>
                                    <p class="text-gray-900">{{ $job['start_date'] }}</p>
                                </div>

                                <!-- End Date -->
                                <div>
                                    <p class="text-sm font-medium text-gray-500">終了日</p>
                                    <p class="text-gray-900">{{ $job['end_date'] }}</p>
                                </div>

                                <!-- Job Name -->
                                <div>
                                    <p class="text-sm font-medium text-gray-500">職務名</p>
                                    <p class="text-gray-900">{{ $job['job_name'] }}</p>
                                </div>

                                <!-- Team Size -->
                                <div>
                                    <p class="text-sm font-medium text-gray-500">チームのサイズ</p>
                                    <p class="text-gray-900">{{ $job['team_size'] }}</p>
                                </div>

                                <!-- Role -->
                                <div>
                                    <p class="text-sm font-medium text-gray-500">役割</p>
                                    <p class="text-gray-900">{{ $job['role'] }}</p>
                                </div>

                                <!-- Experience Details -->
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">経験の詳細</p>
                                    <p class="text-gray-900">{{ $job['experience_details'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>

</html>
