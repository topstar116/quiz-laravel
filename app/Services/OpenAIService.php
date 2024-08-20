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
        return "
        
           あなたはウェブ開発者です。プロフェッショナルな履歴書のために、以下のセクションを含むHTMLページを作成してください。上記のコードはサンプルコードです。スタイリングはTailwindCSSを使用する必要があり、HTMLコードのみを提供する必要があります。 最初の説明文や最後の説明文のようなものを提供せず、resume_tableというクラス名を持つdivタグで囲まれたHTMLコードのみを提供する必要があります。 職務概要、活用可能な経験知識、保有スキル、経歴事項については、詳細な説明が必要です。経歴書作成というタイトルは必ず必要です。応答の最初と最後に ```html ``` と言う文字が表示されないようにする。:

        <div class='font-sans bg-gray-100 p-8'>
          <div class='bg-white shadow-md rounded-lg p-10 max-w-3xl mx-auto'>
            <div class='text-center p-10'>
              <h1 class='text-2xl font-bold mb-6'>職務経歴書</h1>
            </div>

            <!-- Job Summary Section -->
            <section class='mb-8'>
                <h2 class='font-semibold mb-2 text-gray-800'> 職務要約</h2>
                <p class='mb-6 text-gray-800 tracking-wide'>
                    {$details['job_title']}
                </p>
                <h2 class='font-semibold mb-2 text-gray-800'> 活かせる経験・知識</h2>
                <ul class='list-disc list-inside ml-4 mb-6 text-gray-800 tracking-wide'>
                    <li>{$details['job_summary']}</li>
                </ul>
                <h2 class='font-semibold mb-2 text-gray-800'> 保有技術</h2>
                <ul class='list-disc list-inside ml-4 mb-6 text-gray-800 tracking-wide'>
                    <li>{$details['skills_experience']}</li>
                </ul>
            </section>

            <!-- Work Experience Section -->
            <section>
                <h2 class='font-semibold mb-4 text-gray-800'> 経歴詳細 (直近のものから記載)</h2>
                <table class='w-full border-collapse'>
                    <thead>
                        <tr>
                            <th class='border px-4 py-2 w-1/4 text-gray-800'>期間</th>
                            <th class='border px-4 py-2 w-3/4 text-gray-800'>担当業務 (プロジェクト内容)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        {$details['job_history']}
                        </tr>
                        <tr>
                            <td class='border px-4 py-2 align-top'>2014年04月〜<br>2016年4月</td>
                            <td class='border px-4 py-2 align-top text-gray-800'>
                                <b>【プロジェクト】</b> 直販家具商品の企画設計<br>
                                <b>【メンバー数】</b> 10人<br>
                                <div class='flex'>
                                  <b>【業務内容】</b>
                                  <ul class='list-disc list-inside ml-4 text-gray-800'>
                                      <li>商品企画書作成と社内提案</li>
                                      <li>承認後にCAD設計資料作成</li>
                                      <li>ベトナム工場等と技術支援</li>
                                      <li>進捗・品質管理、納品後の確認</li>
                                  </ul>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
          </div>
        </div>
        ";
    }
}
