<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Api\DeepseekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('books', BookController::class);

Route::prefix('auth')->group(function () {
    Route::get('/redirect/{provider}', [SocialiteController::class, 'redirectToProvider'])->middleware('web');
    Route::post('/callback', [SocialiteController::class, 'handleProviderCallback']);
});

Route::post('/deepseek/chat', [DeepseekController::class, 'chat']);