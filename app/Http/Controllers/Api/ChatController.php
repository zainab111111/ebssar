<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'messages' => 'required|array',
            'messages.*.role' => 'required|string|in:user,assistant', // Removed 'system'
            'messages.*.content' => 'required|string',
            'context' => 'required|string', // Add context validation
        ]);

        $client = new Client([
            'base_uri' => 'http://localhost:11434',
            'timeout'  => 0,
        ]);

        // Define context rules here on the server
        $contextRules = "You are an AI assistant thats works as a teacher.".
            "Your primary goal is to help users by answering questions based on the provided context (Lesson).".
            "Always adhere to the following rules:".
            "1.  **Context is King**: Only use the information present in the provided \"pageContext\" to formulate your answers.".
            "2.  **Clarify Ambiguity**: If a question is unclear or could be interpreted in multiple ways based on the context, ask for clarification from the user.".
            "3.  **No External Knowledge**: Do not use any knowledge outside of the \"pageContext\". If the answer is not found within the context, explicitly state that you do not have enough information to answer and do not make up any details.".
            "4.  **Be Concise and Direct**: Provide answers directly and avoid unnecessary elaborations unless the context warrants it.".
            "5.  **Polite Refusal**: If asked to perform tasks outside your scope (e.g., generating code, providing opinions, or discussing topics not related to the context), politely decline.";

        // Prepend system message with context rules and context
        $ollamaMessages = [
            [
                'role' => 'system',
                'content' => $contextRules . "\n\nContext: " . $validated['context']
            ],
            ...$validated['messages'] // Spread the user messages
        ];

        return new StreamedResponse(function () use ($client, $ollamaMessages) {
            try {
                $response = $client->post('/api/chat', [
                    'json' => [
                        'model' => 'llama3.2',
                        'messages' => $ollamaMessages,
                        'stream' => true,
                        'options' => [
                            'temperature' => 0.1,
                            'top_p' => 0.9,
                        ]
                    ],
                    'stream' => true,
                ]);

                $stream = $response->getBody();

                while (!$stream->eof()) {
                    $chunk = $stream->read(1024);
                    echo $chunk;
                    ob_flush();
                    flush();
                }
            } catch (\Exception $e) {
                echo json_encode(['error' => 'Failed to connect to Ollama service: ' . $e->getMessage()]);
            }
        }, 200, [
            'Content-Type' => 'application/x-ndjson',
            'X-Accel-Buffering' => 'no',
            'Cache-Control' => 'no-cache',
        ]);
    }
}
