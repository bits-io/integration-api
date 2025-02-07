<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepseekController extends Controller
{
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');
        $model = $request->input('model');

        $response = Http::timeout(360)
            ->post(env('DEEPSEEK_OLLAMA_URL') . '/api/generate', [
                'model' => $model,
                'prompt' => $prompt
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch response'], 500);
        }

        $stream = $response->body();

        $lines = explode("\n", trim($stream));

        $fullResponse = '';
        foreach ($lines as $line) {
            $json = json_decode($line, true);
            if (isset($json['response'])) {
                $fullResponse .= $json['response'];
            }
        }

        return response()->json(['response' => trim($fullResponse)]);
    }
}
