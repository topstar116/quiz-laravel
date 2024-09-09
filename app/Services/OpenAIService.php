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

    // Create job history entries
    $job_history_entries = '';
    foreach ($details['job_history'] as $job) {
        $job_history_entries .= <<<EOT
        {
            "start_date": "{$job['start_date']}",
            "end_date": "{$job['end_date']}",
            "job_name": "{$job['job_name']}",
            "team_size": "{$job['team_size']}",
            "role": "{$job['role']}",
            "experience_details": "{$job['experience_details']}"
        },
    EOT;
    }

// Trim the last comma from the job history entries
$job_history_entries = rtrim($job_history_entries, ',');
    // Start building the prompt
    $prompt = <<<EOT

    Please generate a resume in JSON format based on the following input.

        1. For the 'job_summary', combine the provided "education", "career_history", and "future_plans" into a sentence that is at least 100 characters long.

        2. For the 'skills_experience', summarize the use of Excel, PowerPoint, and leadership skills into a single sentence, based on the input values (Yes/No).

        Return the output in the following JSON format:

        {
        "job_title": "[Selected job title]",
        "job_summary": "Specialized job summary sentence based on input values (100 characters or more)",
        "skills_experience": "One sentence summarizing skills based on input",
        "skillset": ["List of individual skills"],
        "qualifications": ["List of qualifications"],
        "job_history": [
            {
            "start_date": "[Start date]",
            "end_date": "[End date]",
            "job_name": "[Job title]",
            "team_size": "[Number of team members]",
            "role": "[Role]",
            "experience_details": "[Bullet points describing job experience. It should be written simply and clearly, yet professionally, based on the inputted material.]"
            }
        ]
        }

        Inputs:

        {
        "job_title": "{$details['job_title']}",
        "education": "{$details['job_education']}",
        "career_history": "{$details['experience_reason']}",
        "future_plans": "{$details['future_plans']}",
        "excel": "{$details['skills_experience']['excel']}",
        "ppt": "{$details['skills_experience']['ppt']}",
        "leadership": "{$details['skills_experience']['leadership']}",
        "skillset": "{$details['skillset']}",
        "qualifications": "{$details['qualifications']}",
        "job_history": [
            $job_history_entries
        ]
        }

        Please ensure the 'job_summary' is at least 100 characters, and return the final output as JSON only.
        Please ensure the output contains **only** the JSON object without explanations.
        The data you receive from OpenAI also reflects what you didn not enter.
        You only need to change the wording to make it look good based on what you entered.
        Do not return anything like ```json or ``` before or after the data, only json data should be returned.
 EOT;

    return $prompt;

    }


}
