<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAuthService;

class SocialiteController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    /**
     * Redirect user to the provider's authentication page.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function redirectToProvider(string $provider)
    {
        $state = bin2hex(random_bytes(16)); // Generate a random state token
        cache()->put('oauth_state_' . $state, $state, now()->addMinutes(10)); // Store in cache

        return response()->json([
            'redirect_url' => Socialite::driver($provider)->with(['state' => $state])->redirect()->getTargetUrl()
        ]);
    }    

    /**
     * Handle the authentication callback from provider.
     *
     * @param SocialAuthRequest $request
     * @return JsonResponse
     */
    public function handleProviderCallback(SocialAuthRequest $request)
    {
        try {
            $user = $this->socialAuthService->handleProviderCallback($request->provider);
            return response()->json([
                'message' => 'Authenticated successfully',
                'user' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
