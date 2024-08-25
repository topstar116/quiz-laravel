<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('MY_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function generateResume(array $details)
    {
        $prompt = $this->createResumePrompt($details);

        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-4-turbo-preview',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a professional resume writer.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 1500,
                    "format" => "HTML"
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            // Extract and parse the resume content
            $resumeContent = $body['choices'][0]['message']['content'] ?? 'No response from API';
            return $resumeContent;
        } catch (RequestException $e) {
            // Handle request exceptions
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }

protected function createResumePrompt(array $details)
{
    // Start building the prompt
    $prompt = '
    プロフェッショナルな履歴書のために、以下のセクションを含むHTMLページを作成してください。以下のコードはサンプルコードです。スタイリングはTailwindCSSを使用する必要があり、HTMLコードのみを提供する必要があります。最初の説明文や最後の説明文のようなものを提供せず、resume_tableというクラス名を持つdivタグで囲まれたHTMLコードのみを提供する必要があります。職務概要、活用可能な経験知識、保有スキル、経歴事項については、詳細な説明が必要です。経歴書作成というタイトルは必ず必要です。応答の最初と最後に 「```html, ```」と言う文字が表示されないようにする。HTML構造はサンプルと同じように作成する必要があります。
    ' . json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ' 資料に基づいて作成してください。
    フィードバックを提供することができないので、一度で最高の経歴書を作成してください。少なくとも空白の値が返ってきたらダメです。
    繰り返しになりますが、HTML構造がサンプルと全く同じでなければならず、生成結果の最初と最後に「```html, ```」などの文字が絶対に入ってはいけません。
    経験分野・内容、活用可能な経験知識、将来の展望、保有スキルなど、各項目について100文字以上で豊富に作成しなければならない。

    <div class="bg-gray-100 pt-15">
        <div class="bg-white w-full p-6 pb-10 pt-16 rounded-lg shadow-md m-auto">
            <h1 class="text-2xl font-bold text-center mb-4">職務経歴書</h1>
            <div class="text-right mb-4">
                <p class="text-sm">日付: ' . date('Y年m月d日') . '</p>
                <p class="text-sm">氏名: ' . htmlspecialchars($details['username']) . '</p>
            </div>

            <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">経験分野・内容</h2>
            <p class="mb-4">' . htmlspecialchars($details['job_summary']) . '</p>

            <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">活用可能な経験知識</h2>
            <p class="mb-4">' . htmlspecialchars($details['experience_reason']) . '</p>

            <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">将来の展望</h2>
            <p class="mb-4">' . htmlspecialchars($details['future_plans']) . '</p>

            <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">保有スキル</h2>
            <ul class="list-disc list-inside mb-4">';

    foreach ($details['skills_experience'] as $skill => $value) {
        $prompt .= '<li>' . ucfirst($skill) . ': ' . htmlspecialchars($value) . '</li>';
    }

    $prompt .= '</ul>

                <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">資格</h2>
                <ul class="list-disc list-inside mb-4">';
    if (!empty($details['qualifications'])) {
        foreach ($details['qualifications'] as $qualification) {
            $prompt .= '<li>' . htmlspecialchars($qualification) . '</li>';
        }
    } else {
        $prompt .= '<li>資格はありません。</li>';
    }
    $prompt .= '</ul>

                <h2 class="text-xl font-semibold border-b-2 border-gray-300 mt-6 mb-2">職務経歴</h2>';

    if (!empty($details['job_history'])) {
        $prompt .= '
                    <table class="min-w-full bg-white border border-blue-700 mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">期間</th>
                                <th class="border px-4 py-2">業務内容</th>
                                <th class="border px-4 py-2">環境</th>
                                <th class="border px-4 py-2">役割</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($details['job_history'] as $job) {
            $prompt .= '
                            <tr>
                                <td class="border px-4 py-2">' . htmlspecialchars($job['start_date']) . ' - ' . htmlspecialchars($job['end_date']) . '</td>
                                <td class="border px-4 py-2">' . htmlspecialchars($job['job_name']) . '</td>
                                <td class="border px-4 py-2">' . htmlspecialchars($job['experience_details']) . '</td>
                                <td class="border px-4 py-2">' . htmlspecialchars($job['role']) . '</td>
                            </tr>';
        }

        $prompt .= '
                        </tbody>
                    </table>';
    }

    $prompt .= '
            </div>
        </div>
    ';

    return $prompt;

    }


}
