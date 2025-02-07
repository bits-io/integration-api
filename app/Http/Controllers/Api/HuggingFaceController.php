<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HuggingFaceController extends Controller
{
    public function textToImage(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $apiKey = env('HUGGINGFACE_API_KEY');
        $model = env('HUGGINGFACE_MODEL', 'stabilityai/stable-diffusion-2');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json'
        ])->withOptions([
            'verify' => false
        ])
        ->post("https://api-inference.huggingface.co/models/{$model}", [
            'inputs' => $request->input('text')
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to generate image'], 500);
        }

        return response()->json([
            'image_url' => 'data:image/png;base64,' . base64_encode($response->body())
        ]);
    }
}
