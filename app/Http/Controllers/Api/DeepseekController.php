<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeepseekController extends Controller
{
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');

        $response = Http::post( env('DEEPSEEK_OLLAMA_URL') . '/api/generate', [
            'model' => 'deepseek-r1',
            'prompt' => $prompt
        ]);

        return response()->json($response->json());
    }
}
