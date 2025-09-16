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
            'messages.*.role' => 'required|string|in:user,assistant',
            'messages.*.content' => 'required|string',
            'context' => 'required|string',
        ]);

        $client = new Client([
            'base_uri' => 'http://172.22.160.1:11434',
            'timeout'  => 0,
        ]);

        $contextRules = "You are an AI assistant that works as a teacher." .
            "Your primary goal is to help users by answering questions based on the provided context (Lesson)." .
            "Always adhere to the following rules:" .
            "1.  **Context is King**: Only use the information present in the provided \"pageContext\" to formulate your answers." .
            "2.  **Clarify Ambiguity**: If a question is unclear or could be interpreted in multiple ways based on the context, ask for clarification from the user." .
            "3.  **No External Knowledge**: Do not use any knowledge outside of the \"pageContext\". If the answer is not found within the context, explicitly state that you do not have enough information to answer and do not make up any details." .
            "4.  **Be Concise and Direct**: Provide answers directly and avoid unnecessary elaborations unless the context warrants it." .
            "5.  **Polite Refusal**: If asked to perform tasks outside your scope (e.g., generating code, providing opinions, or discussing topics not related to the context), politely decline.";

        $ollamaMessages = [
            [
                'role' => 'system',
                'content' => $contextRules . "\n\nContext: " . $validated['context']
            ],
            ...$validated['messages']
        ];

        return new StreamedResponse(function () use ($client, $ollamaMessages) {
            // Explicitly start output buffering if not already active
            if (ob_get_level() == 0) {
                ob_start();
            }

            try {
                $response = $client->post('/api/chat', [
                    'json' => [
                        'model' => 'llama3.2',
                        'messages' => $ollamaMessages,
                        'stream' => true,
                    ],
                    'stream' => true,
                ]);

                $stream = $response->getBody();

                while (!$stream->eof()) {
                    $chunk = $stream->read(1024);
                    echo $chunk;
                    // Only flush if there's an active buffer
                    if (ob_get_level() > 0) {
                        ob_flush();
                    }
                    flush(); // Flush the system output buffer
                }
            } catch (\Exception $e) {
                // If an error occurs, try to send it, but respect output buffering status
                $errorMessage = json_encode(['error' => 'Failed to connect to Ollama service: ' . $e->getMessage()]);
                echo $errorMessage;
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            } finally {
                // Ensure the output buffer is cleaned up after streaming, if it was started here
                if (ob_get_level() > 0 && ob_list_handlers()[ob_get_level() - 1] === __NAMESPACE__ . '\ChatController::__invoke::{closure}') {
                    ob_end_flush(); // or ob_end_clean() depending on whether you want to discard or send remaining content
                }
            }
        }, 200, [
            'Content-Type' => 'application/x-ndjson',
            'X-Accel-Buffering' => 'no', // Important for Nginx to not buffer
            'Cache-Control' => 'no-cache, no-store, must-revalidate', // Prevent caching
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
